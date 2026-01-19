<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Products</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product Management</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#productModal" class="btn btn-primary radius-30">
                <i class="bx bx-plus"></i> Add New Product
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

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card radius-10 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Products</p>
                            <h4 class="my-1 text-primary">{{ $totalProducts }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-primary bg-opacity-10 text-primary ms-auto">
                            <i class="bx bx-package"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card radius-10 border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Recurring</p>
                            <h4 class="my-1 text-success">{{ $recurringProducts }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-success bg-opacity-10 text-success ms-auto">
                            <i class="bx bx-refresh"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card radius-10 border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">One-Time</p>
                            <h4 class="my-1 text-warning">{{ $oneTimeProducts }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-warning bg-opacity-10 text-warning ms-auto">
                            <i class="bx bx-credit-card"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card radius-10 border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Avg. Price</p>
                            <h4 class="my-1 text-info">{{ number_format($avgPrice, 0) }} TZS</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-info bg-opacity-10 text-info ms-auto">
                            <i class="bx bx-dollar-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table Card -->
    <div class="card radius-10">
        <div class="card-header bg-transparent">
            <div class="row g-3 align-items-center">
                <!-- Search -->
                <div class="col-md-4">
                    <div class="position-relative">
                        <input type="text"
                               wire:model.live.debounce.300ms="search"
                               class="form-control ps-5 radius-30"
                               placeholder="Search products...">
                        <span class="position-absolute top-50 translate-middle-y" style="left: 15px;">
                            <i class="bx bx-search text-secondary"></i>
                        </span>
                        @if($search)
                            <span class="position-absolute top-50 translate-middle-y cursor-pointer"
                                  style="right: 15px;"
                                  wire:click="$set('search', '')">
                                <i class="bx bx-x text-secondary"></i>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Payment Type Filter -->
                <div class="col-md-3">
                    <select wire:model.live="paymentTypeFilter" class="form-select radius-30">
                        <option value="">All Payment Types</option>
                        <option value="Recurring">Recurring</option>
                        <option value="One_Time_Payment">One-Time Payment</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <!-- Clear Filters -->
                <div class="col-md-2">
                    @if($search || $paymentTypeFilter)
                        <button wire:click="clearFilters" class="btn btn-outline-secondary radius-30 w-100">
                            <i class="bx bx-x"></i> Clear
                        </button>
                    @endif
                </div>

                <!-- Results Count -->
                <div class="col-md-3 text-end">
                    <span class="text-muted">
                        Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                    </span>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Active Filters -->
            @if($search || $paymentTypeFilter)
                <div class="mb-3">
                    <span class="text-muted me-2">Active filters:</span>
                    @if($search)
                        <span class="badge bg-info me-1">
                            Search: {{ $search }}
                            <i class="bx bx-x cursor-pointer" wire:click="$set('search', '')"></i>
                        </span>
                    @endif
                    @if($paymentTypeFilter)
                        <span class="badge bg-primary me-1">
                            Type: {{ str_replace('_', ' ', $paymentTypeFilter) }}
                            <i class="bx bx-x cursor-pointer" wire:click="$set('paymentTypeFilter', '')"></i>
                        </span>
                    @endif
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th wire:click="sortBy('productname')" class="cursor-pointer">
                                <div class="d-flex align-items-center">
                                    Product Name
                                    @if($sortField === 'productname')
                                        <i class="bx bx-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-arrow-alt ms-1"></i>
                                    @endif
                                </div>
                            </th>
                            <th wire:click="sortBy('initialprice')" class="cursor-pointer">
                                <div class="d-flex align-items-center">
                                    Price Range
                                    @if($sortField === 'initialprice')
                                        <i class="bx bx-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-arrow-alt ms-1"></i>
                                    @endif
                                </div>
                            </th>
                            <th>Payment Type</th>
                            <th>Description</th>
                            <th>Added By</th>
                            <th wire:click="sortBy('created_at')" class="cursor-pointer">
                                <div class="d-flex align-items-center">
                                    Date
                                    @if($sortField === 'created_at')
                                        <i class="bx bx-{{ $sortDirection === 'asc' ? 'up' : 'down' }}-arrow-alt ms-1"></i>
                                    @endif
                                </div>
                            </th>
                            <th style="width: 120px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $index => $product)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $products->firstItem() + $index }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="product-icon bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="bx bx-package text-primary fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $product->productname }}</h6>
                                            <small class="text-muted">ID: #{{ $product->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span class="fw-bold text-success">{{ number_format($product->initialprice, 0) }}</span>
                                        <span class="text-muted">-</span>
                                        <span class="fw-bold text-primary">{{ number_format($product->topprice, 0) }}</span>
                                        <small class="text-muted d-block">TZS</small>
                                    </div>
                                </td>
                                <td>
                                    @switch($product->paymenttype)
                                        @case('Recurring')
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                                <i class="bx bx-refresh me-1"></i> Recurring
                                            </span>
                                            @break
                                        @case('One_Time_Payment')
                                            <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                                                <i class="bx bx-credit-card me-1"></i> One-Time
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">
                                                <i class="bx bx-dots-horizontal-rounded me-1"></i> Other
                                            </span>
                                    @endswitch
                                </td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" title="{{ $product->productdescription }}">
                                        {{ Str::limit($product->productdescription, 50) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-light-primary text-primary rounded-circle me-2">
                                            {{ strtoupper(substr($product->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <span>{{ $product->user->name ?? 'Unknown' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span>{{ $product->created_at->format('d M Y') }}</span>
                                        <small class="text-muted d-block">{{ $product->created_at->format('h:i A') }}</small>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button wire:click="editProduct({{ $product->id }})"
                                                data-bs-toggle="modal" data-bs-target="#productModal"
                                                class="btn btn-sm btn-outline-primary radius-30"
                                                title="Edit">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button wire:click="deleteProduct({{ $product->id }})"
                                                wire:confirm="Are you sure you want to delete this product?"
                                                class="btn btn-sm btn-outline-danger radius-30"
                                                title="Delete">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="bx bx-package fs-1 d-block mb-3"></i>
                                        <h5>No products found</h5>
                                        <p class="mb-3">
                                            @if($search || $paymentTypeFilter)
                                                No products match your current filters.
                                            @else
                                                Get started by adding your first product.
                                            @endif
                                        </p>
                                        @if($search || $paymentTypeFilter)
                                            <button wire:click="clearFilters" class="btn btn-outline-primary radius-30">
                                                <i class="bx bx-x"></i> Clear Filters
                                            </button>
                                        @else
                                            <button wire:click="resetForm" data-bs-toggle="modal" data-bs-target="#productModal" class="btn btn-primary radius-30">
                                                <i class="bx bx-plus"></i> Add Product
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries
                    </div>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Add/Edit Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 bg-primary bg-opacity-10">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon bg-primary text-white rounded-circle p-2 me-3">
                            <i class="bx {{ $isEditMode ? 'bx-edit' : 'bx-plus' }} fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0">{{ $isEditMode ? 'Edit Product' : 'Add New Product' }}</h5>
                            <small class="text-muted">{{ $isEditMode ? 'Update product information' : 'Fill in the product details below' }}</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="saveProduct">
                    <div class="modal-body">
                        <div class="row g-4">
                            <!-- Product Name -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-package me-1 text-primary"></i> Product Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       wire:model="productname"
                                       class="form-control form-control-lg @error('productname') is-invalid @enderror"
                                       placeholder="Enter product name">
                                @error('productname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Price Range -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-dollar me-1 text-success"></i> Initial Price (TZS) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">TZS</span>
                                    <input type="number"
                                           wire:model="initialprice"
                                           class="form-control @error('initialprice') is-invalid @enderror"
                                           placeholder="0.00"
                                           step="0.01"
                                           min="0">
                                    @error('initialprice')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-dollar-circle me-1 text-primary"></i> Top Price (TZS) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">TZS</span>
                                    <input type="number"
                                           wire:model="topprice"
                                           class="form-control @error('topprice') is-invalid @enderror"
                                           placeholder="0.00"
                                           step="0.01"
                                           min="0">
                                    @error('topprice')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Payment Type -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-credit-card me-1 text-warning"></i> Payment Type <span class="text-danger">*</span>
                                </label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" wire:model="paymenttype" value="Recurring" id="recurring" autocomplete="off">
                                        <label class="btn btn-outline-success w-100 py-3" for="recurring">
                                            <i class="bx bx-refresh fs-4 d-block mb-1"></i>
                                            Recurring
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" wire:model="paymenttype" value="One_Time_Payment" id="onetime" autocomplete="off">
                                        <label class="btn btn-outline-warning w-100 py-3" for="onetime">
                                            <i class="bx bx-credit-card fs-4 d-block mb-1"></i>
                                            One-Time
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" wire:model="paymenttype" value="Other" id="other" autocomplete="off">
                                        <label class="btn btn-outline-secondary w-100 py-3" for="other">
                                            <i class="bx bx-dots-horizontal-rounded fs-4 d-block mb-1"></i>
                                            Other
                                        </label>
                                    </div>
                                </div>
                                @error('paymenttype')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bx bx-text me-1 text-info"></i> Description <span class="text-danger">*</span>
                                </label>
                                <textarea wire:model="productdescription"
                                          class="form-control @error('productdescription') is-invalid @enderror"
                                          rows="4"
                                          placeholder="Describe the product features, benefits, and other details..."></textarea>
                                @error('productdescription')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Maximum 1000 characters</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 bg-light">
                        <button type="button" class="btn btn-secondary radius-30 px-4" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary radius-30 px-4">
                            <i class="bx bx-save"></i> {{ $isEditMode ? 'Update Product' : 'Save Product' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .cursor-pointer {
            cursor: pointer;
        }
        .widgets-icons-2 {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .product-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .avatar {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
        }
        .modal-icon {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-check:checked + .btn-outline-success {
            background-color: #198754;
            color: white;
        }
        .btn-check:checked + .btn-outline-warning {
            background-color: #ffc107;
            color: #000;
        }
        .btn-check:checked + .btn-outline-secondary {
            background-color: #6c757d;
            color: white;
        }
    </style>

    @script
    <script>
        $wire.on('close-modal', () => {
            const modalEl = document.getElementById('productModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) {
                modal.hide();
            }
        });
    </script>
    @endscript
</div>
