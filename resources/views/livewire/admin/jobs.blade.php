
<div>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">APPLICANT LIST</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Application list</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <span class="badge bg-primary fs-6">{{ count($applicantslists) }} Applicants</span>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <!-- Filters Section -->
            <div class="row g-3 mb-4">
                <!-- Search -->
                <div class="col-md-4">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" wire:model.live.debounce.300ms="search" placeholder="Search by name, phone, email...">
                        <span class="position-absolute top-50 translate-middle-y" style="left: 15px;"><i class="bx bx-search"></i></span>
                    </div>
                </div>

                <!-- Vacancy Filter -->
                <div class="col-md-3">
                    <select class="form-select radius-30" wire:model.live="vacancyFilter">
                        <option value="">All Vacancies</option>
                        @foreach($vacancies as $vacancy)
                            <option value="{{ $vacancy->id }}">{{ $vacancy->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="col-md-3">
                    <select class="form-select radius-30" wire:model.live="status">
                        <option value="">All Status</option>
                        <option value="Active">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>

                <!-- Clear Filters -->
                <div class="col-md-2">
                    @if($search || $status || $vacancyFilter)
                        <button wire:click="clearFilters" class="btn btn-outline-secondary radius-30 w-100">
                            <i class="bx bx-x"></i> Clear
                        </button>
                    @endif
                </div>
            </div>

            <!-- Active Filters Display -->
            @if($search || $status || $vacancyFilter)
            <div class="mb-3">
                <span class="text-muted">Active Filters:</span>
                @if($search)
                    <span class="badge bg-info ms-2">Search: {{ $search }}</span>
                @endif
                @if($vacancyFilter)
                    <span class="badge bg-primary ms-2">Vacancy: {{ $vacancies->find($vacancyFilter)?->title }}</span>
                @endif
                @if($status)
                    <span class="badge bg-warning ms-2">Status: {{ $status }}</span>
                @endif
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Vacancy Applied</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th>Applied Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applicantslists as $index => $list)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm bg-light-primary text-primary rounded-circle me-2">
                                        {{ strtoupper(substr($list->ApplicantName, 0, 1)) }}
                                    </div>
                                    <span>{{ $list->ApplicantName }}</span>
                                </div>
                            </td>
                            <td>
                                @if($list->vacancy)
                                    <span class="badge bg-primary">{{ $list->vacancy->title }}</span>
                                @else
                                    <span class="badge bg-secondary">N/A</span>
                                @endif
                            </td>
                            <td>{{ $list->ApplicantEmail }}</td>
                            <td>{{ $list->phone }}</td>
                            <td>{{ $list->Gender }}</td>
                            <td>
                                @switch($list->status)
                                    @case('Approved')
                                        <span class="badge bg-success">Approved</span>
                                        @break
                                    @case('Rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                        @break
                                    @default
                                        <span class="badge bg-warning text-dark">Pending</span>
                                @endswitch
                            </td>
                            <td>{{ $list->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('applicantdetails', $list->id) }}" class="btn btn-primary btn-sm radius-30">
                                    <i class="bx bx-show"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bx bx-search-alt fs-1"></i>
                                    <p class="mt-2 mb-0">No applicants found</p>
                                    @if($search || $status || $vacancyFilter)
                                        <button wire:click="clearFilters" class="btn btn-sm btn-outline-primary mt-2">Clear Filters</button>
                                    @endif
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

@push('scripts')
<script>
    window.addEventListener('modal-show', () => {
        $('#jabad').modal('show');
    });
</script>
@endpush
