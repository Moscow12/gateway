<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Client Services</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Client Services Management</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#serviceModal" class="btn btn-primary radius-30">
                <i class="bx bx-plus"></i> Add New Service
            </button>
        </div>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-10" role="alert">
            <div class="d-flex align-items-center">
                <div class="fs-3 text-success"><i class="bx bx-check-circle"></i></div>
                <div class="ms-3">
                    <div class="text-success">{{ session('message') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-15 col-lg">
            <div class="card radius-10 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Services</p>
                            <h4 class="my-1 text-primary">{{ $totalServices }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-primary bg-opacity-10 text-primary ms-auto">
                            <i class="bx bx-briefcase"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-15 col-lg">
            <div class="card radius-10 border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Active</p>
                            <h4 class="my-1 text-success">{{ $activeServices }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-success bg-opacity-10 text-success ms-auto">
                            <i class="bx bx-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-15 col-lg">
            <div class="card radius-10 border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Pending</p>
                            <h4 class="my-1 text-warning">{{ $pendingServices }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-warning bg-opacity-10 text-warning ms-auto">
                            <i class="bx bx-time-five"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-15 col-lg">
            <div class="card radius-10 border-start border-danger border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Expired</p>
                            <h4 class="my-1 text-danger">{{ $expiredServices }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-danger bg-opacity-10 text-danger ms-auto">
                            <i class="bx bx-x-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-15 col-lg">
            <div class="card radius-10 border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Expiring Soon</p>
                            <h4 class="my-1 text-info">{{ $expiringSoonServices }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-info bg-opacity-10 text-info ms-auto">
                            <i class="bx bx-bell"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Table Card -->
    <div class="card radius-10">
        <div class="card-header bg-transparent">
            <div class="row g-3 align-items-center">
                <!-- Search -->
                <div class="col-md-3">
                    <div class="position-relative">
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               class="form-control ps-5 radius-30"
                               placeholder="Search client name/code...">
                        <span class="position-absolute top-50 translate-middle-y" style="left: 15px;">
                            <i class="bx bx-search text-secondary"></i>
                        </span>
                        @if($search)
                            <span class="position-absolute top-50 translate-middle-y cursor-pointer"
                                  style="right: 15px;"
                                  wire:click="$set('search', '')">
                                <i class="bx bx-x text-secondary"></i>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="col-md-2">
                    <select wire:model.live="statusFilter" class="form-select radius-30">
                        <option value="">All Statuses</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Client Filter -->
                <div class="col-md-3">
                    <select wire:model.live="clientFilter" class="form-select radius-30">
                        <option value="">All Clients</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->clientname }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Clear Filters -->
                <div class="col-md-2">
                    @if($search || $statusFilter || $clientFilter)
                        <button wire:click="clearFilters" class="btn btn-outline-secondary radius-30 w-100">
                            <i class="bx bx-x"></i> Clear
                        </button>
                    @endif
                </div>

                <!-- Results Count -->
                <div class="col-md-2 text-end">
                    <span class="text-muted">
                        {{ $services->total() }} services
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Active Filters -->
            @if($search || $statusFilter || $clientFilter)
                <div class="mb-3">
                    <span class="text-muted me-2">Active filters:</span>
                    @if($search)
                        <span class="badge bg-info me-1">
                            Search: {{ $search }}
                            <i class="bx bx-x cursor-pointer" wire:click="$set('search', '')"></i>
                        </span>
                    @endif
                    @if($statusFilter)
                        <span class="badge bg-primary me-1">
                            Status: {{ $statuses[$statusFilter] ?? $statusFilter }}
                            <i class="bx bx-x cursor-pointer" wire:click="$set('statusFilter', '')"></i>
                        </span>
                    @endif
                    @if($clientFilter)
                        <span class="badge bg-secondary me-1">
                            Client: {{ $clients->find($clientFilter)?->clientname ?? 'Unknown' }}
                            <i class="bx bx-x cursor-pointer" wire:click="$set('clientFilter', '')"></i>
                        </span>
                    @endif
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th wire:click="sortBy('client_id')" class="cursor-pointer">
                                <div class="d-flex align-items-center">
                                    Client
                                    @if($sortField === 'client_id')
                                        <i class="bx bx-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-arrow-alt ms-1"></i>
                                    @endif
                                </div>
                            </th>
                            <th wire:click="sortBy('service_type_id')" class="cursor-pointer">
                                <div class="d-flex align-items-center">
                                    Service
                                    @if($sortField === 'service_type_id')
                                        <i class="bx bx-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-arrow-alt ms-1"></i>
                                    @endif
                                </div>
                            </th>
                            <th wire:click="sortBy('status')" class="cursor-pointer">
                                <div class="d-flex align-items-center">
                                    Status
                                    @if($sortField === 'status')
                                        <i class="bx bx-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-arrow-alt ms-1"></i>
                                    @endif
                                </div>
                            </th>
                            <th>License Period</th>
                            <th>Days Left</th>
                            <th wire:click="sortBy('created_at')" class="cursor-pointer">
                                <div class="d-flex align-items-center">
                                    Added
                                    @if($sortField === 'created_at')
                                        <i class="bx bx-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-arrow-alt ms-1"></i>
                                    @endif
                                </div>
                            </th>
                            <th style="width: 120px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $index => $service)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $services->firstItem() + $index }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="client-icon bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="bx bx-user text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $service->client->clientname ?? 'Unknown' }}</h6>
                                            @if($service->client->clientcode)
                                                <small class="text-muted">{{ $service->client->clientcode }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="service-icon bg-info bg-opacity-10 rounded-circle p-2 me-2">
                                            <i class="bx {{ $service->serviceType->icon ?? 'bx-cog' }} text-info"></i>
                                        </div>
                                        <span>{{ $service->serviceType->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge {{ $service->status_badge_class }} px-3 py-2">
                                        <i class="bx {{ $service->status_icon }} me-1"></i>
                                        {{ $statuses[$service->status] ?? $service->status }}
                                    </span>
                                </td>
                                <td>
                                    @if($service->license_start_date && $service->license_end_date)
                                        <div>
                                            <small class="text-muted">{{ $service->license_start_date->format('d M Y') }}</small>
                                            <i class="bx bx-right-arrow-alt text-muted mx-1"></i>
                                            <small class="text-muted">{{ $service->license_end_date->format('d M Y') }}</small>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($service->days_left !== null)
                                        @if($service->days_left === 0)
                                            <span class="badge bg-danger">Expired</span>
                                        @elseif($service->days_left <= 30)
                                            <span class="badge bg-warning text-dark">{{ $service->days_left }} days</span>
                                        @else
                                            <span class="badge bg-success">{{ $service->days_left }} days</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <span>{{ $service->created_at->format('d M Y') }}</span>
                                        <small class="text-muted d-block">{{ $service->created_at->format('h:i A') }}</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button wire:click="editService({{ $service->id }})"
                                                data-bs-toggle="modal" data-bs-target="#serviceModal"
                                                class="btn btn-sm btn-outline-primary radius-30"
                                                title="Edit">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button wire:click="deleteService({{ $service->id }})"
                                                wire:confirm="Are you sure you want to delete this client service?"
                                                class="btn btn-sm btn-outline-danger radius-30"
                                                title="Delete">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bx bx-briefcase fs-1 d-block mb-3"></i>
                                        <h5>No client services found</h5>
                                        <p class="mb-3">
                                            @if($search || $statusFilter || $clientFilter)
                                                No services match your current filters.
                                            @else
                                                Get started by adding a service to a client.
                                            @endif
                                        </p>
                                        @if($search || $statusFilter || $clientFilter)
                                            <button wire:click="clearFilters" class="btn btn-outline-primary radius-30">
                                                <i class="bx bx-x"></i> Clear Filters
                                            </button>
                                        @else
                                            <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#serviceModal" class="btn btn-primary radius-30">
                                                <i class="bx bx-plus"></i> Add Service
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($services->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $services->firstItem() }} to {{ $services->lastItem() }} of {{ $services->total() }} entries
                    </div>
                    <div>
                        {{ $services->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Add/Edit Service Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 bg-primary bg-opacity-10">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon bg-primary text-white rounded-circle p-2 me-3">
                            <i class="bx {{ $isEditMode ? 'bx-edit' : 'bx-plus' }} fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0">{{ $isEditMode ? 'Edit Client Service' : 'Add New Client Service' }}</h5>
                            <small class="text-muted">{{ $isEditMode ? 'Update service information' : 'Assign a service to a client' }}</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="saveService">
                    <div class="modal-body">
                        <div class="row g-4">
                            <!-- Client Selection -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-user me-1 text-primary"></i> Client <span class="text-danger">*</span>
                                </label>
                                <select wire:model="client_id"
                                        class="form-select form-select-lg @error('client_id') is-invalid @enderror">
                                    <option value="">Select a client...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">
                                            {{ $client->clientname }}
                                            @if($client->clientcode) ({{ $client->clientcode }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Service Type Selection -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-cog me-1 text-info"></i> Service Type <span class="text-danger">*</span>
                                </label>
                                <select wire:model="service_type_id"
                                        class="form-select form-select-lg @error('service_type_id') is-invalid @enderror">
                                    <option value="">Select a service type...</option>
                                    @foreach($serviceTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('service_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-check-circle me-1 text-success"></i> Status <span class="text-danger">*</span>
                                </label>
                                <div class="row g-3">
                                    <div class="col">
                                        <input type="radio" class="btn-check" wire:model="status" value="active" id="statusActive" autocomplete="off">
                                        <label class="btn btn-outline-success w-100 py-3" for="statusActive">
                                            <i class="bx bx-check-circle fs-4 d-block mb-1"></i>
                                            Active
                                        </label>
                                    </div>
                                    <div class="col">
                                        <input type="radio" class="btn-check" wire:model="status" value="pending" id="statusPending" autocomplete="off">
                                        <label class="btn btn-outline-warning w-100 py-3" for="statusPending">
                                            <i class="bx bx-time-five fs-4 d-block mb-1"></i>
                                            Pending
                                        </label>
                                    </div>
                                    <div class="col">
                                        <input type="radio" class="btn-check" wire:model="status" value="inactive" id="statusInactive" autocomplete="off">
                                        <label class="btn btn-outline-secondary w-100 py-3" for="statusInactive">
                                            <i class="bx bx-pause-circle fs-4 d-block mb-1"></i>
                                            Inactive
                                        </label>
                                    </div>
                                    <div class="col">
                                        <input type="radio" class="btn-check" wire:model="status" value="license_expired" id="statusExpired" autocomplete="off">
                                        <label class="btn btn-outline-danger w-100 py-3" for="statusExpired">
                                            <i class="bx bx-x-circle fs-4 d-block mb-1"></i>
                                            Expired
                                        </label>
                                    </div>
                                    <div class="col">
                                        <input type="radio" class="btn-check" wire:model="status" value="suspended" id="statusSuspended" autocomplete="off">
                                        <label class="btn btn-outline-dark w-100 py-3" for="statusSuspended">
                                            <i class="bx bx-block fs-4 d-block mb-1"></i>
                                            Suspended
                                        </label>
                                    </div>
                                </div>
                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- License Dates -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-calendar me-1 text-primary"></i> License Start Date
                                </label>
                                <input type="date"
                                       wire:model="license_start_date"
                                       class="form-control @error('license_start_date') is-invalid @enderror">
                                @error('license_start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-calendar-check me-1 text-danger"></i> License End Date
                                </label>
                                <input type="date"
                                       wire:model="license_end_date"
                                       class="form-control @error('license_end_date') is-invalid @enderror">
                                @error('license_end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contract Reference -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-file me-1 text-secondary"></i> Contract Reference
                                </label>
                                <input type="text"
                                       wire:model="contract_reference"
                                       class="form-control @error('contract_reference') is-invalid @enderror"
                                       placeholder="e.g., CONTRACT-2024-001">
                                @error('contract_reference')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Next Renewal Date -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-refresh me-1 text-info"></i> Next Renewal Date
                                </label>
                                <input type="date"
                                       wire:model="next_renewal_date"
                                       class="form-control @error('next_renewal_date') is-invalid @enderror">
                                @error('next_renewal_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Last Maintenance Date -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-wrench me-1 text-warning"></i> Last Maintenance Date
                                </label>
                                <input type="date"
                                       wire:model="last_maintenance_date"
                                       class="form-control @error('last_maintenance_date') is-invalid @enderror">
                                @error('last_maintenance_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-note me-1 text-muted"></i> Notes
                                </label>
                                <textarea wire:model="notes"
                                          class="form-control @error('notes') is-invalid @enderror"
                                          rows="3"
                                          placeholder="Additional notes about this service..."></textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-light">
                        <button type="button" class="btn btn-secondary radius-30 px-4" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary radius-30 px-4">
                            <i class="bx bx-save"></i> {{ $isEditMode ? 'Update Service' : 'Save Service' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .cursor-pointer {
            cursor: pointer;
        }
        .widgets-icons-2 {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .client-icon, .service-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .avatar {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
        }
        .modal-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-check:checked + .btn-outline-success {
            background-color: #198754;
            color: white;
        }
        .btn-check:checked + .btn-outline-warning {
            background-color: #ffc107;
            color: #000;
        }
        .btn-check:checked + .btn-outline-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-check:checked + .btn-outline-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-check:checked + .btn-outline-dark {
            background-color: #212529;
            color: white;
        }
    </style>

    @script
    <script>
        $wire.on('close-modal', () => {
            const modalEl = document.getElementById('serviceModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        });
    </script>
    @endscript
</div>
