<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Website Content</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Testimonials</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#testimonialModal" class="btn btn-primary radius-30">
                <i class="bx bx-plus"></i> Add Testimonial
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

    <!-- Testimonials Grid -->
    <div class="row g-3">
        @forelse($testimonials as $testimonial)
            <div class="col-md-6 col-lg-4">
                <div class="card radius-10 h-100">
                    <div class="card-body">
                        <!-- Rating -->
                        <div class="mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bx bxs-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>

                        <!-- Quote -->
                        <p class="text-muted mb-3">
                            <i class="bx bxs-quote-left text-primary fs-4 me-1"></i>
                            {{ Str::limit($testimonial->testimonial, 150) }}
                        </p>

                        <!-- Client Info -->
                        <div class="d-flex align-items-center">
                            @if($testimonial->client_image)
                                <img src="{{ asset('storage/' . $testimonial->client_image) }}" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-primary bg-opacity-10 rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <span class="text-primary fw-bold">{{ strtoupper(substr($testimonial->client_name, 0, 2)) }}</span>
                                </div>
                            @endif
                            <div>
                                <h6 class="mb-0">{{ $testimonial->client_name }}</h6>
                                <small class="text-muted">
                                    {{ $testimonial->client_position }}
                                    @if($testimonial->client_company)
                                        @ {{ $testimonial->client_company }}
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <div class="form-check form-switch mb-0">
                                    <input type="checkbox" class="form-check-input" wire:click="toggleActive({{ $testimonial->id }})" {{ $testimonial->is_active ? 'checked' : '' }}>
                                </div>
                                @if(!$testimonial->is_active)
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>
                            <div class="btn-group btn-group-sm">
                                <button wire:click="edit({{ $testimonial->id }})" data-bs-toggle="modal" data-bs-target="#testimonialModal" class="btn btn-outline-primary">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button wire:click="delete({{ $testimonial->id }})" wire:confirm="Delete this testimonial?" class="btn btn-outline-danger">
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
                        <i class="bx bx-happy-heart-eyes fs-1 text-muted d-block mb-3"></i>
                        <h5 class="text-muted">No Testimonials</h5>
                        <p class="text-muted mb-3">Add testimonials from your happy customers.</p>
                        <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#testimonialModal" class="btn btn-primary radius-30">
                            <i class="bx bx-plus"></i> Add Testimonial
                        </button>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-3">{{ $testimonials->links() }}</div>

    <!-- Modal -->
    <div class="modal fade" id="testimonialModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary bg-opacity-10">
                    <h5 class="modal-title">
                        <i class="bx bx-message-square-detail me-2"></i>{{ $isEditMode ? 'Edit' : 'Add' }} Testimonial
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Client Name <span class="text-danger">*</span></label>
                                <input type="text" wire:model="client_name" class="form-control @error('client_name') is-invalid @enderror" placeholder="Enter name">
                                @error('client_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Position</label>
                                <input type="text" wire:model="client_position" class="form-control" placeholder="e.g. CEO, Manager">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Company</label>
                                <input type="text" wire:model="client_company" class="form-control" placeholder="Company name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Rating</label>
                                <select wire:model="rating" class="form-select">
                                    @for($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Testimonial <span class="text-danger">*</span></label>
                                <textarea wire:model="testimonial" class="form-control @error('testimonial') is-invalid @enderror" rows="4" placeholder="What did the client say?"></textarea>
                                @error('testimonial')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">Client Photo</label>
                                <input type="file" wire:model="client_image" class="form-control @error('client_image') is-invalid @enderror" accept="image/*">
                                @error('client_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                @if($client_image)
                                    <img src="{{ $client_image->temporaryUrl() }}" class="img-thumbnail" style="max-height: 80px;">
                                @elseif($existing_image)
                                    <img src="{{ asset('storage/' . $existing_image) }}" class="img-thumbnail" style="max-height: 80px;">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Order</label>
                                <input type="number" wire:model="order" class="form-control" min="0">
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch mt-4">
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
            bootstrap.Modal.getInstance(document.getElementById('testimonialModal'))?.hide();
        });
    </script>
    @endscript
</div>
