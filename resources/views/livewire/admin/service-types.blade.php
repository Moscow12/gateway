<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Service Types</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Service Types Management</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#serviceTypeModal" class="btn btn-primary radius-30">
                <i class="bx bx-plus"></i> Add New Service Type
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
        <div class="col-md-4">
            <div class="card radius-10 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Service Types</p>
                            <h4 class="my-1 text-primary">{{ $totalServiceTypes }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-primary bg-opacity-10 text-primary ms-auto">
                            <i class="bx bx-cog"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card radius-10 border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Recurring</p>
                            <h4 class="my-1 text-success">{{ $recurringTypes }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-success bg-opacity-10 text-success ms-auto">
                            <i class="bx bx-refresh"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card radius-10 border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">One-Time</p>
                            <h4 class="my-1 text-warning">{{ $oneTimeTypes }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-warning bg-opacity-10 text-warning ms-auto">
                            <i class="bx bx-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Types Table Card -->
    <div class="card radius-10">
        <div class="card-header bg-transparent">
            <div class="row g-3 align-items-center">
                <!-- Search -->
                <div class="col-md-6">
                    <div class="position-relative">
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               class="form-control ps-5 radius-30"
                               placeholder="Search service types...">
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

                <!-- Clear Filters -->
                <div class="col-md-3">
                    @if($search)
                        <button wire:click="clearFilters" class="btn btn-outline-secondary radius-30 w-100">
                            <i class="bx bx-x"></i> Clear
                        </button>
                    @endif
                </div>

                <!-- Results Count -->
                <div class="col-md-3 text-end">
                    <span class="text-muted">
                        Showing {{ $serviceTypes->firstItem() ?? 0 }} - {{ $serviceTypes->lastItem() ?? 0 }} of {{ $serviceTypes->total() }} types
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th wire:click="sortBy('name')" class="cursor-pointer">
                                <div class="d-flex align-items-center">
                                    Name
                                    @if($sortField === 'name')
                                        <i class="bx bx-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-arrow-alt ms-1"></i>
                                    @endif
                                </div>
                            </th>
                            <th>Description</th>
                            <th>Duration</th>
                            <th>Type</th>
                            <th wire:click="sortBy('base_price')" class="cursor-pointer">
                                <div class="d-flex align-items-center">
                                    Base Price
                                    @if($sortField === 'base_price')
                                        <i class="bx bx-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-arrow-alt ms-1"></i>
                                    @endif
                                </div>
                            </th>
                            <th>Added By</th>
                            <th style="width: 120px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($serviceTypes as $index => $type)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $serviceTypes->firstItem() + $index }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="service-icon bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="bx {{ $type->icon ?? 'bx-cog' }} text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $type->name }}</h6>
                                            <small class="text-muted">ID: #{{ $type->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $type->description }}">
                                        {{ Str::limit($type->description, 40) ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if($type->default_duration_months)
                                        <span class="badge bg-info bg-opacity-10 text-info">
                                            {{ $type->default_duration_months }} {{ Str::plural('month', $type->default_duration_months) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($type->is_recurring)
                                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                            <i class="bx bx-refresh me-1"></i> Recurring
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                                            <i class="bx bx-check me-1"></i> One-Time
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">{{ number_format($type->base_price, 0) }}</span>
                                    <small class="text-muted">TZS</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-light-primary text-primary rounded-circle me-2">
                                            {{ strtoupper(substr($type->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <span>{{ $type->user->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button wire:click="editServiceType({{ $type->id }})"
                                                data-bs-toggle="modal" data-bs-target="#serviceTypeModal"
                                                class="btn btn-sm btn-outline-primary radius-30"
                                                title="Edit">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button wire:click="deleteServiceType({{ $type->id }})"
                                                wire:confirm="Are you sure you want to delete this service type?"
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
                                        <i class="bx bx-cog fs-1 d-block mb-3"></i>
                                        <h5>No service types found</h5>
                                        <p class="mb-3">
                                            @if($search)
                                                No service types match your search.
                                            @else
                                                Get started by adding your first service type.
                                            @endif
                                        </p>
                                        @if($search)
                                            <button wire:click="clearFilters" class="btn btn-outline-primary radius-30">
                                                <i class="bx bx-x"></i> Clear Search
                                            </button>
                                        @else
                                            <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#serviceTypeModal" class="btn btn-primary radius-30">
                                                <i class="bx bx-plus"></i> Add Service Type
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
            @if($serviceTypes->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $serviceTypes->firstItem() }} to {{ $serviceTypes->lastItem() }} of {{ $serviceTypes->total() }} entries
                    </div>
                    <div>
                        {{ $serviceTypes->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Add/Edit Service Type Modal -->
    <div class="modal fade" id="serviceTypeModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 bg-primary bg-opacity-10">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon bg-primary text-white rounded-circle p-2 me-3">
                            <i class="bx {{ $isEditMode ? 'bx-edit' : 'bx-plus' }} fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0">{{ $isEditMode ? 'Edit Service Type' : 'Add New Service Type' }}</h5>
                            <small class="text-muted">{{ $isEditMode ? 'Update service type information' : 'Fill in the service type details below' }}</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="saveServiceType">
                    <div class="modal-body">
                        <div class="row g-4">
                            <!-- Name -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-text me-1 text-primary"></i> Service Type Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       wire:model="name"
                                       class="form-control form-control-lg @error('name') is-invalid @enderror"
                                       placeholder="e.g., System Installation, Maintenance">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-detail me-1 text-info"></i> Description
                                </label>
                                <textarea wire:model="description"
                                          class="form-control @error('description') is-invalid @enderror"
                                          rows="3"
                                          placeholder="Describe what this service includes..."></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Duration & Base Price -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-calendar me-1 text-warning"></i> Default Duration (Months)
                                </label>
                                <input type="number"
                                       wire:model="default_duration_months"
                                       class="form-control @error('default_duration_months') is-invalid @enderror"
                                       placeholder="e.g., 12"
                                       min="1"
                                       max="120">
                                @error('default_duration_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-dollar me-1 text-success"></i> Base Price (TZS)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">TZS</span>
                                    <input type="number"
                                           wire:model="base_price"
                                           class="form-control @error('base_price') is-invalid @enderror"
                                           placeholder="0.00"
                                           step="0.01"
                                           min="0">
                                    @error('base_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Icon -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-image me-1 text-secondary"></i> Icon (Box Icons class)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx {{ $icon ?: 'bx-cog' }}"></i></span>
                                    <input type="text"
                                           wire:model.live="icon"
                                           class="form-control @error('icon') is-invalid @enderror"
                                           placeholder="e.g., bx-server, bx-wrench">
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Common: bx-server, bx-wrench, bx-book-reader, bx-key, bx-chip, bx-support</div>
                            </div>

                            <!-- Is Recurring -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-refresh me-1 text-primary"></i> Service Type
                                </label>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" wire:model="is_recurring" value="1" id="recurring" autocomplete="off">
                                        <label class="btn btn-outline-success w-100 py-3" for="recurring">
                                            <i class="bx bx-refresh fs-4 d-block mb-1"></i>
                                            Recurring
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" wire:model="is_recurring" value="0" id="onetime" autocomplete="off">
                                        <label class="btn btn-outline-warning w-100 py-3" for="onetime">
                                            <i class="bx bx-check fs-4 d-block mb-1"></i>
                                            One-Time
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-light">
                        <button type="button" class="btn btn-secondary radius-30 px-4" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary radius-30 px-4">
                            <i class="bx bx-save"></i> {{ $isEditMode ? 'Update Service Type' : 'Save Service Type' }}
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
        .service-icon {
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
    </style>

    @script
    <script>
        $wire.on('close-modal', () => {
            const modalEl = document.getElementById('serviceTypeModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        });
    </script>
    @endscript
</div>
