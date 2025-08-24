<?php

namespace App\Livewire\Admin;

use App\Models\{Producties, invoiceitems, Clients, invoices};
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Clientinvoices extends Component
{
    Public $clientId, $invoiceId, $invoice_items, $control_number, $TotalAmount, $Status, $client, $products, $invoice ;
    public $product_id, $quantity, $amount, $isEditMode = false, $description;
    public function mount($clientId, $invoiceId)
    {
        $this->clientId = $clientId;
        $this->invoiceId = $invoiceId;
        $this->client = Clients::findOrFail($clientId);
        $this->invoice_items = invoiceitems::where('invoice_id', $invoiceId)->get();
        $this->invoice = invoices::findOrFail($invoiceId);
        $this->products = Producties::all();
    }

    public function render()
    {
        return view('livewire.admin.clientinvoices');
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
            $this->reset();
            $this->listinvoices();
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
            $this->reset();
            $this->listinvoices();
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
            $this->invoice_items = invoiceitems::where('invoice_id', $id)->get(); // Refresh list
        }
    }
}
