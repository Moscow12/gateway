<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Website Content</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Partners</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#partnerModal" class="btn btn-primary radius-30">
                <i class="bx bx-plus"></i> Add Partner
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

    <!-- Filter -->
    <div class="card radius-10 mb-3">
        <div class="card-body py-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex gap-2">
                    <button wire:click="$set('filterType', '')" class="btn {{ $filterType === '' ? 'btn-primary' : 'btn-outline-primary' }} radius-30">
                        All
                    </button>
                    @foreach($partnerTypes as $key => $label)
                        <button wire:click="$set('filterType', '{{ $key }}')" class="btn {{ $filterType === $key ? 'btn-primary' : 'btn-outline-primary' }} radius-30">
                            {{ $label }}s
                        </button>
                    @endforeach
                </div>
                <span class="text-muted">{{ $partners->total() }} partners</span>
            </div>
        </div>
    </div>

    <!-- Partners Grid -->
    <div class="row g-3">
        @forelse($partners as $partner)
            <div class="col-md-4 col-lg-3">
                <div class="card radius-10 h-100">
                    <div class="card-body text-center p-4">
                        <div class="partner-logo mb-3">
                            <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="img-fluid" style="max-height: 80px; max-width: 150px; object-fit: contain;">
                        </div>
                        <h6 class="mb-1">{{ $partner->name }}</h6>
                        <span class="badge bg-{{ $partner->partner_type === 'partner' ? 'primary' : ($partner->partner_type === 'sponsor' ? 'success' : 'info') }} bg-opacity-10 text-{{ $partner->partner_type === 'partner' ? 'primary' : ($partner->partner_type === 'sponsor' ? 'success' : 'info') }}">
                            {{ $partnerTypes[$partner->partner_type] ?? $partner->partner_type }}
                        </span>
                        @if($partner->website)
                            <div class="mt-2">
                                <a href="{{ $partner->website }}" target="_blank" class="text-muted small">
                                    <i class="bx bx-link-external"></i> Visit Website
                                </a>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <div class="form-check form-switch mb-0">
                                    <input type="checkbox" class="form-check-input" wire:click="toggleActive({{ $partner->id }})" {{ $partner->is_active ? 'checked' : '' }}>
                                </div>
                                @if(!$partner->is_active)
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>
                            <div class="btn-group btn-group-sm">
                                <button wire:click="edit({{ $partner->id }})" data-bs-toggle="modal" data-bs-target="#partnerModal" class="btn btn-outline-primary">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button wire:click="delete({{ $partner->id }})" wire:confirm="Delete this partner?" class="btn btn-outline-danger">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-body text-center py-5">
                        <i class="bx bx-buildings fs-1 text-muted d-block mb-3"></i>
                        <h5 class="text-muted">No Partners</h5>
                        <p class="text-muted mb-3">Add your partners, sponsors, and clients.</p>
                        <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#partnerModal" class="btn btn-primary radius-30">
                            <i class="bx bx-plus"></i> Add Partner
                        </button>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">{{ $partners->links() }}</div>

    <!-- Modal -->
    <div class="modal fade" id="partnerModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary bg-opacity-10">
                    <h5 class="modal-title">
                        <i class="bx bx-buildings me-2"></i>{{ $isEditMode ? 'Edit' : 'Add' }} Partner
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Logo {{ !$isEditMode ? '<span class="text-danger">*</span>' : '' }}</label>
                                <input type="file" wire:model="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*">
                                @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="text-center mt-2">
                                    @if($logo)
                                        <img src="{{ $logo->temporaryUrl() }}" class="img-thumbnail" style="max-height: 80px;">
                                    @elseif($existing_logo)
                                        <img src="{{ asset('storage/' . $existing_logo) }}" class="img-thumbnail" style="max-height: 80px;">
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Partner name">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                                <select wire:model="partner_type" class="form-select @error('partner_type') is-invalid @enderror">
                                    @foreach($partnerTypes as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('partner_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Order</label>
                                <input type="number" wire:model="order" class="form-control" min="0">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Website</label>
                                <input type="url" wire:model="website" class="form-control @error('website') is-invalid @enderror" placeholder="https://example.com">
                                @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea wire:model="description" class="form-control" rows="2" placeholder="Brief description (optional)"></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input type="checkbox" wire:model="is_active" class="form-check-input" id="isActive">
                                    <label class="form-check-label" for="isActive">Active</label>
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

    <style>
        .partner-logo {
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    @script
    <script>
        $wire.on('close-modal', () => {
            bootstrap.Modal.getInstance(document.getElementById('partnerModal'))?.hide();
        });
    </script>
    @endscript
</div>
