<?php

namespace App\Livewire\Admin;

use App\Models\Clients;
use App\Models\Smscategories;
use App\Models\invoices;
use App\Models\ClientService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Client extends Component
{
    public $clients = [], $selectedClients = [], $selectAll = false, $client_s, $clientId;
    public $search = '', $categories;
    public $statusFilter = 'all';
    public $isEditMode = false;
    public $clientname, $clientemail, $clientphone, $clientaddress, $clientcity, $clientcountry, $clientcode;

    // Statistics
    public $totalClients = 0;
    public $paidClients = 0;
    public $activeClients = 0;
    public $expiredClients = 0;
    public $expiringSoonClients = 0;

    public function mount($id = null)
    {
        if ($id) {
            $this->isEditMode = true;
            $this->client_s = Clients::findOrFail($id);
            $this->clientId = $id;
            $this->clientname = $this->client_s->clientname;
            $this->clientemail = $this->client_s->clientemail;
            $this->clientphone = $this->client_s->clientphone;
            $this->clientaddress = $this->client_s->clientaddress;
            $this->clientcity = $this->client_s->clientcity;
            $this->clientcountry = $this->client_s->clientcountry;
        }
        $this->categories = Smscategories::all();
        $this->loadStatistics();
        $this->listclients();
    }

    public function render()
    {
        return view('livewire.admin.client');
    }

    public function loadStatistics()
    {
        $this->totalClients = Clients::count();

        // Clients with paid invoices (all invoices paid)
        $this->paidClients = Clients::whereHas('invoices', function($q) {
            $q->where('Status', 'Paid');
        })->whereDoesntHave('invoices', function($q) {
            $q->whereIn('Status', ['Active', 'Pending']);
        })->count();

        // Clients with active invoices (pending payment)
        $this->activeClients = Clients::whereHas('invoices', function($q) {
            $q->where('Status', 'Active');
        })->count();

        // Clients with expired invoices or services
        $this->expiredClients = Clients::where(function($query) {
            $query->whereHas('invoices', function($q) {
                $q->where('Status', 'Expired');
            })->orWhereHas('services', function($q) {
                $q->where('status', 'license_expired');
            });
        })->count();

        // Clients with services expiring within 30 days
        $this->expiringSoonClients = Clients::whereHas('services', function($q) {
            $q->where('status', 'active')
              ->where('license_end_date', '<=', Carbon::now()->addDays(30))
              ->where('license_end_date', '>', Carbon::now());
        })->count();
    }

    public function updatedStatusFilter()
    {
        $this->listclients();
    }

    public function updatedSearch()
    {
        $this->listclients();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedClients = collect($this->clients)->pluck('id')->toArray();
        } else {
            $this->selectedClients = [];
        }
    }

    public function updatedSelectedClients($id)
    {
        $this->selectAll = count($this->selectedClients) === count($this->clients);
    }
   

    public function clientform(){
        $this->validate([
            'clientname' => 'required|string|max:255',
            'clientemail' => 'required|string|email|max:255',
            'clientphone' => 'required|regex:/^0[1-9][0-9]{8}$/',           
        ], ['clientphone.regex' => 'Phone must start with 0 and be exactly 10 digits. e.g 0756077533',]);
        $this->clientcode = Str::random(4).Date::now()->format('M').Date::now()->format('d').Date::now()->format('y');
        if ($this->isEditMode) {
            $client = Clients::findOrFail($this->clientId);
            $client->update([
                'clientname' => $this->clientname,
                'clientemail' => $this->clientemail,
                'clientphone' => $this->clientphone,
                'clientaddress' => $this->clientaddress,
                'clientcity' => $this->clientcity,
                'clientcountry' => $this->clientcountry,
            ]);
            session()->flash('message', 'Client updated successfully.');
            $this->resetFormFields();
            $this->loadStatistics();
            $this->listclients();
            $this->dispatch('close-modal');
        } else {
            Clients::create([
                'clientname' => $this->clientname,
                'clientemail' => $this->clientemail,
                'clientphone' => $this->clientphone,
                'clientaddress' => $this->clientaddress,
                'clientcity' => $this->clientcity,
                'clientcode' => Str::upper($this->clientcode),
                'clientcountry' => $this->clientcountry,
                'added_by' => Auth::user()->id
            ]);
            session()->flash('message', 'Client added successfully.');
            $this->resetFormFields();
            $this->loadStatistics();
            $this->listclients();
            $this->dispatch('close-modal');
        }
    }
    public function listclients()
    {
        $query = Clients::query();

        // Apply search filter
        if ($this->search) {
            $query->where(function($q) {
                $q->where('clientname', 'like', '%' . $this->search . '%')
                  ->orWhere('clientemail', 'like', '%' . $this->search . '%')
                  ->orWhere('clientphone', 'like', '%' . $this->search . '%')
                  ->orWhere('clientcode', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        switch ($this->statusFilter) {
            case 'paid':
                $query->whereHas('invoices', function($q) {
                    $q->where('Status', 'Paid');
                })->whereDoesntHave('invoices', function($q) {
                    $q->whereIn('Status', ['Active', 'Pending']);
                });
                break;

            case 'active':
                $query->whereHas('invoices', function($q) {
                    $q->where('Status', 'Active');
                });
                break;

            case 'expired':
                $query->where(function($q) {
                    $q->whereHas('invoices', function($inv) {
                        $inv->where('Status', 'Expired');
                    })->orWhereHas('services', function($svc) {
                        $svc->where('status', 'license_expired');
                    });
                });
                break;

            case 'expiring_soon':
                $query->whereHas('services', function($q) {
                    $q->where('status', 'active')
                      ->where('license_end_date', '<=', Carbon::now()->addDays(30))
                      ->where('license_end_date', '>', Carbon::now());
                });
                break;
        }

        $this->clients = $query->with(['invoices', 'services'])->get();
    }

    public function getClientStatus($client)
    {
        // Check for expiring soon services first
        $expiringSoon = $client->services()
            ->where('status', 'active')
            ->where('license_end_date', '<=', Carbon::now()->addDays(30))
            ->where('license_end_date', '>', Carbon::now())
            ->exists();

        if ($expiringSoon) {
            return ['status' => 'expiring_soon', 'label' => 'Expiring Soon', 'class' => 'warning'];
        }

        // Check for expired
        $hasExpired = $client->invoices()->where('Status', 'Expired')->exists() ||
                      $client->services()->where('status', 'license_expired')->exists();

        if ($hasExpired) {
            return ['status' => 'expired', 'label' => 'Expired', 'class' => 'danger'];
        }

        // Check for active invoices
        $hasActive = $client->invoices()->where('Status', 'Active')->exists();

        if ($hasActive) {
            return ['status' => 'active', 'label' => 'Active Invoice', 'class' => 'info'];
        }

        // Check for all paid
        $hasPaid = $client->invoices()->where('Status', 'Paid')->exists();
        $hasUnpaid = $client->invoices()->whereIn('Status', ['Active', 'Pending'])->exists();

        if ($hasPaid && !$hasUnpaid) {
            return ['status' => 'paid', 'label' => 'Paid', 'class' => 'success'];
        }

        // Default - no invoices or pending
        return ['status' => 'none', 'label' => 'No Invoice', 'class' => 'secondary'];
    }

    public function delete($id)
    {
        $item = Clients::find($id);
        if ($item) {
            $item->delete();
            $this->loadStatistics();
            $this->listclients();
            session()->flash('message', 'Client deleted successfully.');
        }
    }

    public function editClient($id)
    {
        $this->resetFormFields();
        $this->isEditMode = true;
        $client = Clients::findOrFail($id);
        $this->clientId = $id;
        $this->clientname = $client->clientname;
        $this->clientemail = $client->clientemail;
        $this->clientphone = $client->clientphone;
        $this->clientaddress = $client->clientaddress;
        $this->clientcity = $client->clientcity;
        $this->clientcountry = $client->clientcountry;
    }

    public function resetFormFields()
    {
        $this->clientId = null;
        $this->clientname = '';
        $this->clientemail = '';
        $this->clientphone = '';
        $this->clientaddress = '';
        $this->clientcity = '';
        $this->clientcountry = '';
        $this->isEditMode = false;
        $this->resetValidation();
    }
}
