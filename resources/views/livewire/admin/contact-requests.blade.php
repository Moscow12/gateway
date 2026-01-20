<div>
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">CRM</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact Requests</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card radius-10 border-start border-0 border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Requests</p>
                            <h4 class="my-1 text-primary">{{ $stats['total'] }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
                            <i class='bx bx-envelope'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card radius-10 border-start border-0 border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">New</p>
                            <h4 class="my-1 text-info">{{ $stats['new'] }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto">
                            <i class='bx bx-bell'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card radius-10 border-start border-0 border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">In Progress</p>
                            <h4 class="my-1 text-warning">{{ $stats['in_progress'] }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto">
                            <i class='bx bx-time'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card radius-10 border-start border-0 border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Resolved</p>
                            <h4 class="my-1 text-success">{{ $stats['resolved'] }}</h4>
                        </div>
                        <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                            <i class='bx bx-check-circle'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card">
        <div class="card-header bg-transparent">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <h5 class="mb-0">Contact Requests</h5>
                </div>
                <div class="col-md-8">
                    <div class="d-flex gap-2 justify-content-md-end flex-wrap">
                        <!-- Search -->
                        <div class="position-relative">
                            <input type="text"
                                   wire:model.live.debounce.300ms="search"
                                   class="form-control ps-5"
                                   placeholder="Search...">
                            <span class="position-absolute top-50 translate-middle-y" style="left: 10px;">
                                <i class="bx bx-search"></i>
                            </span>
                        </div>
                        <!-- Status Filter -->
                        <select wire:model.live="statusFilter" class="form-select" style="width: auto;">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <!-- Priority Filter -->
                        <select wire:model.live="priorityFilter" class="form-select" style="width: auto;">
                            <option value="">All Priorities</option>
                            @foreach($priorities as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Contact</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Acknowledged</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                            <tr class="{{ $request->status === 'new' ? 'table-info' : '' }}">
                                <td>
                                    <small class="text-muted">{{ $request->created_at->format('M d, Y') }}</small><br>
                                    <small class="text-muted">{{ $request->created_at->format('h:i A') }}</small>
                                </td>
                                <td>
                                    <strong>{{ $request->name }}</strong><br>
                                    <small class="text-muted">{{ $request->email }}</small>
                                    @if($request->company)
                                        <br><small class="text-muted"><i class="bx bx-building"></i> {{ $request->company }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="d-inline-block text-truncate" style="max-width: 200px;" title="{{ $request->subject }}">
                                        {{ $request->subject }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $request->status_color }}">
                                        {{ $statuses[$request->status] ?? $request->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-{{ $request->priority_color }} dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            {{ $priorities[$request->priority] ?? $request->priority }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach($priorities as $key => $label)
                                                <li>
                                                    <a class="dropdown-item" href="#" wire:click.prevent="updatePriority({{ $request->id }}, '{{ $key }}')">
                                                        {{ $label }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    @if($request->acknowledged_at)
                                        <small class="text-success">
                                            <i class="bx bx-check"></i>
                                            {{ $request->acknowledged_at->format('M d, Y') }}
                                        </small>
                                        @if($request->acknowledgedBy)
                                            <br><small class="text-muted">by {{ $request->acknowledgedBy->name }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex gap-1 justify-content-end">
                                        <button class="btn btn-sm btn-outline-info" wire:click="viewRequest({{ $request->id }})" title="View">
                                            <i class="bx bx-show"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success" wire:click="openAcknowledgeModal({{ $request->id }})" title="Acknowledge/Update">
                                            <i class="bx bx-check-double"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" wire:click="confirmDelete({{ $request->id }})" title="Delete">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="bx bx-inbox fs-1 d-block mb-2"></i>
                                        No contact requests found
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <select wire:model.live="perPage" class="form-select form-select-sm" style="width: auto;">
                        <option value="10">10 per page</option>
                        <option value="25">25 per page</option>
                        <option value="50">50 per page</option>
                    </select>
                </div>
                <div>
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    @if($showViewModal && $viewingRequest)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bx bx-envelope me-2"></i>Contact Request Details
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeViewModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Name</label>
                                <p class="mb-0 fw-bold">{{ $viewingRequest->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Email</label>
                                <p class="mb-0">
                                    <a href="mailto:{{ $viewingRequest->email }}">{{ $viewingRequest->email }}</a>
                                </p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Phone</label>
                                <p class="mb-0">{{ $viewingRequest->phone ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Company</label>
                                <p class="mb-0">{{ $viewingRequest->company ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Status</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $viewingRequest->status_color }}">
                                        {{ $statuses[$viewingRequest->status] ?? $viewingRequest->status }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Priority</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $viewingRequest->priority_color }}">
                                        {{ $priorities[$viewingRequest->priority] ?? $viewingRequest->priority }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Subject</label>
                            <p class="mb-0 fw-bold">{{ $viewingRequest->subject }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small">Message</label>
                            <div class="p-3 bg-light rounded">
                                {!! nl2br(e($viewingRequest->message)) !!}
                            </div>
                        </div>
                        @if($viewingRequest->notes)
                            <div class="mb-3">
                                <label class="form-label text-muted small">Internal Notes</label>
                                <div class="p-3 bg-warning bg-opacity-10 rounded">
                                    {!! nl2br(e($viewingRequest->notes)) !!}
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Submitted</label>
                                <p class="mb-0">{{ $viewingRequest->created_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                            <div class="col-md-6">
                                @if($viewingRequest->acknowledged_at)
                                    <label class="form-label text-muted small">Acknowledged</label>
                                    <p class="mb-0">
                                        {{ $viewingRequest->acknowledged_at->format('F j, Y \a\t g:i A') }}
                                        @if($viewingRequest->acknowledgedBy)
                                            <br><small class="text-muted">by {{ $viewingRequest->acknowledgedBy->name }}</small>
                                        @endif
                                    </p>
                                @endif
                            </div>
                        </div>
                        @if($viewingRequest->ip_address)
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <small class="text-muted">
                                        <i class="bx bx-globe me-1"></i>IP: {{ $viewingRequest->ip_address }}
                                    </small>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <a href="mailto:{{ $viewingRequest->email }}?subject=Re: {{ $viewingRequest->subject }}" class="btn btn-primary">
                            <i class="bx bx-reply me-1"></i>Reply via Email
                        </a>
                        <button type="button" class="btn btn-secondary" wire:click="closeViewModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Acknowledge Modal -->
    @if($showAcknowledgeModal && $acknowledgingRequest)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bx bx-check-double me-2"></i>Update Request Status
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeAcknowledgeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <p class="text-muted mb-1">Request from:</p>
                            <p class="fw-bold mb-0">{{ $acknowledgingRequest->name }} - {{ $acknowledgingRequest->subject }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select wire:model="newStatus" class="form-select">
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Internal Notes</label>
                            <textarea wire:model="acknowledgeNotes" class="form-control" rows="3" placeholder="Add notes about this request (internal use only)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeAcknowledgeModal">Cancel</button>
                        <button type="button" class="btn btn-success" wire:click="acknowledge">
                            <i class="bx bx-check me-1"></i>Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Modal -->
    @if($showDeleteModal && $deletingRequest)
        <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger">
                            <i class="bx bx-trash me-2"></i>Delete Contact Request
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeDeleteModal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this contact request?</p>
                        <div class="p-3 bg-light rounded">
                            <strong>{{ $deletingRequest->name }}</strong><br>
                            <span class="text-muted">{{ $deletingRequest->subject }}</span>
                        </div>
                        <p class="text-danger mt-3 mb-0">
                            <i class="bx bx-error me-1"></i>This action cannot be undone.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeDeleteModal">Cancel</button>
                        <button type="button" class="btn btn-danger" wire:click="delete">
                            <i class="bx bx-trash me-1"></i>Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
