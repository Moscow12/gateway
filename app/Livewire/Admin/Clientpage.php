<?php

namespace App\Livewire\Admin;

use App\Models\invoiceitems;
use App\Models\invoices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Clientpage extends Component
{
    public $invoices = [], $selectedInvoices = [], $selectAll = false, $invoice_s, $invoiceId, $clientId;
    public $search = '', $categories;  
    public $isEditMode = false; 
    public $control_number, $TotalAmount, $Status, $statusAmount;


    public function mount($id)
    {
        $this->clientId = $id;
        $this->invoices = invoices::where('client_id', $id)->get();
        $this->statusAmount = Invoices::where('client_id', $id)
                                ->join('invoiceitems as it', 'invoices.id', '=', 'it.invoice_id')
                                ->select('invoices.status', DB::raw('SUM(it.amount) as total'), DB::raw('COUNT(it.id) as count'))
                                ->groupBy('invoices.status')
                                ->get();

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
            
            $this->listinvoices();
        }else{
            invoices::create([
                'client_id' => $this->clientId,
                'added_by' => Auth::user()->id
            ]);
            session()->flash('message', 'Invoice added successfully.');        
            
            $this->listinvoices();
        }
    }

    public function listinvoices()
    {
        $this->invoices = invoices::where('client_id', $this->clientId)->get();
    }
    
    public function delete($id)
    {
        $invoice = Invoices::find($id);

        if ($invoice) {
            // Delete invoice
            $invoice->delete();

            // Refresh invoice list for this client
            $this->invoices = Invoices::where('client_id', $invoice->client_id)->get();
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
