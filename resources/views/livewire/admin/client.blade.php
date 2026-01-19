<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Clients</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Client Management</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button wire:click="resetFormFields" data-bs-toggle="modal" data-bs-target="#clientModal" class="btn btn-primary radius-30">
                <i class="bx bx-plus"></i> Add New Client
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
        <div class="col-md-3">
            <div class="card radius-10 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Clients</p>
                            <h4 class="my-1 text-primary">{{ count($clients) }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-primary bg-opacity-10 text-primary ms-auto">
                            <i class="bx bx-group"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card radius-10 border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">With Email</p>
                            <h4 class="my-1 text-success">{{ collect($clients)->whereNotNull('clientemail')->where('clientemail', '!=', '')->count() }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-success bg-opacity-10 text-success ms-auto">
                            <i class="bx bx-envelope"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card radius-10 border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Selected</p>
                            <h4 class="my-1 text-warning">{{ count($selectedClients) }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-warning bg-opacity-10 text-warning ms-auto">
                            <i class="bx bx-check-square"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card radius-10 border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">SMS Categories</p>
                            <h4 class="my-1 text-info">{{ count($categories) }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-info bg-opacity-10 text-info ms-auto">
                            <i class="bx bx-category"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clients Table Card -->
    <div class="card radius-10">
        <div class="card-header bg-transparent">
            <div class="row g-3 align-items-center">
                <!-- Search -->
                <div class="col-md-4">
                    <div class="position-relative">
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               class="form-control ps-5 radius-30"
                               placeholder="Search clients...">
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

                <!-- SMS Category Filter -->
                <div class="col-md-3">
                    <select class="form-select radius-30">
                        <option value="">All SMS Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Send SMS Button -->
                <div class="col-md-2">
                    @if(count($selectedClients) > 0)
                        <a href="{{ route('sendsms') }}" class="btn btn-success radius-30 w-100">
                            <i class="bx bx-message-rounded"></i> Send SMS ({{ count($selectedClients) }})
                        </a>
                    @else
                        <button class="btn btn-outline-secondary radius-30 w-100" disabled>
                            <i class="bx bx-message-rounded"></i> Send SMS
                        </button>
                    @endif
                </div>

                <!-- Results Count -->
                <div class="col-md-3 text-end">
                    <span class="text-muted">
                        Showing {{ count($clients) }} clients
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">
                                <div class="form-check">
                                    <input type="checkbox" wire:model.live="selectAll" class="form-check-input" id="selectAllClients">
                                    <label class="form-check-label" for="selectAllClients"></label>
                                </div>
                            </th>
                            <th>#</th>
                            <th>Client</th>
                            <th>Contact</th>
                            <th>Location</th>
                            <th>Code</th>
                            <th style="width: 150px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clients as $index => $client)
                            <tr class="{{ in_array($client->id, $selectedClients) ? 'table-active' : '' }}">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               value="{{ $client->id }}"
                                               wire:model.live="selectedClients"
                                               id="client-{{ $client->id }}">
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="client-avatar bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                            <span class="text-primary fw-bold">{{ strtoupper(substr($client->clientname, 0, 2)) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $client->clientname }}</h6>
                                            <small class="text-muted">
                                                <i class="bx bx-envelope me-1"></i>{{ $client->clientemail ?: 'No email' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-phone text-success me-2"></i>
                                        <span>{{ $client->clientphone }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($client->clientcity || $client->clientaddress)
                                        <div>
                                            <span>{{ $client->clientcity ?: '-' }}</span>
                                            @if($client->clientaddress)
                                                <small class="text-muted d-block">{{ Str::limit($client->clientaddress, 30) }}</small>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($client->clientcode)
                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                            <i class="bx bx-hash me-1"></i>{{ $client->clientcode }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('clientpage', $client->id) }}"
                                           class="btn btn-sm btn-outline-info radius-30"
                                           title="View Details">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <button wire:click="editClient({{ $client->id }})"
                                                data-bs-toggle="modal" data-bs-target="#clientModal"
                                                class="btn btn-sm btn-outline-primary radius-30"
                                                title="Edit">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $client->id }})"
                                                wire:confirm="Are you sure you want to delete this client?"
                                                class="btn btn-sm btn-outline-danger radius-30"
                                                title="Delete">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bx bx-group fs-1 d-block mb-3"></i>
                                        <h5>No clients found</h5>
                                        <p class="mb-3">Get started by adding your first client.</p>
                                        <button wire:click="resetFormFields" data-bs-toggle="modal" data-bs-target="#clientModal" class="btn btn-primary radius-30">
                                            <i class="bx bx-plus"></i> Add Client
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add/Edit Client Modal -->
    <div class="modal fade" id="clientModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 bg-primary bg-opacity-10">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon bg-primary text-white rounded-circle p-2 me-3">
                            <i class="bx {{ $isEditMode ? 'bx-edit' : 'bx-user-plus' }} fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0">{{ $isEditMode ? 'Edit Client' : 'Add New Client' }}</h5>
                            <small class="text-muted">{{ $isEditMode ? 'Update client information' : 'Fill in the client details below' }}</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="clientform">
                    <div class="modal-body">
                        <div class="row g-4">
                            <!-- Client Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-user me-1 text-primary"></i> Client Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       wire:model="clientname"
                                       class="form-control form-control-lg @error('clientname') is-invalid @enderror"
                                       placeholder="Enter client name">
                                @error('clientname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Client Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-envelope me-1 text-success"></i> Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                       wire:model="clientemail"
                                       class="form-control form-control-lg @error('clientemail') is-invalid @enderror"
                                       placeholder="example@email.com">
                                @error('clientemail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Client Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-phone me-1 text-warning"></i> Phone Number <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       wire:model="clientphone"
                                       class="form-control form-control-lg @error('clientphone') is-invalid @enderror"
                                       placeholder="0756077533">
                                @error('clientphone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Must start with 0 and be 10 digits</div>
                            </div>

                            <!-- Client City -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-buildings me-1 text-info"></i> City
                                </label>
                                <input type="text"
                                       wire:model="clientcity"
                                       class="form-control form-control-lg"
                                       placeholder="Enter city">
                            </div>

                            <!-- Client Address -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-map me-1 text-danger"></i> Address
                                </label>
                                <input type="text"
                                       wire:model="clientaddress"
                                       class="form-control form-control-lg"
                                       placeholder="Enter address">
                            </div>

                            <!-- Client Country -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-globe me-1 text-secondary"></i> Country
                                </label>
                                <input type="text"
                                       wire:model="clientcountry"
                                       class="form-control form-control-lg"
                                       placeholder="Enter country">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-light">
                        <button type="button" class="btn btn-secondary radius-30 px-4" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary radius-30 px-4">
                            <i class="bx bx-save"></i> {{ $isEditMode ? 'Update Client' : 'Save Client' }}
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
        .client-avatar {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        .modal-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .table-active {
            background-color: rgba(13, 110, 253, 0.05) !important;
        }
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>

    @script
    <script>
        $wire.on('close-modal', () => {
            const modalEl = document.getElementById('clientModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        });
    </script>
    @endscript
</div>
