<div>
    @php
        $pending = $statusAmount?->firstWhere('status', 'Pending');
        $Paid = $statusAmount?->firstWhere('status', 'Paid');
        $Active = $statusAmount?->firstWhere('status', 'Active');
        $Expired = $statusAmount?->firstWhere('status', 'Expired');
        $totalAmount = $statusAmount?->sum('total') ?? 0;
    @endphp

    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Client Profile</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('clients') }}">Clients</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $client->clientname ?? 'Client Details' }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('clients') }}" class="btn btn-outline-secondary radius-30 me-2">
                <i class="bx bx-arrow-back"></i> Back to Clients
            </a>
            <button wire:click="createinvoice" class="btn btn-primary radius-30">
                <i class="bx bx-plus"></i> Create Invoice
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
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
        <!-- Client Profile Card -->
        <div class="col-12 col-lg-4">
            <!-- Client Info Card -->
            <div class="card radius-10">
                <div class="card-body">
                    <div class="text-center">
                        <div class="client-avatar-lg bg-primary bg-opacity-10 rounded-circle mx-auto mb-3">
                            <span class="text-primary fw-bold fs-1">{{ strtoupper(substr($client->clientname ?? 'C', 0, 2)) }}</span>
                        </div>
                        <h4 class="mb-1">{{ $client->clientname ?? 'Unknown Client' }}</h4>
                        @if($client->clientcode)
                            <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 mb-3">
                                <i class="bx bx-hash"></i> {{ $client->clientcode }}
                            </span>
                        @endif
                    </div>

                    <hr>

                    <div class="client-details">
                        <div class="d-flex align-items-center mb-3">
                            <div class="detail-icon bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bx bx-envelope text-primary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <span>{{ $client->clientemail ?: 'Not provided' }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="detail-icon bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bx bx-phone text-success"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Phone</small>
                                <span>{{ $client->clientphone ?: 'Not provided' }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="detail-icon bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bx bx-map text-warning"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Address</small>
                                <span>{{ $client->clientaddress ?: 'Not provided' }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <div class="detail-icon bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bx bx-buildings text-info"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">City</small>
                                <span>{{ $client->clientcity ?: 'Not provided' }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="detail-icon bg-secondary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bx bx-globe text-secondary"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Country</small>
                                <span>{{ $client->clientcountry ?: 'Not provided' }}</span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="d-grid gap-2">
                        <a href="{{ route('clients.editclient', $client->id) }}" class="btn btn-outline-primary radius-30">
                            <i class="bx bx-edit"></i> Edit Client
                        </a>
                    </div>
                </div>
            </div>

            <!-- Invoice Summary Card -->
            <div class="card radius-10">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0"><i class="bx bx-receipt me-2"></i>Invoice Summary</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-primary mb-0">{{ number_format($Paid->total ?? 0, 0) }} TZS</h5>
                        <span class="badge bg-success">Paid</span>
                    </div>

                    <div class="progress mb-4" style="height: 8px;">
                        @php
                            $paidPercent = $totalAmount > 0 ? (($Paid->total ?? 0) / $totalAmount) * 100 : 0;
                            $activePercent = $totalAmount > 0 ? (($Active->total ?? 0) / $totalAmount) * 100 : 0;
                            $pendingPercent = $totalAmount > 0 ? (($pending->total ?? 0) / $totalAmount) * 100 : 0;
                            $expiredPercent = $totalAmount > 0 ? (($Expired->total ?? 0) / $totalAmount) * 100 : 0;
                        @endphp
                        <div class="progress-bar bg-success" style="width: {{ $paidPercent }}%"></div>
                        <div class="progress-bar bg-warning" style="width: {{ $activePercent }}%"></div>
                        <div class="progress-bar bg-info" style="width: {{ $pendingPercent }}%"></div>
                        <div class="progress-bar bg-danger" style="width: {{ $expiredPercent }}%"></div>
                    </div>

                    <div class="summary-item d-flex align-items-center justify-content-between py-2 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="status-dot bg-success me-2"></div>
                            <span>Paid</span>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-success bg-opacity-10 text-success">{{ $Paid->count ?? 0 }}</span>
                            <span class="ms-2 fw-semibold">{{ number_format($Paid->total ?? 0, 0) }}</span>
                        </div>
                    </div>

                    <div class="summary-item d-flex align-items-center justify-content-between py-2 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="status-dot bg-warning me-2"></div>
                            <span>Active</span>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-warning bg-opacity-10 text-warning">{{ $Active->count ?? 0 }}</span>
                            <span class="ms-2 fw-semibold">{{ number_format($Active->total ?? 0, 0) }}</span>
                        </div>
                    </div>

                    <div class="summary-item d-flex align-items-center justify-content-between py-2 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="status-dot bg-info me-2"></div>
                            <span>Pending</span>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-info bg-opacity-10 text-info">{{ $pending->count ?? 0 }}</span>
                            <span class="ms-2 fw-semibold">{{ number_format($pending->total ?? 0, 0) }}</span>
                        </div>
                    </div>

                    <div class="summary-item d-flex align-items-center justify-content-between py-2">
                        <div class="d-flex align-items-center">
                            <div class="status-dot bg-danger me-2"></div>
                            <span>Expired</span>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-danger bg-opacity-10 text-danger">{{ $Expired->count ?? 0 }}</span>
                            <span class="ms-2 fw-semibold">{{ number_format($Expired->total ?? 0, 0) }}</span>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Total</span>
                        <h5 class="mb-0 text-primary">{{ number_format($totalAmount, 0) }} TZS</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-12 col-lg-8">
            <!-- Statistics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card radius-10 border-start border-primary border-4">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary small">Total Invoices</p>
                                    <h4 class="my-1 text-primary">{{ count($invoices) }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-primary bg-opacity-10 text-primary ms-auto">
                                    <i class="bx bx-receipt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card radius-10 border-start border-success border-4">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary small">Paid</p>
                                    <h4 class="my-1 text-success">{{ $Paid->count ?? 0 }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-success bg-opacity-10 text-success ms-auto">
                                    <i class="bx bx-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card radius-10 border-start border-warning border-4">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary small">Pending</p>
                                    <h4 class="my-1 text-warning">{{ $pending->count ?? 0 }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-warning bg-opacity-10 text-warning ms-auto">
                                    <i class="bx bx-time-five"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card radius-10 border-start border-info border-4">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary small">Services</p>
                                    <h4 class="my-1 text-info">{{ count($clientServices ?? []) }}</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-info bg-opacity-10 text-info ms-auto">
                                    <i class="bx bx-briefcase"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Client Services Card -->
            @if(count($clientServices ?? []) > 0)
            <div class="card radius-10 mb-4">
                <div class="card-header bg-transparent d-flex align-items-center justify-content-between">
                    <h6 class="mb-0"><i class="bx bx-briefcase me-2"></i>Active Services</h6>
                    <a href="{{ route('client-services') }}?clientFilter={{ $clientId }}" class="btn btn-sm btn-outline-primary radius-30">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($clientServices->take(4) as $service)
                            <div class="col-md-6">
                                <div class="service-card p-3 border radius-10 {{ $service->status === 'active' ? 'border-success' : ($service->status === 'pending' ? 'border-warning' : 'border-secondary') }}">
                                    <div class="d-flex align-items-center">
                                        <div class="service-icon bg-{{ $service->status === 'active' ? 'success' : ($service->status === 'pending' ? 'warning' : 'secondary') }} bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="bx {{ $service->serviceType->icon ?? 'bx-cog' }} text-{{ $service->status === 'active' ? 'success' : ($service->status === 'pending' ? 'warning' : 'secondary') }}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $service->serviceType->name ?? 'Unknown Service' }}</h6>
                                            <div class="d-flex align-items-center">
                                                <span class="badge {{ $service->status_badge_class }} me-2">
                                                    {{ ucfirst(str_replace('_', ' ', $service->status)) }}
                                                </span>
                                                @if($service->days_left !== null)
                                                    @if($service->days_left <= 30 && $service->days_left > 0)
                                                        <small class="text-warning">{{ $service->days_left }} days left</small>
                                                    @elseif($service->days_left === 0)
                                                        <small class="text-danger">Expired</small>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Invoices Table Card -->
            <div class="card radius-10">
                <div class="card-header bg-transparent d-flex align-items-center justify-content-between">
                    <h6 class="mb-0"><i class="bx bx-receipt me-2"></i>Recent Invoices</h6>
                    <div>
                        <button wire:click="createinvoice" class="btn btn-sm btn-primary radius-30">
                            <i class="bx bx-plus"></i> New Invoice
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Created Date</th>
                                    <th>Due Date</th>
                                    <th>Control Number</th>
                                    <th>Items</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th style="width: 120px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $index => $invoice)
                                    <tr>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <span>{{ $invoice->created_at->format('d M Y') }}</span>
                                                <small class="text-muted d-block">{{ $invoice->created_at->format('h:i A') }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="{{ $invoice->created_at->addDays(30)->isPast() ? 'text-danger' : '' }}">
                                                {{ $invoice->created_at->addDays(30)->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($invoice->control_number)
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1">
                                                    {{ $invoice->control_number }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ $invoice->invoiceitems->count() }} items
                                            </span>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-primary">
                                                {{ number_format($invoice->invoiceitems->sum('amount'), 0) }}
                                            </span>
                                            <small class="text-muted">TZS</small>
                                        </td>
                                        <td>
                                            @switch($invoice->Status)
                                                @case('Paid')
                                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">
                                                        <i class="bx bx-check-circle me-1"></i>Paid
                                                    </span>
                                                    @break
                                                @case('Active')
                                                    <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2">
                                                        <i class="bx bx-loader-circle me-1"></i>Active
                                                    </span>
                                                    @break
                                                @case('Pending')
                                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                                        <i class="bx bx-time-five me-1"></i>Pending
                                                    </span>
                                                    @break
                                                @case('Expired')
                                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2">
                                                        <i class="bx bx-x-circle me-1"></i>Expired
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">
                                                        {{ $invoice->Status ?? 'Unknown' }}
                                                    </span>
                                            @endswitch
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('clientinvoice', ['clientId' => $invoice->client_id, 'invoiceId' => $invoice->id]) }}"
                                                   class="btn btn-sm btn-outline-info radius-30"
                                                   title="View Invoice">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <button wire:click="delete({{ $invoice->id }})"
                                                        wire:confirm="Are you sure you want to delete this invoice?"
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
                                                <i class="bx bx-receipt fs-1 d-block mb-3"></i>
                                                <h5>No invoices yet</h5>
                                                <p class="mb-3">Create the first invoice for this client.</p>
                                                <button wire:click="createinvoice" class="btn btn-primary radius-30">
                                                    <i class="bx bx-plus"></i> Create Invoice
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .client-avatar-lg {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .detail-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .service-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .widgets-icons-2 {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }
        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        .service-card {
            transition: all 0.2s ease;
        }
        .service-card:hover {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
    </style>
</div>
