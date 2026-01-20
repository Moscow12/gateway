<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">User Management</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Roles</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button wire:click="openModal" class="btn btn-primary radius-30">
                <i class="bx bx-plus me-1"></i> Add New Role
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

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 bg-danger bg-opacity-10" role="alert">
            <div class="d-flex align-items-center">
                <div class="fs-3 text-danger"><i class="bx bx-error-circle"></i></div>
                <div class="ms-3">
                    <div class="text-danger">{{ session('error') }}</div>
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
                    <div class="card-icon bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bx bx-shield text-primary fs-5"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Roles Management</h6>
                        <small class="text-muted">Manage user roles and their permissions</small>
                    </div>
                </div>
                <div class="search-box">
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search roles...">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            <th>Users</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $index => $role)
                            <tr>
                                <td>{{ $roles->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="role-icon bg-{{ $role->name === 'super-admin' ? 'danger' : ($role->name === 'admin' ? 'warning' : 'primary') }} bg-opacity-10 rounded-circle p-2 me-2">
                                            <i class="bx bx-shield-quarter text-{{ $role->name === 'super-admin' ? 'danger' : ($role->name === 'admin' ? 'warning' : 'primary') }}"></i>
                                        </div>
                                        <div>
                                            <span class="fw-semibold">{{ ucfirst(str_replace('-', ' ', $role->name)) }}</span>
                                            @if($role->name === 'super-admin')
                                                <span class="badge bg-danger ms-2">System</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info">
                                        {{ $role->permissions->count() }} permissions
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">
                                        {{ $role->users->count() }} users
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $role->created_at->format('M d, Y') }}</small>
                                </td>
                                <td class="text-end">
                                    <button wire:click="edit({{ $role->id }})" class="btn btn-sm btn-outline-primary me-1" title="Edit">
                                        <i class="bx bx-edit"></i>
                                    </button>
                                    @if($role->name !== 'super-admin')
                                        <button wire:click="confirmDelete({{ $role->id }})" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bx bx-folder-open fs-1 d-block mb-2"></i>
                                        No roles found
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $roles->links() }}
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bx bx-shield me-2"></i>
                        {{ $editMode ? 'Edit Role' : 'Create New Role' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <!-- Role Name -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bx bx-rename me-1 text-primary"></i> Role Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   wire:model="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Enter role name (e.g., editor, moderator)"
                                   {{ $editMode && $name === 'super-admin' ? 'disabled' : '' }}>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Permissions -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bx bx-lock-open me-1 text-success"></i> Assign Permissions
                            </label>
                            <div class="alert alert-light border-0 bg-light mb-3">
                                <small class="text-muted">
                                    <i class="bx bx-info-circle me-1"></i>
                                    Select the permissions this role should have access to.
                                </small>
                            </div>

                            <div class="row">
                                @php
                                    $groupedPermissions = $allPermissions->groupBy(function ($permission) {
                                        $parts = explode(' ', $permission->name);
                                        return $parts[1] ?? 'general';
                                    });
                                @endphp

                                @foreach($groupedPermissions as $group => $perms)
                                    <div class="col-md-6 mb-3">
                                        <div class="card border">
                                            <div class="card-header bg-light py-2">
                                                <h6 class="mb-0 text-capitalize">
                                                    <i class="bx bx-folder me-1"></i> {{ $group }}
                                                </h6>
                                            </div>
                                            <div class="card-body py-2">
                                                @foreach($perms as $permission)
                                                    <div class="form-check">
                                                        <input type="checkbox"
                                                               class="form-check-input"
                                                               wire:model="selectedPermissions"
                                                               value="{{ $permission->id }}"
                                                               id="perm_{{ $permission->id }}">
                                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                            {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="save">
                                <i class="bx bx-save me-1"></i> {{ $editMode ? 'Update Role' : 'Create Role' }}
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
                    <p class="text-muted mb-0">This action cannot be undone. All users with this role will lose their permissions.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" wire:click="$set('showDeleteModal', false)">Cancel</button>
                    <button type="button" class="btn btn-danger px-4" wire:click="delete">
                        <span wire:loading.remove wire:target="delete">
                            <i class="bx bx-trash me-1"></i> Delete Role
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
        .role-icon {
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
