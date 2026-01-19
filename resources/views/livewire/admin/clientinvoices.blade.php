<div>
    @php
        $totalAmount = 0;
        $subtotal = 0;
        foreach($invoice_items ?? [] as $item) {
            $subtotal += $item->quantity * $item->amount;
        }
        $tax = $subtotal * 0.18;
        $totalAmount = $subtotal + $tax;
    @endphp

    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Invoice</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('clients') }}">Clients</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('clientpage', $clientId) }}">{{ $client->clientname ?? 'Client' }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Invoice #{{ $invoiceId }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('clientpage', $clientId) }}" class="btn btn-outline-secondary radius-30 me-2">
                <i class="bx bx-arrow-back"></i> Back
            </a>
            <button onclick="window.print()" class="btn btn-dark radius-30 me-2">
                <i class="bx bx-printer"></i> Print
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

    <div class="row">
        <!-- Left Column - Invoice Details & Add Item -->
        <div class="col-12 col-lg-4 no-print">
            <!-- Invoice Status Card -->
            <div class="card radius-10 mb-4">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0"><i class="bx bx-info-circle me-2"></i>Invoice Status</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @switch($invoice?->Status)
                            @case('Paid')
                                <div class="status-icon bg-success bg-opacity-10 rounded-circle mx-auto mb-3">
                                    <i class="bx bx-check-circle text-success fs-1"></i>
                                </div>
                                <span class="badge bg-success px-4 py-2 fs-6">PAID</span>
                                @break
                            @case('Active')
                                <div class="status-icon bg-warning bg-opacity-10 rounded-circle mx-auto mb-3">
                                    <i class="bx bx-time-five text-warning fs-1"></i>
                                </div>
                                <span class="badge bg-warning text-dark px-4 py-2 fs-6">ACTIVE</span>
                                @break
                            @case('Expired')
                                <div class="status-icon bg-danger bg-opacity-10 rounded-circle mx-auto mb-3">
                                    <i class="bx bx-x-circle text-danger fs-1"></i>
                                </div>
                                <span class="badge bg-danger px-4 py-2 fs-6">EXPIRED</span>
                                @break
                            @default
                                <div class="status-icon bg-info bg-opacity-10 rounded-circle mx-auto mb-3">
                                    <i class="bx bx-loader-circle text-info fs-1"></i>
                                </div>
                                <span class="badge bg-info px-4 py-2 fs-6">PENDING</span>
                        @endswitch
                    </div>

                    <hr>

                    <!-- Control Number Input -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            <i class="bx bx-barcode me-1 text-primary"></i> Control Number
                        </label>
                        <div class="input-group">
                            <input type="text"
                                   wire:model="control_number"
                                   class="form-control @error('control_number') is-invalid @enderror"
                                   placeholder="Enter control number">
                            <button wire:click="generateControlNumber"
                                    class="btn btn-outline-secondary"
                                    type="button"
                                    title="Generate">
                                <i class="bx bx-refresh"></i>
                            </button>
                        </div>
                        @error('control_number')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Enter manually or click refresh to auto-generate</div>
                    </div>

                    @if($invoice?->Status === 'Pending' && count($invoice_items ?? []) > 0)
                        <button wire:click="generateinvoice" class="btn btn-primary radius-30 w-100 mb-2">
                            <i class="bx bx-check"></i> Finalize Invoice
                        </button>
                    @elseif($invoice?->Status === 'Active')
                        <button wire:click="markAsPaid" class="btn btn-success radius-30 w-100">
                            <i class="bx bx-check-circle"></i> Mark as Paid
                        </button>
                    @endif
                </div>
            </div>

            <!-- Add Item Card -->
            @if($invoice?->Status === 'Pending')
            <div class="card radius-10">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0">
                        <i class="bx bx-plus-circle me-2"></i>
                        {{ $isEditMode ? 'Edit Item' : 'Add Item' }}
                    </h6>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="addItem">
                        <!-- Item Type Toggle -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Item Type</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" wire:model.live="itemType" value="service" id="typeService" autocomplete="off">
                                <label class="btn btn-outline-primary" for="typeService">
                                    <i class="bx bx-briefcase me-1"></i> Service
                                </label>
                                <input type="radio" class="btn-check" wire:model.live="itemType" value="product" id="typeProduct" autocomplete="off">
                                <label class="btn btn-outline-primary" for="typeProduct">
                                    <i class="bx bx-package me-1"></i> Product
                                </label>
                            </div>
                        </div>

                        <!-- Service Selection -->
                        @if($itemType === 'service')
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bx bx-briefcase me-1 text-info"></i> Service <span class="text-danger">*</span>
                            </label>
                            <select wire:model.live="service_type_id"
                                    class="form-select @error('service_type_id') is-invalid @enderror">
                                <option value="">Select service...</option>
                                @foreach($serviceTypes ?? [] as $service)
                                    <option value="{{ $service->id }}">
                                        {{ $service->name }} - {{ number_format($service->base_price, 0) }} TZS
                                    </option>
                                @endforeach
                            </select>
                            @error('service_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @else
                        <!-- Product Selection -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bx bx-package me-1 text-warning"></i> Product <span class="text-danger">*</span>
                            </label>
                            <select wire:model="product_id"
                                    class="form-select @error('product_id') is-invalid @enderror">
                                <option value="">Select product...</option>
                                @foreach($products ?? [] as $product)
                                    <option value="{{ $product->id }}">{{ $product->productname }}</option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        <!-- Quantity -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bx bx-hash me-1 text-secondary"></i> Quantity <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   wire:model="quantity"
                                   class="form-control @error('quantity') is-invalid @enderror"
                                   placeholder="1"
                                   min="1">
                            @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bx bx-money me-1 text-success"></i> Unit Price (TZS) <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   wire:model="amount"
                                   class="form-control @error('amount') is-invalid @enderror"
                                   placeholder="0.00"
                                   step="0.01"
                                   min="0">
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="bx bx-text me-1 text-muted"></i> Description
                            </label>
                            <textarea wire:model="description"
                                      class="form-control"
                                      rows="2"
                                      placeholder="Optional description..."></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary radius-30 flex-grow-1">
                                <i class="bx {{ $isEditMode ? 'bx-save' : 'bx-plus' }}"></i>
                                {{ $isEditMode ? 'Update Item' : 'Add Item' }}
                            </button>
                            @if($isEditMode)
                                <button type="button" wire:click="resetItemForm" class="btn btn-outline-secondary radius-30">
                                    <i class="bx bx-x"></i> Cancel
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Invoice Preview -->
        <div class="col-12 col-lg-8">
            <div class="card radius-10 invoice-print-area">
                <div class="card-body p-4">
                    <!-- Invoice Header -->
                    <div class="invoice-header mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <img src="{{ asset('admin/images/logo-icon.png') }}" width="60" alt="Logo" class="mb-2">
                                <h4 class="text-primary mb-0">INVOICE</h4>
                                <p class="text-muted mb-0">#INV-{{ $invoice?->user->id ?? '0' }}-{{ $clientId }}-{{ $invoiceId }}</p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h5 class="mb-1">{{ config('app.name', 'Company Name') }}</h5>
                                <p class="text-muted mb-0 small">
                                    455 Foggy Heights, AZ 85004, US<br>
                                    (123) 456-789<br>
                                    company@example.com
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Invoice To & Details -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">INVOICE TO:</h6>
                            <h5 class="mb-1">{{ $client?->clientname }}</h5>
                            <p class="text-muted mb-0">
                                {{ $client?->clientaddress }}<br>
                                {{ $client?->clientcity }}, {{ $client?->clientcountry }}<br>
                                <a href="mailto:{{ $client?->clientemail }}">{{ $client?->clientemail }}</a><br>
                                {{ $client?->clientphone }}
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="mb-2">
                                <span class="text-muted">Date:</span>
                                <strong>{{ $invoice?->created_at?->format('d M Y') }}</strong>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Due Date:</span>
                                <strong>{{ $invoice?->created_at?->addDays(30)->format('d M Y') }}</strong>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted">Control Number:</span>
                                @if($invoice?->control_number)
                                    <span class="badge bg-success">{{ $invoice?->control_number }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">Not Generated</span>
                                @endif
                            </div>
                            <div>
                                <span class="text-muted">Status:</span>
                                @switch($invoice?->Status)
                                    @case('Paid')
                                        <span class="badge bg-success">Paid</span>
                                        @break
                                    @case('Active')
                                        <span class="badge bg-warning text-dark">Active</span>
                                        @break
                                    @case('Expired')
                                        <span class="badge bg-danger">Expired</span>
                                        @break
                                    @default
                                        <span class="badge bg-info">Pending</span>
                                @endswitch
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Items Table -->
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Description</th>
                                    <th class="text-center" style="width: 80px;">Qty</th>
                                    <th class="text-end" style="width: 150px;">Unit Price</th>
                                    <th class="text-end" style="width: 150px;">Total</th>
                                    @if($invoice?->Status === 'Pending')
                                        <th class="text-center no-print" style="width: 100px;">Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoice_items ?? [] as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($item->service_type_id)
                                                    <div class="item-icon bg-info bg-opacity-10 rounded-circle p-2 me-2">
                                                        <i class="bx {{ $item->serviceType->icon ?? 'bx-briefcase' }} text-info"></i>
                                                    </div>
                                                @else
                                                    <div class="item-icon bg-warning bg-opacity-10 rounded-circle p-2 me-2">
                                                        <i class="bx bx-package text-warning"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ $item->item_name }}</h6>
                                                    @if($item->description)
                                                        <small class="text-muted">{{ $item->description }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-end">{{ number_format($item->amount, 0) }}</td>
                                        <td class="text-end fw-bold">{{ number_format($item->quantity * $item->amount, 0) }}</td>
                                        @if($invoice?->Status === 'Pending')
                                            <td class="text-center no-print">
                                                <div class="btn-group btn-group-sm">
                                                    <button wire:click="editItem({{ $item->id }})"
                                                            class="btn btn-outline-primary"
                                                            title="Edit">
                                                        <i class="bx bx-edit"></i>
                                                    </button>
                                                    <button wire:click="delete({{ $item->id }})"
                                                            wire:confirm="Are you sure you want to delete this item?"
                                                            class="btn btn-outline-danger"
                                                            title="Delete">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $invoice?->Status === 'Pending' ? 6 : 5 }}" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bx bx-receipt fs-1 d-block mb-3"></i>
                                                <h5>No items yet</h5>
                                                <p class="mb-0">Add services or products to this invoice.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            @if(count($invoice_items ?? []) > 0)
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-semibold">Subtotal:</td>
                                    <td class="text-end fw-semibold">{{ number_format($subtotal, 0) }} TZS</td>
                                    @if($invoice?->Status === 'Pending')
                                        <td class="no-print"></td>
                                    @endif
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-end fw-semibold">VAT (18%):</td>
                                    <td class="text-end fw-semibold">{{ number_format($tax, 0) }} TZS</td>
                                    @if($invoice?->Status === 'Pending')
                                        <td class="no-print"></td>
                                    @endif
                                </tr>
                                <tr class="table-primary">
                                    <td colspan="4" class="text-end fw-bold fs-5">Grand Total:</td>
                                    <td class="text-end fw-bold fs-5 text-primary">{{ number_format($totalAmount, 0) }} TZS</td>
                                    @if($invoice?->Status === 'Pending')
                                        <td class="no-print"></td>
                                    @endif
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>

                    <!-- Invoice Footer -->
                    <div class="mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">Payment Information</h6>
                                <p class="small mb-0">
                                    @if($invoice?->control_number)
                                        <strong>Control Number:</strong> {{ $invoice->control_number }}<br>
                                    @endif
                                    <strong>Bank:</strong> Bank Name<br>
                                    <strong>Account:</strong> 1234567890
                                </p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h6 class="text-muted">Notes</h6>
                                <p class="small mb-0">
                                    A finance charge of 1.5% will be made on unpaid balances after 30 days.
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="text-center text-muted small">
                            <p class="mb-0">Thank you for your business!</p>
                            <p class="mb-0">Invoice was created on a computer and is valid without signature and seal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .status-icon {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .item-icon {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-check:checked + .btn-outline-primary {
            background-color: #0d6efd;
            color: white;
        }

        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }

            /* Hide EVERYTHING first */
            body * {
                visibility: hidden;
            }

            /* Show only invoice print area and its children */
            .invoice-print-area,
            .invoice-print-area * {
                visibility: visible;
            }

            /* Position invoice at top left */
            .invoice-print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none !important;
                box-shadow: none !important;
                background: #fff !important;
            }

            .invoice-print-area .card-body {
                padding: 20px !important;
            }

            /* Body reset */
            body {
                background: #fff !important;
                font-size: 11pt !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Header layout */
            .invoice-header .row {
                display: flex !important;
                justify-content: space-between !important;
            }

            .invoice-header .col-md-6 {
                width: 48% !important;
                flex: 0 0 48% !important;
            }

            /* Invoice details row */
            .invoice-print-area .row.mb-4 {
                display: flex !important;
                justify-content: space-between !important;
            }

            .invoice-print-area .row.mb-4 .col-md-6 {
                width: 48% !important;
                flex: 0 0 48% !important;
            }

            /* Table */
            .table-responsive {
                overflow: visible !important;
            }

            .table {
                width: 100% !important;
                border-collapse: collapse !important;
            }

            .table th,
            .table td {
                padding: 8px 10px !important;
                border: 1px solid #ddd !important;
            }

            .table-dark th {
                background: #333 !important;
                color: #fff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .table-light td {
                background: #f8f8f8 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .table-primary td {
                background: #e3f2fd !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Text */
            .text-end { text-align: right !important; }
            .text-center { text-align: center !important; }
            .text-md-end { text-align: right !important; }
            .fw-bold { font-weight: bold !important; }

            /* Badge */
            .badge {
                padding: 4px 8px !important;
                border-radius: 4px !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .badge.bg-success { background: #28a745 !important; color: #fff !important; }
            .badge.bg-warning { background: #ffc107 !important; color: #000 !important; }
            .badge.bg-info { background: #17a2b8 !important; color: #fff !important; }
            .badge.bg-danger { background: #dc3545 !important; color: #fff !important; }

            /* Footer row */
            .invoice-print-area .mt-4 .row {
                display: flex !important;
                justify-content: space-between !important;
            }

            .invoice-print-area .mt-4 .col-md-6 {
                width: 48% !important;
                flex: 0 0 48% !important;
            }

            /* Item icon - hide for cleaner print */
            .item-icon {
                display: none !important;
            }

            /* Hide action buttons column */
            .no-print {
                display: none !important;
                visibility: hidden !important;
            }
        }
    </style>
</div>
