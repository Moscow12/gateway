<div>
    <!-- Page Header -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Dashboard</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Overview</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <span class="text-muted">{{ now()->format('l, F j, Y') }}</span>
        </div>
    </div>

    <!-- Revenue Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card radius-10 border-0 border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 text-muted">Total Revenue</p>
                            <h4 class="mb-0 text-primary">TZS {{ number_format($totalRevenue, 0) }}</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bx bx-wallet"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card radius-10 border-0 border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 text-muted">Paid Revenue</p>
                            <h4 class="mb-0 text-success">TZS {{ number_format($paidRevenue, 0) }}</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-success bg-opacity-10 text-success">
                            <i class="bx bx-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card radius-10 border-0 border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 text-muted">Pending Payments</p>
                            <h4 class="mb-0 text-warning">TZS {{ number_format($pendingRevenue, 0) }}</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bx bx-time-five"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card radius-10 border-0 border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-1 text-muted">This Month</p>
                            <h4 class="mb-0 text-info">TZS {{ number_format($monthlyRevenue, 0) }}</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-info bg-opacity-10 text-info">
                            <i class="bx bx-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Status Overview Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12">
            <h6 class="mb-3 text-uppercase text-muted fw-semibold">
                <i class="bx bx-briefcase me-2"></i>Service Status Overview
            </h6>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card radius-10 h-100">
                <div class="card-body text-center py-4">
                    <div class="widget-icon mx-auto mb-3 bg-primary bg-opacity-10 text-primary rounded-circle">
                        <i class="bx bx-layer fs-4"></i>
                    </div>
                    <h3 class="mb-1">{{ $totalServices }}</h3>
                    <p class="mb-0 text-muted small">Total Services</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card radius-10 h-100">
                <div class="card-body text-center py-4">
                    <div class="widget-icon mx-auto mb-3 bg-success bg-opacity-10 text-success rounded-circle">
                        <i class="bx bx-check-circle fs-4"></i>
                    </div>
                    <h3 class="mb-1 text-success">{{ $activeServices }}</h3>
                    <p class="mb-0 text-muted small">Active</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card radius-10 h-100">
                <div class="card-body text-center py-4">
                    <div class="widget-icon mx-auto mb-3 bg-warning bg-opacity-10 text-warning rounded-circle">
                        <i class="bx bx-time-five fs-4"></i>
                    </div>
                    <h3 class="mb-1 text-warning">{{ $pendingServices }}</h3>
                    <p class="mb-0 text-muted small">Pending</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card radius-10 h-100">
                <div class="card-body text-center py-4">
                    <div class="widget-icon mx-auto mb-3 bg-danger bg-opacity-10 text-danger rounded-circle">
                        <i class="bx bx-x-circle fs-4"></i>
                    </div>
                    <h3 class="mb-1 text-danger">{{ $expiredServices }}</h3>
                    <p class="mb-0 text-muted small">Expired</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card radius-10 h-100">
                <div class="card-body text-center py-4">
                    <div class="widget-icon mx-auto mb-3 bg-info bg-opacity-10 text-info rounded-circle">
                        <i class="bx bx-error-circle fs-4"></i>
                    </div>
                    <h3 class="mb-1 text-info">{{ $expiringSoonServices }}</h3>
                    <p class="mb-0 text-muted small">Expiring Soon</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="card radius-10 h-100">
                <div class="card-body text-center py-4">
                    <div class="widget-icon mx-auto mb-3 bg-secondary bg-opacity-10 text-secondary rounded-circle">
                        <i class="bx bx-user fs-4"></i>
                    </div>
                    <h3 class="mb-1">{{ $totalClients }}</h3>
                    <p class="mb-0 text-muted small">Total Clients</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <!-- Recent Invoices -->
        <div class="col-lg-8">
            <div class="card radius-10">
                <div class="card-header bg-transparent">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">
                            <i class="bx bx-receipt me-2"></i>Recent Invoices
                        </h6>
                        <a href="{{ route('clients') }}" class="btn btn-sm btn-outline-primary radius-30">
                            View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Client</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentInvoices as $invoice)
                                    <tr>
                                        <td>
                                            <a href="{{ route('clientinvoice', ['clientId' => $invoice->client_id, 'invoiceId' => $invoice->id]) }}" class="text-primary fw-semibold">
                                                #{{ $invoice->control_number ?? 'INV-' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle me-2">
                                                    {{ strtoupper(substr($invoice->client->clientname ?? 'N', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <span class="fw-semibold">{{ $invoice->client->clientname ?? 'N/A' }}</span>
                                                    @if($invoice->client?->clientcode)
                                                        <small class="d-block text-muted">{{ $invoice->client->clientcode }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-semibold">TZS {{ number_format($invoice->TotalAmount, 0) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = match(strtolower($invoice->Status ?? '')) {
                                                    'paid' => 'bg-success',
                                                    'pending' => 'bg-warning',
                                                    'overdue' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }} bg-opacity-10 text-{{ str_replace('bg-', '', $statusClass) }}">
                                                {{ ucfirst($invoice->Status ?? 'Unpaid') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $invoice->created_at->format('M d, Y') }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="bx bx-receipt fs-1 text-muted d-block mb-2"></i>
                                            <span class="text-muted">No invoices found</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expiring Soon Services -->
        <div class="col-lg-4">
            <div class="card radius-10 h-100">
                <div class="card-header bg-transparent">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="mb-0">
                            <i class="bx bx-error-circle text-warning me-2"></i>Expiring Soon
                        </h6>
                        <a href="{{ route('client-services') }}" class="btn btn-sm btn-outline-warning radius-30">
                            View All
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @forelse($expiringSoonList as $service)
                        <div class="d-flex align-items-center p-3 border-bottom">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $service->client->clientname ?? 'Unknown Client' }}</h6>
                                <small class="text-muted">{{ $service->serviceType->name ?? 'Service' }}</small>
                            </div>
                            <div class="text-end">
                                @php
                                    $daysLeft = $service->days_left;
                                    $badgeClass = $daysLeft <= 7 ? 'bg-danger' : ($daysLeft <= 14 ? 'bg-warning' : 'bg-info');
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $daysLeft }} days</span>
                                <small class="d-block text-muted">{{ $service->license_end_date?->format('M d, Y') }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bx bx-check-circle fs-1 text-success d-block mb-2"></i>
                            <span class="text-muted">No services expiring soon</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue Chart -->
    <div class="row g-3 mt-3">
        <div class="col-12">
            <div class="card radius-10">
                <div class="card-header bg-transparent">
                    <h6 class="mb-0">
                        <i class="bx bx-line-chart me-2"></i>Monthly Revenue (Last 6 Months)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        @foreach($monthlyRevenueChart as $data)
                            <div class="col-2 text-center">
                                <div class="progress-wrapper">
                                    @php
                                        $maxRevenue = collect($monthlyRevenueChart)->max('revenue') ?: 1;
                                        $percentage = ($data['revenue'] / $maxRevenue) * 100;
                                    @endphp
                                    <div class="progress progress-vertical" style="height: 120px;">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                             style="height: {{ max($percentage, 5) }}%;"
                                             aria-valuenow="{{ $percentage }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                    <p class="mb-1 mt-2 fw-semibold">{{ $data['month'] }}</p>
                                    <small class="text-muted">{{ number_format($data['revenue'] / 1000, 0) }}K</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .widget-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.5rem;
        }
        .widget-icon.rounded-circle {
            border-radius: 50% !important;
        }
        .avatar {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
        }
        .progress-vertical {
            width: 30px;
            display: flex;
            align-items: flex-end;
            margin: 0 auto;
            background-color: #e9ecef;
            border-radius: 5px;
        }
        .progress-vertical .progress-bar {
            width: 100%;
            border-radius: 5px;
            transition: height 0.5s ease;
        }
    </style>
</div>
