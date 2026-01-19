<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Website Content</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#galleryModal" class="btn btn-primary radius-30">
                <i class="bx bx-plus"></i> Add Image
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
                    <button wire:click="$set('filterCategory', '')" class="btn {{ $filterCategory === '' ? 'btn-primary' : 'btn-outline-primary' }} radius-30">
                        All
                    </button>
                    @foreach($categories as $key => $label)
                        <button wire:click="$set('filterCategory', '{{ $key }}')" class="btn {{ $filterCategory === $key ? 'btn-primary' : 'btn-outline-primary' }} radius-30">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
                <span class="text-muted">{{ $galleries->total() }} images</span>
            </div>
        </div>
    </div>

    <!-- Gallery Grid -->
    <div class="row g-3">
        @forelse($galleries as $gallery)
            <div class="col-md-4 col-lg-3">
                <div class="card radius-10 h-100">
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $gallery->image) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
                        @if(!$gallery->is_active)
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex align-items-center justify-content-center">
                                <span class="badge bg-danger">Inactive</span>
                            </div>
                        @endif
                        <div class="position-absolute top-0 end-0 p-2">
                            <span class="badge bg-info">{{ $categories[$gallery->category] ?? 'Uncategorized' }}</span>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <h6 class="card-title mb-1">{{ Str::limit($gallery->title, 30) }}</h6>
                        @if($gallery->description)
                            <small class="text-muted">{{ Str::limit($gallery->description, 50) }}</small>
                        @endif
                    </div>
                    <div class="card-footer bg-transparent border-0 p-3 pt-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" wire:click="toggleActive({{ $gallery->id }})" {{ $gallery->is_active ? 'checked' : '' }}>
                            </div>
                            <div class="btn-group btn-group-sm">
                                <button wire:click="edit({{ $gallery->id }})" data-bs-toggle="modal" data-bs-target="#galleryModal" class="btn btn-outline-primary">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button wire:click="delete({{ $gallery->id }})" wire:confirm="Delete this image?" class="btn btn-outline-danger">
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
                        <i class="bx bx-image-alt fs-1 text-muted d-block mb-3"></i>
                        <h5 class="text-muted">No Images Found</h5>
                        <p class="text-muted mb-3">Add images to your gallery.</p>
                        <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#galleryModal" class="btn btn-primary radius-30">
                            <i class="bx bx-plus"></i> Add Image
                        </button>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">{{ $galleries->links() }}</div>

    <!-- Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary bg-opacity-10">
                    <h5 class="modal-title">
                        <i class="bx bx-image me-2"></i>{{ $isEditMode ? 'Edit' : 'Add' }} Gallery Image
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Image {{ !$isEditMode ? '<span class="text-danger">*</span>' : '' }}</label>
                                <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if($image)
                                    <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail mt-2" style="max-height: 150px;">
                                @elseif($existing_image)
                                    <img src="{{ asset('storage/' . $existing_image) }}" class="img-thumbnail mt-2" style="max-height: 150px;">
                                @endif
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title">
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Category</label>
                                <select wire:model="category" class="form-select">
                                    <option value="">Select category...</option>
                                    @foreach($categories as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Order</label>
                                <input type="number" wire:model="order" class="form-control" min="0">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea wire:model="description" class="form-control" rows="2" placeholder="Optional description"></textarea>
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

    @script
    <script>
        $wire.on('close-modal', () => {
            bootstrap.Modal.getInstance(document.getElementById('galleryModal'))?.hide();
        });
    </script>
    @endscript
</div>
