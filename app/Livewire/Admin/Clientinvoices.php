<?php

namespace App\Livewire\Admin;

use App\Models\{Producties, invoiceitems, Clients, invoices};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Clientinvoices extends Component
{
    Public $clientId, $invoiceId, $invoice_items, $control_number, $TotalAmount, $Status, $client, $products, $invoice ;
    public $product_id, $quantity, $amount, $isEditMode = false, $description, $invoicetotal;
    public function mount($clientId, $invoiceId)
    {
        $this->clientId = $clientId;
        $this->invoiceId = $invoiceId;
        $this->client = Clients::findOrFail($clientId);
        $this->loadinvoiceitems($invoiceId);
        $this->loadinvoice($invoiceId);
        $this->products = Producties::all();
    }

    public function render()
    {
        return view('livewire.admin.clientinvoices');
    }

    public function loadinvoiceitems($invoiceId)
    {        
        $this->invoice_items = invoiceitems::where('invoice_id', $invoiceId)->get();
    }

    public function loadinvoice($invoiceId)
    {
        $this->invoice = invoices::findOrFail($invoiceId);
    }

    public function addItem()
    {
        $this->validate([
            'product_id' => 'required|string|max:255',
            'quantity' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
        ]);

        if ($this->isEditMode) {
            $invoiceitem = invoiceitems::findOrFail($this->invoiceId);
            $invoiceitem->update([
                'product_id' => $this->product_id,
                'amount' => $this->amount,
                'quantity' => $this->quantity,
                'description' => $this->description,
            ]);
            session()->flash('message', 'Invoice updated successfully.');
            $this->reset(['product_id', 'amount', 'Status', 'description', 'isEditMode']);
            $this->loadinvoiceitems($this->invoiceId);
        }else{
            invoiceitems::create([
                'product_id' => $this->product_id,
                'invoice_id' => $this->invoiceId,
                'amount' => $this->amount,
                'quantity' => $this->quantity,
                'description' => $this->description,
                'added_by' => Auth::user()->id
            ]);
            session()->flash('message', 'Invoice added successfully.');        
            $this->reset(['product_id', 'amount', 'Status', 'description', 'isEditMode']);
            $this->loadinvoiceitems($this->invoiceId);
        }
    }

    public function listinvoices()
    {
        $this->invoice_items = invoiceitems::where('invoice_id', $this->invoiceId)->get();
    }

    public function delete($id)
    {
        $item = invoiceitems::find($id);
        if ($item) {
            $item->delete();
        }
        $this->loadinvoiceitems($this->invoiceId);
    }

    public function generateinvoice()
    {
        // calculate total amount
        $this->invoicetotal = invoiceitems::where('invoice_id', $this->invoiceId)
                            ->select(DB::raw('SUM(amount * quantity) as total'))
                            ->get();
        
        $this->invoice = invoices::findOrFail($this->invoiceId);
        $this->invoice->control_number = rand(80000000, 999900000).$this->clientId.Date::now()->format('y');
        $this->invoice->TotalAmount = $this->invoicetotal[0]->total;
        $this->invoice->ControlNumberExpiretime = now()->addDays(30);
        $this->invoice->controlno_generatedtime = now();
        $this->invoice->Status = 'Active';
        $this->invoice->update();
        // update invoice

        $this->invoice_items = invoices::findOrFail($this->invoiceId)->invoiceitems;
        foreach ($this->invoice_items as $item) {
            $item->update([
                'TotalAmount' => $item->amount * $item->quantity,
                'Status' => 'Active',
            ]);
        }
        session()->flash('message', 'Invoice generated successfully.');
        $this->loadinvoiceitems($this->invoiceId);
    }
}
