<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Website Content</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Services</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#serviceModal" class="btn btn-primary radius-30">
                <i class="bx bx-plus"></i> Add Service
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

    <!-- Filters -->
    <div class="card radius-10 mb-3">
        <div class="card-body py-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent"><i class="bx bx-search"></i></span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search services...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select wire:model.live="filterStatus" class="form-select">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="featured">Featured</option>
                    </select>
                </div>
                <div class="col-md-4 text-end">
                    <span class="text-muted">{{ $services->total() }} services</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Table -->
    <div class="card radius-10">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">Order</th>
                            <th>Service</th>
                            <th>Description</th>
                            <th>Features</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                            <tr>
                                <td>
                                    <span class="badge bg-primary">{{ $service->order }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="service-icon bg-primary bg-opacity-10 text-primary rounded me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bx {{ $service->icon ?? 'bx-code-alt' }} fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $service->name }}</h6>
                                            @if($service->is_featured)
                                                <span class="badge bg-warning bg-opacity-10 text-warning"><i class="bx bx-star"></i> Featured</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ Str::limit($service->short_description, 60) }}</span>
                                </td>
                                <td>
                                    @if($service->features && count($service->features) > 0)
                                        <span class="badge bg-info bg-opacity-10 text-info">{{ count($service->features) }} features</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="form-check form-switch mb-0">
                                            <input type="checkbox" class="form-check-input" wire:click="toggleActive({{ $service->id }})" {{ $service->is_active ? 'checked' : '' }}>
                                        </div>
                                        @if(!$service->is_active)
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button wire:click="toggleFeatured({{ $service->id }})" class="btn btn-sm {{ $service->is_featured ? 'btn-warning' : 'btn-outline-warning' }}" title="Toggle Featured">
                                            <i class="bx bx-star"></i>
                                        </button>
                                        <button wire:click="edit({{ $service->id }})" data-bs-toggle="modal" data-bs-target="#serviceModal" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $service->id }})" wire:confirm="Delete this service?" class="btn btn-sm btn-outline-danger">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bx bx-layer fs-1 text-muted d-block mb-3"></i>
                                    <h5 class="text-muted">No Services Found</h5>
                                    <p class="text-muted mb-3">Add services to showcase on your website.</p>
                                    <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#serviceModal" class="btn btn-primary radius-30">
                                        <i class="bx bx-plus"></i> Add Service
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">{{ $services->links() }}</div>

    <!-- Modal -->
    <div class="modal fade" id="serviceModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary bg-opacity-10">
                    <h5 class="modal-title">
                        <i class="bx bx-layer me-2"></i>{{ $isEditMode ? 'Edit' : 'Add' }} Service
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Name & Slug -->
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Service Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model.live="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Custom Software Development">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Order</label>
                                <input type="number" wire:model="order" class="form-control" min="0">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">URL Slug</label>
                                <div class="input-group">
                                    <span class="input-group-text">/services/</span>
                                    <input type="text" wire:model="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="custom-software-development">
                                </div>
                                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <!-- Icon Selection -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Icon</label>
                                <select wire:model="icon" class="form-select">
                                    @foreach($iconOptions as $iconClass => $iconLabel)
                                        <option value="{{ $iconClass }}">{{ $iconLabel }}</option>
                                    @endforeach
                                </select>
                                <div class="mt-2">
                                    <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                                        Preview: <i class="bx {{ $icon }} ms-1"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Service Image</label>
                                <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if($image)
                                    <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail mt-2" style="max-height: 80px;">
                                @elseif($existing_image)
                                    <img src="{{ asset('storage/' . $existing_image) }}" class="img-thumbnail mt-2" style="max-height: 80px;">
                                @endif
                            </div>

                            <!-- Short Description -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Short Description</label>
                                <input type="text" wire:model="short_description" class="form-control" placeholder="Brief description for service cards" maxlength="500">
                                <small class="text-muted">Used in service cards and previews</small>
                            </div>

                            <!-- Full Description -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Full Description</label>
                                <textarea wire:model="description" class="form-control" rows="4" placeholder="Detailed description of the service..."></textarea>
                            </div>

                            <!-- Features -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">Features</label>
                                <div class="input-group mb-2">
                                    <input type="text" wire:model="newFeature" wire:keydown.enter.prevent="addFeature" class="form-control" placeholder="Add a feature and press Enter">
                                    <button type="button" wire:click="addFeature" class="btn btn-outline-primary">
                                        <i class="bx bx-plus"></i> Add
                                    </button>
                                </div>
                                @if(count($features) > 0)
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($features as $index => $feature)
                                            <span class="badge bg-primary bg-opacity-10 text-primary p-2">
                                                <i class="bx bx-check me-1"></i>{{ $feature }}
                                                <button type="button" wire:click="removeFeature({{ $index }})" class="btn-close btn-close-sm ms-2" style="font-size: 0.5rem;"></button>
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Pricing -->
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Price From (TZS)</label>
                                <input type="number" wire:model="price_from" class="form-control" placeholder="0" min="0" step="1000">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Price To (TZS)</label>
                                <input type="number" wire:model="price_to" class="form-control" placeholder="0" min="0" step="1000">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Price Unit</label>
                                <select wire:model="price_unit" class="form-select">
                                    <option value="project">Per Project</option>
                                    <option value="hour">Per Hour</option>
                                    <option value="month">Per Month</option>
                                    <option value="year">Per Year</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input type="checkbox" wire:model="is_active" class="form-check-input" id="isActive">
                                    <label class="form-check-label" for="isActive">Active (visible on website)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input type="checkbox" wire:model="is_featured" class="form-check-input" id="isFeatured">
                                    <label class="form-check-label" for="isFeatured">Featured Service</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i>{{ $isEditMode ? 'Update' : 'Save' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @script
    <script>
        $wire.on('close-modal', () => {
            bootstrap.Modal.getInstance(document.getElementById('serviceModal'))?.hide();
        });
    </script>
    @endscript
</div>
