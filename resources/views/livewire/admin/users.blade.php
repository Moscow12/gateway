<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">User Management</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Users</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            @can('create users')
            <a href="{{ route('addusers') }}" class="btn btn-primary radius-30">
                <i class="bx bx-plus me-1"></i> Add New User
            </a>
            @endcan
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
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <div class="card-icon bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="bx bx-group text-primary fs-5"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Users List</h6>
                        <small class="text-muted">Manage all system users</small>
                    </div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <!-- Search -->
                    <div class="search-box">
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search users...">
                    </div>
                    <!-- Filter by Role -->
                    <select wire:model.live="filterRole" class="form-select" style="min-width: 150px;">
                        <option value="">All Roles</option>
                        @foreach($roles as $roleOption)
                            <option value="{{ $roleOption->name }}">{{ ucfirst(str_replace('-', ' ', $roleOption->name)) }}</option>
                        @endforeach
                    </select>
                    <!-- Filter by Status -->
                    <select wire:model.live="filterStatus" class="form-select" style="min-width: 130px;">
                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Contact</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-3">
                                            @if($user->photos && is_array($user->photos) && count($user->photos) > 0)
                                                <img src="{{ asset('storage/' . $user->photos[0]) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover;">
                                            @else
                                                <div class="avatar-placeholder rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                                    <span class="text-primary fw-bold">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $user->name }}</h6>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="bx bx-envelope text-muted me-1"></i>
                                            <small>{{ $user->email }}</small>
                                        </div>
                                        @if($user->phone)
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-phone text-muted me-1"></i>
                                                <small>{{ $user->phone }}</small>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($user->roles->count() > 0)
                                        @foreach($user->roles as $userRole)
                                            <span class="badge bg-{{ $userRole->name === 'super-admin' ? 'danger' : ($userRole->name === 'admin' ? 'warning' : ($userRole->name === 'manager' ? 'info' : 'primary')) }}">
                                                {{ ucfirst(str_replace('-', ' ', $userRole->name)) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted small">No role</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge bg-success bg-opacity-10 ">
                                            <i class="bx bx-check-circle me-1"></i> Active
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger">
                                            <i class="bx bx-x-circle me-1"></i> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $user->created_at->format('M d, Y') }}</small>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        @can('edit users')
                                        <button wire:click="edit({{ $user->id }})" class="btn btn-sm btn-outline-primary" title="Edit User">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        @endcan

                                        @if($user->id !== auth()->id())
                                            @can('edit users')
                                            <button wire:click="toggleActive({{ $user->id }})"
                                                    class="btn btn-sm btn-outline-{{ $user->is_active ? 'warning' : 'success' }}"
                                                    title="{{ $user->is_active ? 'Deactivate' : 'Activate' }} User">
                                                <i class="bx bx-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                                            </button>
                                            @endcan

                                            @can('delete users')
                                            <button wire:click="confirmDelete({{ $user->id }})"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Delete User">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                            @endcan
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary">You</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bx bx-user-x fs-1 d-block mb-2"></i>
                                        No users found
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    @if($showEditModal)
    <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bx bx-edit me-2"></i> Edit User
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeEditModal"></button>
                </div>
                <form wire:submit.prevent="update">
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-user me-1 text-primary"></i> Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       wire:model="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Enter full name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-envelope me-1 text-success"></i> Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                       wire:model="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="user@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-phone me-1 text-warning"></i> Phone Number
                                </label>
                                <input type="text"
                                       wire:model="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="+255 XXX XXX XXX">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-shield me-1 text-info"></i> Role <span class="text-danger">*</span>
                                </label>
                                <select wire:model="role" class="form-select @error('role') is-invalid @enderror">
                                    <option value="">Select a role...</option>
                                    @foreach($roles as $roleOption)
                                        <option value="{{ $roleOption->name }}">{{ ucfirst(str_replace('-', ' ', $roleOption->name)) }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <hr class="my-2">
                                <h6 class="text-muted mb-3">
                                    <i class="bx bx-lock me-1"></i> Change Password (leave blank to keep current)
                                </h6>
                            </div>

                            <!-- New Password -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-lock me-1 text-danger"></i> New Password
                                </label>
                                <input type="password"
                                       wire:model="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Leave blank to keep current">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-lock-open me-1 text-secondary"></i> Confirm Password
                                </label>
                                <input type="password"
                                       wire:model="password_confirmation"
                                       class="form-control"
                                       placeholder="Confirm new password">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeEditModal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span wire:loading.remove wire:target="update">
                                <i class="bx bx-save me-1"></i> Update User
                            </span>
                            <span wire:loading wire:target="update">
                                <span class="spinner-border spinner-border-sm me-1"></span> Updating...
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
                        <i class="bx bx-user-x text-danger" style="font-size: 4rem;"></i>
                    </div>
                    <h5>Are you sure?</h5>
                    <p class="text-muted mb-0">This action cannot be undone. The user will be permanently deleted.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-secondary px-4" wire:click="$set('showDeleteModal', false)">Cancel</button>
                    <button type="button" class="btn btn-danger px-4" wire:click="delete">
                        <span wire:loading.remove wire:target="delete">
                            <i class="bx bx-trash me-1"></i> Delete User
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
        .card-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .search-box input {
            min-width: 200px;
        }
        .avatar-placeholder {
            font-size: 0.875rem;
        }
        .table > tbody > tr:hover {
            background-color: rgba(99, 102, 241, 0.04);
        }
    </style>
</div>
