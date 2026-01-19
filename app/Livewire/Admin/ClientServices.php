<?php

namespace App\Livewire\Admin;

use App\Models\ClientService;
use App\Models\Clients;
use App\Models\ServiceType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ClientServices extends Component
{
    use WithPagination;

    public $client_id, $service_type_id, $status, $license_start_date, $license_end_date;
    public $notes, $contract_reference, $last_maintenance_date, $next_renewal_date;
    public $serviceId;
    public $search = '';
    public $statusFilter = '';
    public $clientFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $isEditMode = false;

    protected $queryString = ['search', 'statusFilter', 'clientFilter'];

    protected function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'service_type_id' => 'required|exists:service_types,id',
            'status' => 'required|in:active,inactive,license_expired,pending,suspended',
            'license_start_date' => 'nullable|date',
            'license_end_date' => 'nullable|date|after_or_equal:license_start_date',
            'notes' => 'nullable|string|max:1000',
            'contract_reference' => 'nullable|string|max:255',
            'last_maintenance_date' => 'nullable|date',
            'next_renewal_date' => 'nullable|date',
        ];
    }

    protected $messages = [
        'client_id.required' => 'Please select a client.',
        'service_type_id.required' => 'Please select a service type.',
        'status.required' => 'Please select a status.',
        'license_end_date.after_or_equal' => 'End date must be after or equal to start date.',
    ];

    public function mount()
    {
        $this->status = ClientService::STATUS_PENDING;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingClientFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function editService($id)
    {
        $this->resetForm();
        $this->isEditMode = true;
        $service = ClientService::findOrFail($id);
        $this->serviceId = $id;
        $this->client_id = $service->client_id;
        $this->service_type_id = $service->service_type_id;
        $this->status = $service->status;
        $this->license_start_date = $service->license_start_date?->format('Y-m-d');
        $this->license_end_date = $service->license_end_date?->format('Y-m-d');
        $this->notes = $service->notes;
        $this->contract_reference = $service->contract_reference;
        $this->last_maintenance_date = $service->last_maintenance_date?->format('Y-m-d');
        $this->next_renewal_date = $service->next_renewal_date?->format('Y-m-d');
    }

    public function saveService()
    {
        $this->validate();

        $data = [
            'client_id' => $this->client_id,
            'service_type_id' => $this->service_type_id,
            'status' => $this->status,
            'license_start_date' => $this->license_start_date ?: null,
            'license_end_date' => $this->license_end_date ?: null,
            'notes' => $this->notes,
            'contract_reference' => $this->contract_reference,
            'last_maintenance_date' => $this->last_maintenance_date ?: null,
            'next_renewal_date' => $this->next_renewal_date ?: null,
        ];

        if ($this->isEditMode) {
            $service = ClientService::findOrFail($this->serviceId);
            $service->update($data);
            session()->flash('message', 'Client service updated successfully.');
        } else {
            $data['added_by'] = Auth::id();
            ClientService::create($data);
            session()->flash('message', 'Client service added successfully.');
        }

        $this->resetForm();
        $this->dispatch('close-modal');
    }

    public function deleteService($id)
    {
        $service = ClientService::find($id);
        if ($service) {
            $service->delete();
            session()->flash('message', 'Client service deleted successfully.');
        }
    }

    public function resetForm()
    {
        $this->serviceId = null;
        $this->client_id = '';
        $this->service_type_id = '';
        $this->status = ClientService::STATUS_PENDING;
        $this->license_start_date = '';
        $this->license_end_date = '';
        $this->notes = '';
        $this->contract_reference = '';
        $this->last_maintenance_date = '';
        $this->next_renewal_date = '';
        $this->isEditMode = false;
        $this->resetValidation();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->clientFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = ClientService::with(['client', 'serviceType', 'user']);

        // Search by client name or client code
        if ($this->search) {
            $query->whereHas('client', function ($q) {
                $q->where('clientname', 'like', '%' . $this->search . '%')
                  ->orWhere('clientcode', 'like', '%' . $this->search . '%');
            });
        }

        // Filter by status
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Filter by client
        if ($this->clientFilter) {
            $query->where('client_id', $this->clientFilter);
        }

        $query->orderBy($this->sortField, $this->sortDirection);

        $services = $query->paginate(10);

        // Statistics
        $totalServices = ClientService::count();
        $activeServices = ClientService::active()->count();
        $pendingServices = ClientService::pending()->count();
        $expiredServices = ClientService::expired()->count();
        $expiringSoonServices = ClientService::expiringSoon(30)->count();

        // Dropdowns data
        $clients = Clients::orderBy('clientname')->get();
        $serviceTypes = ServiceType::orderBy('name')->get();

        return view('livewire.admin.client-services', [
            'services' => $services,
            'totalServices' => $totalServices,
            'activeServices' => $activeServices,
            'pendingServices' => $pendingServices,
            'expiredServices' => $expiredServices,
            'expiringSoonServices' => $expiringSoonServices,
            'clients' => $clients,
            'serviceTypes' => $serviceTypes,
            'statuses' => ClientService::$statuses,
        ]);
    }
}
