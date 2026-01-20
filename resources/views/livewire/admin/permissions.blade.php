<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">User Management</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Permissions</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button wire:click="openModal" class="btn btn-primary radius-30">
                <i class="bx bx-plus me-1"></i> Add New Permission
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 bg-success bg-opacity-10" role="alert">
            <div class="d-flex align-items-center">
                <div class="fs-3 text-success"><i class="bx bx-check-circle"></i></div>
                <div class="ms-3">
                    <div class="text-success">{{ session('success') }}</div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Card -->
    <div class="card radius-10">
        <div class="card-header bg-transparent">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="card-icon bg-success bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bx bx-lock-open text-success fs-5"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Permissions Management</h6>
                        <small class="text-muted">Manage system permissions</small>
                    </div>
                </div>
                <div class="search-box">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search permissions...">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Permission Name</th>
                            <th>Assigned To Roles</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($permissions as $index => $permission)
                            <tr>
                                <td>{{ $permissions->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="perm-icon bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                            <i class="bx bx-key"></i>
                                        </div>
                                        <span class="fw-semibold">{{ $permission->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($permission->roles->count() > 0)
                                        @foreach($permission->roles->take(3) as $role)
                                            <span class="badge bg-primary bg-opacity-10 text-primary me-1">
                                                {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                            </span>
                                        @endforeach
                                        @if($permission->roles->count() > 3)
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                                +{{ $permission->roles->count() - 3 }} more
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-muted small">Not assigned</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $permission->created_at->format('M d, Y') }}</small>
                                </td>
                                <td class="text-end">
                                    <button wire:click="edit({{ $permission->id }})" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                        <i class="bx bx-edit"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $permission->id }})" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bx bx-folder-open fs-1 d-block mb-2"></i>
                                        No permissions found
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bx bx-lock-open me-2"></i>
                        {{ $editMode ? 'Edit Permission' : 'Create New Permission' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bx bx-rename me-1 text-primary"></i> Permission Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   wire:model="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="e.g., view users, create posts">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bx bx-info-circle me-1"></i>
                                Use lowercase with spaces (e.g., "view dashboard", "edit users")
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="save">
                                <i class="bx bx-save me-1"></i> {{ $editMode ? 'Update' : 'Create' }}
                            </span>
                            <span wire:loading wire:target="save">
                                <span class="spinner-border spinner-border-sm me-1"></span> Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger">
                        <i class="bx bx-error-circle me-2"></i> Confirm Delete
                    </h5>
                    <button type="button" class="btn-close" wire:click="$set('showDeleteModal', false)"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i class="bx bx-trash text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h5>Are you sure?</h5>
                    <p class="text-muted mb-0">This will remove the permission from all roles.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" wire:click="$set('showDeleteModal', false)">Cancel</button>
                    <button type="button" class="btn btn-danger px-4" wire:click="delete">
                        <span wire:loading.remove wire:target="delete">
                            <i class="bx bx-trash me-1"></i> Delete
                        </span>
                        <span wire:loading wire:target="delete">
                            <span class="spinner-border spinner-border-sm me-1"></span> Deleting...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <style>
        .perm-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .search-box input {
            min-width: 250px;
        }
        .card-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</div>
