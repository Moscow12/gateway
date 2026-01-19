<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Website Content</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Hero Sections</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#heroModal" class="btn btn-primary radius-30">
                <i class="bx bx-plus"></i> Add Hero Section
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

    <!-- Hero Sections List -->
    <div class="card radius-10">
        <div class="card-header bg-transparent">
            <h6 class="mb-0"><i class="bx bx-slideshow me-2"></i>Hero/Slider Sections</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">Order</th>
                            <th>Preview</th>
                            <th>Title</th>
                            <th>Buttons</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($heroSections as $hero)
                            <tr>
                                <td>
                                    <span class="badge bg-primary">{{ $hero->order }}</span>
                                </td>
                                <td>
                                    @if($hero->image)
                                        <img src="{{ asset('storage/' . $hero->image) }}" class="rounded" style="width: 80px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 80px; height: 50px;">
                                            <i class="bx bx-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <h6 class="mb-0">{{ $hero->title }}</h6>
                                    @if($hero->subtitle)
                                        <small class="text-muted">{{ Str::limit($hero->subtitle, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($hero->button_text)
                                        <span class="badge bg-info bg-opacity-10 text-info me-1">{{ $hero->button_text }}</span>
                                    @endif
                                    @if($hero->button2_text)
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ $hero->button2_text }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" wire:click="toggleActive({{ $hero->id }})" {{ $hero->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button wire:click="edit({{ $hero->id }})" data-bs-toggle="modal" data-bs-target="#heroModal" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $hero->id }})" wire:confirm="Delete this hero section?" class="btn btn-sm btn-outline-danger">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bx bx-slideshow fs-1 text-muted d-block mb-3"></i>
                                    <h5 class="text-muted">No Hero Sections</h5>
                                    <p class="text-muted mb-3">Add hero sections for your website slider.</p>
                                    <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#heroModal" class="btn btn-primary radius-30">
                                        <i class="bx bx-plus"></i> Add Hero Section
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $heroSections->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="heroModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary bg-opacity-10">
                    <h5 class="modal-title">
                        <i class="bx bx-slideshow me-2"></i>{{ $isEditMode ? 'Edit' : 'Add' }} Hero Section
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title">
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Order</label>
                                <input type="number" wire:model="order" class="form-control" min="0">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Subtitle</label>
                                <input type="text" wire:model="subtitle" class="form-control" placeholder="Enter subtitle">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea wire:model="description" class="form-control" rows="3" placeholder="Enter description"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Button 1 Text</label>
                                <input type="text" wire:model="button_text" class="form-control" placeholder="e.g. Get Started">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Button 1 Link</label>
                                <input type="text" wire:model="button_link" class="form-control" placeholder="e.g. /contact">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Button 2 Text</label>
                                <input type="text" wire:model="button2_text" class="form-control" placeholder="e.g. Learn More">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Button 2 Link</label>
                                <input type="text" wire:model="button2_link" class="form-control" placeholder="e.g. /about">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Hero Image</label>
                                <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if($image)
                                    <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail mt-2" style="max-height: 100px;">
                                @elseif($existing_image)
                                    <img src="{{ asset('storage/' . $existing_image) }}" class="img-thumbnail mt-2" style="max-height: 100px;">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Background Image</label>
                                <input type="file" wire:model="background_image" class="form-control @error('background_image') is-invalid @enderror" accept="image/*">
                                @error('background_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if($background_image)
                                    <img src="{{ $background_image->temporaryUrl() }}" class="img-thumbnail mt-2" style="max-height: 100px;">
                                @elseif($existing_bg_image)
                                    <img src="{{ asset('storage/' . $existing_bg_image) }}" class="img-thumbnail mt-2" style="max-height: 100px;">
                                @endif
                            </div>
                            <div class="col-md-12">
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
            bootstrap.Modal.getInstance(document.getElementById('heroModal'))?.hide();
        });
    </script>
    @endscript
</div>
