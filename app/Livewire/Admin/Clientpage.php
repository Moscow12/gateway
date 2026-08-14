<?php

namespace App\Livewire\Admin;

use App\Models\Clients;
use App\Models\ClientService;
use App\Models\ClientServiceSubscription;
use App\Models\invoiceitems;
use App\Models\invoices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Clientpage extends Component
{
    use WithFileUploads;

    public $invoices = [], $selectedInvoices = [], $selectAll = false, $invoice_s, $invoiceId, $clientId;
    public $search = '', $categories;
    public $isEditMode = false;
    public $control_number, $TotalAmount, $Status, $statusAmount;
    public $client, $clientServices;

    // Subscription form fields
    public $subscriptionClientServiceId;
    public $price;
    public $billing_interval_months = 1;
    public $contract_attachment;
    public $existing_contract_attachment;
    public $isSubscriptionEditMode = false;

    public function mount($id)
    {
        $this->clientId = $id;
        $this->client = Clients::findOrFail($id);
        $this->invoices = invoices::where('client_id', $id)->get();
        $this->clientServices = ClientService::with(['serviceType', 'subscription'])
            ->where('client_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
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

    public function editSubscription($clientServiceId)
    {
        $clientService = ClientService::with('subscription')->findOrFail($clientServiceId);
        $this->subscriptionClientServiceId = $clientServiceId;

        if ($clientService->subscription) {
            $this->price = $clientService->subscription->price;
            $this->billing_interval_months = $clientService->subscription->billing_interval_months;
            $this->existing_contract_attachment = $clientService->subscription->contract_attachment;
            $this->isSubscriptionEditMode = true;
        } else {
            $this->price = null;
            $this->billing_interval_months = 1;
            $this->existing_contract_attachment = null;
            $this->isSubscriptionEditMode = false;
        }

        $this->contract_attachment = null;
    }

    public function saveSubscription()
    {
        $this->validate([
            'price' => 'required|numeric|min:0',
            'billing_interval_months' => 'required|integer|min:1',
            'contract_attachment' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = [
            'client_service_id' => $this->subscriptionClientServiceId,
            'price' => $this->price,
            'billing_interval_months' => $this->billing_interval_months,
        ];

        if ($this->contract_attachment) {
            if ($this->existing_contract_attachment) {
                Storage::disk('public')->delete($this->existing_contract_attachment);
            }
            $data['contract_attachment'] = $this->contract_attachment->store('contracts', 'public');
        }

        ClientServiceSubscription::updateOrCreate(
            ['client_service_id' => $this->subscriptionClientServiceId],
            $data
        );

        session()->flash('message', 'Subscription saved successfully.');
        $this->resetSubscriptionForm();
        $this->clientServices = ClientService::with(['serviceType', 'subscription'])
            ->where('client_id', $this->clientId)
            ->orderBy('created_at', 'desc')
            ->get();
        $this->dispatch('close-subscription-modal');
    }

    public function resetSubscriptionForm()
    {
        $this->reset(['subscriptionClientServiceId', 'price', 'contract_attachment', 'existing_contract_attachment', 'isSubscriptionEditMode']);
        $this->billing_interval_months = 1;
    }

    public function generateRenewalInvoice($clientServiceId)
    {
        $clientService = ClientService::with('subscription')->findOrFail($clientServiceId);

        if (!$clientService->subscription) {
            session()->flash('error', 'Cannot generate invoice: no subscription configured for this service.');
            return;
        }

        $result = ClientServiceSubscription::createRenewalInvoice(
            $this->client,
            $clientService->subscription->billing_interval_months
        );

        if ($result) {
            session()->flash('message', 'Invoice generated successfully.');
            $this->invoices = invoices::where('client_id', $this->clientId)->get();
        } else {
            session()->flash('error', 'Failed to generate invoice.');
        }
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
            // Delete invoice items first — invoiceitems.invoice_id is ON DELETE RESTRICT
            invoiceitems::where('invoice_id', $invoice->id)->delete();

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
