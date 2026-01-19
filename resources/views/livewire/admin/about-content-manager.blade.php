<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Website Content</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">About Company</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#aboutModal" class="btn btn-primary radius-30">
                <i class="bx bx-plus"></i> Add Content
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

    <!-- Filter & Content List -->
    <div class="card radius-10">
        <div class="card-header bg-transparent">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="mb-0"><i class="bx bx-info-circle me-2"></i>About Company Content</h6>
                <select wire:model.live="filterType" class="form-select w-auto">
                    <option value="">All Types</option>
                    @foreach($sectionTypes as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">Order</th>
                            <th>Type</th>
                            <th>Title</th>
                            <th>Content Preview</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contents as $content)
                            <tr>
                                <td><span class="badge bg-primary">{{ $content->order }}</span></td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        {{ $sectionTypes[$content->section_type] ?? $content->section_type }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($content->icon)
                                            <div class="icon-box bg-primary bg-opacity-10 rounded me-2 p-2">
                                                <i class="bx {{ $content->icon }} text-primary"></i>
                                            </div>
                                        @endif
                                        <h6 class="mb-0">{{ $content->title }}</h6>
                                    </div>
                                </td>
                                <td>{{ Str::limit(strip_tags($content->content), 60) }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" wire:click="toggleActive({{ $content->id }})" {{ $content->is_active ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button wire:click="edit({{ $content->id }})" data-bs-toggle="modal" data-bs-target="#aboutModal" class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button wire:click="delete({{ $content->id }})" wire:confirm="Delete this content?" class="btn btn-sm btn-outline-danger">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bx bx-info-circle fs-1 text-muted d-block mb-3"></i>
                                    <h5 class="text-muted">No Content Found</h5>
                                    <p class="text-muted mb-3">Add content for your About page.</p>
                                    <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#aboutModal" class="btn btn-primary radius-30">
                                        <i class="bx bx-plus"></i> Add Content
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $contents->links() }}</div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="aboutModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary bg-opacity-10">
                    <h5 class="modal-title">
                        <i class="bx bx-info-circle me-2"></i>{{ $isEditMode ? 'Edit' : 'Add' }} Content
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Section Type <span class="text-danger">*</span></label>
                                <select wire:model="section_type" class="form-select @error('section_type') is-invalid @enderror">
                                    <option value="">Select type...</option>
                                    @foreach($sectionTypes as $key => $label)
                                        <option value="{{ $key }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('section_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Order</label>
                                <input type="number" wire:model="order" class="form-control" min="0">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                <input type="text" wire:model="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title">
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Icon (Boxicons)</label>
                                <input type="text" wire:model="icon" class="form-control" placeholder="e.g. bx-target-lock">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                                <textarea wire:model="content" class="form-control @error('content') is-invalid @enderror" rows="5" placeholder="Enter content"></textarea>
                                @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Image</label>
                                <input type="file" wire:model="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if($image)
                                    <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail mt-2" style="max-height: 100px;">
                                @elseif($existing_image)
                                    <img src="{{ asset('storage/' . $existing_image) }}" class="img-thumbnail mt-2" style="max-height: 100px;">
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

    <style>
        .icon-box { width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; }
    </style>

    @script
    <script>
        $wire.on('close-modal', () => {
            bootstrap.Modal.getInstance(document.getElementById('aboutModal'))?.hide();
        });
    </script>
    @endscript
</div>
