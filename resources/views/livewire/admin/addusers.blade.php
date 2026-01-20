<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Users</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users') }}">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add New User</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('users') }}" class="btn btn-outline-primary radius-30">
                <i class="bx bx-list-ul me-1"></i> View All Users
            </a>
        </div>
    </div>

    <!-- Flash Message -->
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

    <div class="row">
        <!-- User Preview Card -->
        <div class="col-12 col-lg-4 mb-4">
            <div class="card radius-10 h-100">
                <div class="card-body text-center p-4">
                    <!-- User Avatar Preview -->
                    <div class="user-avatar-container mb-4">
                        @if($photos && count($photos) > 0)
                            <img src="{{ $photos[0]->temporaryUrl() }}" alt="User Photo" class="user-avatar rounded-circle shadow">
                        @else
                            <div class="user-avatar-placeholder rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mx-auto">
                                <i class="bx bx-user text-primary" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>

                    @if($name || $email || $phone)
                        <h4 class="mb-1">{{ $name ?: 'New User' }}</h4>
                        @if($role)
                            <span class="badge bg-{{ $role === 'admin' ? 'danger' : ($role === 'manager' ? 'warning' : ($role === 'accountant' ? 'success' : 'primary')) }} mb-2">
                                {{ \App\Models\User::ROLES[$role] ?? ucfirst($role) }}
                            </span>
                        @endif
                        @if($email)
                            <p class="text-muted mb-3">{{ $email }}</p>
                        @endif

                        <div class="d-flex flex-column gap-2 text-start">
                            @if($phone)
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-primary bg-opacity-10 rounded-circle me-3">
                                    <i class="bx bx-phone text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Phone</small>
                                    <span>{{ $phone }}</span>
                                </div>
                            </div>
                            @endif
                            @if($email)
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-success bg-opacity-10 rounded-circle me-3">
                                    <i class="bx bx-envelope text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Email</small>
                                    <span>{{ $email }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="py-4">
                            <i class="bx bx-user-plus text-muted" style="font-size: 4rem;"></i>
                            <h5 class="mt-3 text-muted">New User</h5>
                            <p class="text-muted mb-0">Fill in the form to create a new user account.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="col-12 col-lg-8">
            <form wire:submit.prevent="addUser">
                <!-- Personal Information -->
                <div class="card radius-10 mb-4">
                    <div class="card-header bg-transparent">
                        <div class="d-flex align-items-center">
                            <div class="card-icon bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bx bx-user text-primary fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Personal Information</h6>
                                <small class="text-muted">Basic details about the user</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Full Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-user me-1 text-primary"></i> Full Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       wire:model.live="name"
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
                                       wire:model.live="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="user@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-shield me-1 text-info"></i> Role <span class="text-danger">*</span>
                                </label>
                                <select wire:model.live="role"
                                        class="form-select @error('role') is-invalid @enderror">
                                    @foreach(\App\Models\User::ROLES as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-phone me-1 text-warning"></i> Phone Number
                                </label>
                                <input type="text"
                                       wire:model.live="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="+255 XXX XXX XXX">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Information -->
                <div class="card radius-10 mb-4">
                    <div class="card-header bg-transparent">
                        <div class="d-flex align-items-center">
                            <div class="card-icon bg-danger bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bx bx-lock-alt text-danger fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Security</h6>
                                <small class="text-muted">Set password for the account</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Password -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-lock me-1 text-danger"></i> Password <span class="text-danger">*</span>
                                </label>
                                <input type="password"
                                       wire:model.live="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Minimum 6 characters">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-lock-open me-1 text-info"></i> Confirm Password <span class="text-danger">*</span>
                                </label>
                                <input type="password"
                                       wire:model.live="password_confirmation"
                                       class="form-control @error('password_confirmation') is-invalid @enderror"
                                       placeholder="Re-enter password">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="alert alert-light border-0 bg-light mb-0">
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-info-circle text-primary me-2 fs-5"></i>
                                        <small class="text-muted">Password must be at least 6 characters long. Use a mix of letters, numbers, and symbols for better security.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Photos -->
                <div class="card radius-10 mb-4">
                    <div class="card-header bg-transparent">
                        <div class="d-flex align-items-center">
                            <div class="card-icon bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bx bx-image text-info fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Profile Photos</h6>
                                <small class="text-muted">Upload user profile images (optional)</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="upload-area p-4 border-2 border-dashed rounded-3 text-center mb-3"
                             style="border-color: #dee2e6; background-color: #f8f9fa;">
                            <div class="upload-icon mb-3">
                                <i class="bx bx-cloud-upload text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h6 class="mb-2">Drag & drop images here</h6>
                            <p class="text-muted small mb-3">or click to browse files</p>
                            <input type="file"
                                   wire:model="photos"
                                   multiple
                                   accept="image/*"
                                   class="form-control"
                                   id="photoInput">
                            <div wire:loading wire:target="photos" class="mt-3">
                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span class="ms-2 text-muted">Uploading...</span>
                            </div>
                        </div>

                        @error('photos.*')
                            <div class="alert alert-danger py-2 mb-3">
                                <i class="bx bx-error-circle me-1"></i> {{ $message }}
                            </div>
                        @enderror

                        @if ($photos && count($photos) > 0)
                            <div class="row g-3">
                                @foreach ($photos as $index => $photo)
                                    <div class="col-6 col-md-3">
                                        <div class="position-relative photo-preview">
                                            <img src="{{ $photo->temporaryUrl() }}"
                                                 class="img-fluid rounded-3 shadow-sm"
                                                 style="height: 120px; width: 100%; object-fit: cover;">
                                            <button type="button"
                                                    wire:click="removePhoto({{ $index }})"
                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 rounded-circle"
                                                    style="width: 28px; height: 28px; padding: 0;">
                                                <i class="bx bx-x"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="form-text mt-2">
                            <i class="bx bx-info-circle me-1"></i>
                            Supported formats: JPEG, PNG, JPG, SVG. Max size: 2MB per image.
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('users') }}" class="btn btn-light radius-30 px-4">
                                <i class="bx bx-arrow-back me-1"></i> Back to Users
                            </a>
                            <div class="d-flex gap-2">
                                <button type="button" wire:click="resetForm" class="btn btn-outline-secondary radius-30 px-4">
                                    <i class="bx bx-reset me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary radius-30 px-4" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="addUser">
                                        <i class="bx bx-user-plus me-1"></i> Create User
                                    </span>
                                    <span wire:loading wire:target="addUser">
                                        <span class="spinner-border spinner-border-sm me-1" role="status"></span>
                                        Creating...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .user-avatar {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .user-avatar-placeholder {
            width: 150px;
            height: 150px;
        }
        .icon-box {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .card-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .upload-area {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .upload-area:hover {
            border-color: #6366f1 !important;
            background-color: rgba(99, 102, 241, 0.05) !important;
        }
        .photo-preview {
            transition: transform 0.2s ease;
        }
        .photo-preview:hover {
            transform: scale(1.02);
        }
        .border-dashed {
            border-style: dashed !important;
        }
    </style>
</div>
