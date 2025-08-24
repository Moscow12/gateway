<?php

namespace App\Livewire\Admin;

use App\Models\invoices;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Clientpage extends Component
{
    public $invoices = [], $selectedInvoices = [], $selectAll = false, $invoice_s, $invoiceId, $clientId;
    public $search = '', $categories;  
    public $isEditMode = false; 
    public $control_number, $TotalAmount, $Status;

    public function mount($id)
    {
        $this->clientId = $id;
        $this->invoices = invoices::where('client_id', $id)->get();

    }
    public function render()
    {
        return view('livewire.admin.clientpage');
    }
    
    public function createinvoice()
    {
        if ($this->isEditMode) {
            $invoice = invoices::findOrFail($this->invoiceId);
            $invoice->update([
                'control_number' => $this->control_number,
                'TotalAmount' => $this->TotalAmount,
                'Status' => $this->Status,
            ]);
            session()->flash('message', 'Invoice updated successfully.');
            $this->reset();
            $this->listinvoices();
        }else{
            invoices::create([
                'client_id' => $this->clientId,
                'added_by' => Auth::user()->id
            ]);
            session()->flash('message', 'Invoice added successfully.');        
            $this->reset();
            $this->listinvoices();
        }
    }

    public function listinvoices()
    {
        $this->invoices = invoices::where('client_id', $this->clientId)->get();
    }
    
    public function delete($id)
    {
        $item = invoices::find($id);
        if ($item) {
            $item->delete();
            $this->invoices = invoices::where('client_id', $id)->get(); // Refresh list
        }
    }

    public function clientinvoice($clientId, $invoiceId)
    {
        $this->invoiceId = $invoiceId;
        $this->clientId = $clientId;
        $this->invoice_s = invoices::findOrFail($invoiceId);
        $this->control_number = $this->invoice_s->control_number;
        $this->TotalAmount = $this->invoice_s->TotalAmount;
        $this->Status = $this->invoice_s->Status;
    }
}
