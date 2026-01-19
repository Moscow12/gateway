<?php

namespace App\Livewire\Admin;

use App\Models\{Producties, invoiceitems, Clients, invoices, ServiceType};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Clientinvoices extends Component
{
    public $clientId, $invoiceId, $invoice_items, $control_number, $TotalAmount, $Status, $client, $invoice;
    public $serviceTypes, $products;
    public $service_type_id, $product_id, $quantity, $amount, $description;
    public $isEditMode = false, $editItemId;
    public $invoicetotal;
    public $itemType = 'service'; // 'service' or 'product'

    public function mount($clientId, $invoiceId)
    {
        $this->clientId = $clientId;
        $this->invoiceId = $invoiceId;
        $this->client = Clients::findOrFail($clientId);
        $this->loadinvoiceitems($invoiceId);
        $this->loadinvoice($invoiceId);
        $this->serviceTypes = ServiceType::orderBy('name')->get();
        $this->products = Producties::orderBy('productname')->get();
    }

    public function render()
    {
        return view('livewire.admin.clientinvoices');
    }

    public function loadinvoiceitems($invoiceId)
    {
        $this->invoice_items = invoiceitems::with(['serviceType', 'product'])
            ->where('invoice_id', $invoiceId)
            ->get();
    }

    public function loadinvoice($invoiceId)
    {
        $this->invoice = invoices::findOrFail($invoiceId);
        $this->control_number = $this->invoice->control_number;
    }

    public function updatedServiceTypeId($value)
    {
        if ($value) {
            $serviceType = ServiceType::find($value);
            if ($serviceType) {
                $this->amount = $serviceType->base_price;
                $this->quantity = 1;
            }
        }
    }

    public function addItem()
    {
        $rules = [
            'quantity' => 'required|numeric|min:1',
            'amount' => 'required|numeric|min:0',
        ];

        if ($this->itemType === 'service') {
            $rules['service_type_id'] = 'required|exists:service_types,id';
        } else {
            $rules['product_id'] = 'required|exists:products,id';
        }

        $this->validate($rules);

        $data = [
            'invoice_id' => $this->invoiceId,
            'amount' => $this->amount,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'added_by' => Auth::user()->id,
        ];

        if ($this->itemType === 'service') {
            $data['service_type_id'] = $this->service_type_id;
            $data['product_id'] = null;
        } else {
            $data['product_id'] = $this->product_id;
            $data['service_type_id'] = null;
        }

        if ($this->isEditMode && $this->editItemId) {
            $invoiceitem = invoiceitems::findOrFail($this->editItemId);
            $invoiceitem->update($data);
            session()->flash('message', 'Item updated successfully.');
        } else {
            invoiceitems::create($data);
            session()->flash('message', 'Item added successfully.');
        }

        $this->resetItemForm();
        $this->loadinvoiceitems($this->invoiceId);
    }

    public function editItem($id)
    {
        $item = invoiceitems::findOrFail($id);
        $this->isEditMode = true;
        $this->editItemId = $id;
        $this->quantity = $item->quantity;
        $this->amount = $item->amount;
        $this->description = $item->description;

        if ($item->service_type_id) {
            $this->itemType = 'service';
            $this->service_type_id = $item->service_type_id;
            $this->product_id = null;
        } else {
            $this->itemType = 'product';
            $this->product_id = $item->product_id;
            $this->service_type_id = null;
        }
    }

    public function resetItemForm()
    {
        $this->service_type_id = '';
        $this->product_id = '';
        $this->quantity = '';
        $this->amount = '';
        $this->description = '';
        $this->isEditMode = false;
        $this->editItemId = null;
        $this->resetValidation();
    }

    public function delete($id)
    {
        $item = invoiceitems::find($id);
        if ($item) {
            $item->delete();
            session()->flash('message', 'Item deleted successfully.');
        }
        $this->loadinvoiceitems($this->invoiceId);
    }

    public function updateControlNumber()
    {
        $this->validate([
            'control_number' => 'required|string|max:50',
        ]);

        $this->invoice = invoices::findOrFail($this->invoiceId);
        $this->invoice->control_number = $this->control_number;
        $this->invoice->save();

        session()->flash('message', 'Control number updated successfully.');
    }

    public function generateControlNumber()
    {
        $this->control_number = rand(80000000, 999900000) . $this->clientId . Date::now()->format('y');
    }

    public function generateinvoice()
    {
        // Validate control number
        $this->validate([
            'control_number' => 'required|string|max:50',
        ]);

        // Calculate total amount
        $this->invoicetotal = invoiceitems::where('invoice_id', $this->invoiceId)
            ->select(DB::raw('SUM(amount * quantity) as total'))
            ->first();

        $this->invoice = invoices::findOrFail($this->invoiceId);
        $this->invoice->control_number = $this->control_number;
        $this->invoice->TotalAmount = $this->invoicetotal->total ?? 0;
        $this->invoice->ControlNumberExpiretime = now()->addDays(30);
        $this->invoice->controlno_generatedtime = now();
        $this->invoice->Status = 'Active';
        $this->invoice->save();

        // Update invoice items status
        invoiceitems::where('invoice_id', $this->invoiceId)->update([
            'Status' => 'Active',
        ]);

        session()->flash('message', 'Invoice generated successfully.');
        $this->loadinvoiceitems($this->invoiceId);
        $this->loadinvoice($this->invoiceId);
    }

    public function markAsPaid()
    {
        $this->invoice = invoices::findOrFail($this->invoiceId);
        $this->invoice->Status = 'Paid';
        $this->invoice->save();

        session()->flash('message', 'Invoice marked as paid.');
        $this->loadinvoice($this->invoiceId);
    }
}
