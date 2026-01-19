<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Settings</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Company Details</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            @if($hasExistingData && !$isEditMode)
                <button wire:click="enableEdit" class="btn btn-primary radius-30">
                    <i class="bx bx-edit"></i> Edit Details
                </button>
            @endif
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

    <div class="row">
        <!-- Company Info Card -->
        <div class="col-12 col-lg-4 mb-4">
            <div class="card radius-10 h-100">
                <div class="card-body text-center p-4">
                    <!-- Company Logo -->
                    <div class="company-logo-container mb-4">
                        @if($existing_logo)
                            <img src="{{ asset('storage/' . $existing_logo) }}" alt="Company Logo" class="company-logo rounded-circle shadow">
                        @else
                            <div class="company-logo-placeholder rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center mx-auto">
                                <i class="bx bx-building text-primary" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                    </div>

                    @if($hasExistingData)
                        <h4 class="mb-1">{{ $company_name }}</h4>
                        <p class="text-muted mb-3">{{ $address }}</p>

                        <div class="d-flex flex-column gap-2 text-start">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-primary bg-opacity-10 rounded-circle me-3">
                                    <i class="bx bx-phone text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Phone</small>
                                    <span>{{ $phone }}</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-success bg-opacity-10 rounded-circle me-3">
                                    <i class="bx bx-envelope text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Email</small>
                                    <span>{{ $email }}</span>
                                </div>
                            </div>
                            @if($website)
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-info bg-opacity-10 rounded-circle me-3">
                                    <i class="bx bx-globe text-info"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Website</small>
                                    <a href="{{ $website }}" target="_blank">{{ $website }}</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="py-4">
                            <i class="bx bx-building-house text-muted" style="font-size: 4rem;"></i>
                            <h5 class="mt-3 text-muted">No Company Details</h5>
                            <p class="text-muted mb-0">Fill in the form to add your company information.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="col-12 col-lg-8">
            <form wire:submit.prevent="save">
                <!-- Basic Information -->
                <div class="card radius-10 mb-4">
                    <div class="card-header bg-transparent">
                        <div class="d-flex align-items-center">
                            <div class="card-icon bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bx bx-building text-primary fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Basic Information</h6>
                                <small class="text-muted">Company name, address, and contact details</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Company Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-building me-1 text-primary"></i> Company Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       wire:model="company_name"
                                       class="form-control @error('company_name') is-invalid @enderror"
                                       placeholder="Enter company name"
                                       {{ $hasExistingData && !$isEditMode ? 'disabled' : '' }}>
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-envelope me-1 text-success"></i> Email <span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                       wire:model="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       placeholder="company@example.com"
                                       {{ $hasExistingData && !$isEditMode ? 'disabled' : '' }}>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-phone me-1 text-warning"></i> Phone <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       wire:model="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       placeholder="+255 XXX XXX XXX"
                                       {{ $hasExistingData && !$isEditMode ? 'disabled' : '' }}>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fax -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-printer me-1 text-secondary"></i> Fax
                                </label>
                                <input type="text"
                                       wire:model="fax"
                                       class="form-control"
                                       placeholder="Fax number (optional)"
                                       {{ $hasExistingData && !$isEditMode ? 'disabled' : '' }}>
                            </div>

                            <!-- Address -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-map me-1 text-danger"></i> Address <span class="text-danger">*</span>
                                </label>
                                <textarea wire:model="address"
                                          class="form-control @error('address') is-invalid @enderror"
                                          rows="2"
                                          placeholder="Enter full address"
                                          {{ $hasExistingData && !$isEditMode ? 'disabled' : '' }}></textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Website -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-globe me-1 text-info"></i> Website
                                </label>
                                <input type="url"
                                       wire:model="website"
                                       class="form-control @error('website') is-invalid @enderror"
                                       placeholder="https://www.example.com"
                                       {{ $hasExistingData && !$isEditMode ? 'disabled' : '' }}>
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Logo Upload -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-image me-1 text-purple"></i> Company Logo
                                </label>
                                @if(!$hasExistingData || $isEditMode)
                                    <input type="file"
                                           wire:model="logo"
                                           class="form-control @error('logo') is-invalid @enderror"
                                           accept="image/*">
                                    @error('logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Max 2MB. Supported: JPG, PNG, GIF</div>
                                    @if($logo)
                                        <div class="mt-2">
                                            <img src="{{ $logo->temporaryUrl() }}" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                    @endif
                                @else
                                    <div class="form-control bg-light">
                                        @if($existing_logo)
                                            <i class="bx bx-check-circle text-success me-1"></i> Logo uploaded
                                        @else
                                            <i class="bx bx-x-circle text-muted me-1"></i> No logo
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tax Information -->
                <div class="card radius-10 mb-4">
                    <div class="card-header bg-transparent">
                        <div class="d-flex align-items-center">
                            <div class="card-icon bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bx bx-receipt text-warning fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Tax Information</h6>
                                <small class="text-muted">Tax identification numbers for invoicing</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Tax Number -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-id-card me-1 text-primary"></i> Tax Number (TIN)
                                </label>
                                <input type="text"
                                       wire:model="tax_number"
                                       class="form-control"
                                       placeholder="Tax Identification Number"
                                       {{ $hasExistingData && !$isEditMode ? 'disabled' : '' }}>
                            </div>

                            <!-- VAT Number -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-receipt me-1 text-success"></i> VAT Number
                                </label>
                                <input type="text"
                                       wire:model="vat_number"
                                       class="form-control"
                                       placeholder="VAT Registration Number"
                                       {{ $hasExistingData && !$isEditMode ? 'disabled' : '' }}>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Banking Information -->
                <div class="card radius-10 mb-4">
                    <div class="card-header bg-transparent">
                        <div class="d-flex align-items-center">
                            <div class="card-icon bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bx bx-credit-card text-success fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Banking Information</h6>
                                <small class="text-muted">Bank details for payments and invoices</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <!-- Bank Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-building me-1 text-primary"></i> Bank Name
                                </label>
                                <input type="text"
                                       wire:model="bank_name"
                                       class="form-control"
                                       placeholder="Bank name"
                                       {{ $hasExistingData && !$isEditMode ? 'disabled' : '' }}>
                            </div>

                            <!-- Bank Account -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-wallet me-1 text-warning"></i> Account Number
                                </label>
                                <input type="text"
                                       wire:model="bank_account"
                                       class="form-control"
                                       placeholder="Bank account number"
                                       {{ $hasExistingData && !$isEditMode ? 'disabled' : '' }}>
                            </div>

                            <!-- IBAN -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-transfer me-1 text-info"></i> IBAN
                                </label>
                                <input type="text"
                                       wire:model="iban"
                                       class="form-control"
                                       placeholder="International Bank Account Number"
                                       {{ $hasExistingData && !$isEditMode ? 'disabled' : '' }}>
                            </div>

                            <!-- SWIFT/BIC -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-code me-1 text-danger"></i> SWIFT/BIC Code
                                </label>
                                <input type="text"
                                       wire:model="swift_bic"
                                       class="form-control"
                                       placeholder="SWIFT/BIC code"
                                       {{ $hasExistingData && !$isEditMode ? 'disabled' : '' }}>
                            </div>

                            <!-- Bank Address -->
                            <div class="col-md-12">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-map-pin me-1 text-secondary"></i> Bank Address
                                </label>
                                <textarea wire:model="bank_address"
                                          class="form-control"
                                          rows="2"
                                          placeholder="Bank branch address"
                                          {{ $hasExistingData && !$isEditMode ? 'disabled' : '' }}></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                @if(!$hasExistingData || $isEditMode)
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex justify-content-end gap-2">
                            @if($isEditMode)
                                <button type="button" wire:click="cancelEdit" class="btn btn-outline-secondary radius-30 px-4">
                                    <i class="bx bx-x"></i> Cancel
                                </button>
                            @endif
                            <button type="submit" class="btn btn-primary radius-30 px-4">
                                <i class="bx bx-save"></i> {{ $hasExistingData ? 'Update Details' : 'Save Details' }}
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </form>
        </div>
    </div>

    <style>
        .company-logo {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .company-logo-placeholder {
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
        .text-purple {
            color: #6f42c1;
        }
    </style>
</div>
