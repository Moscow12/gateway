<div>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">{{ $applicantdata->ApplicantName }}</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('jobslist') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('jobslist') }}">Applicants</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Application Details</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('jobslist') }}" class="btn btn-outline-primary">
                <i class="bx bx-arrow-back"></i> Back to List
            </a>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="row g-0">
            <!-- Left Sidebar - Applicant Profile -->
            <div class="col-md-3 border-end">
                <div class="card-body text-center">
                    <div class="p-4 border radius-15">
                        <img src="{{ asset('admin/images/avatars/avatar.jpg') }}" width="110" height="110" class="rounded-circle shadow" alt="">
                        <h5 class="mb-0 mt-4">{{ $applicantdata->ApplicantName }}</h5>
                        <p class="mb-1 text-muted">{{ $applicantdata->Gender }}</p>

                        @if($applicantdata->vacancy)
                        <div class="badge bg-primary mb-3">
                            <i class="bx bx-briefcase"></i> {{ $applicantdata->vacancy->title }}
                        </div>
                        @else
                        <div class="badge bg-secondary mb-3">No Vacancy Selected</div>
                        @endif

                        <hr>

                        <div class="text-start">
                            <p class="mb-2"><strong><i class="bx bx-heart"></i> Marital Status:</strong> {{ $applicantdata->MaritalStatus }}</p>
                            <p class="mb-2"><strong><i class="bx bx-cake"></i> Age:</strong> {{ $age }} years</p>
                            <p class="mb-2"><strong><i class="bx bx-id-card"></i> NIDA:</strong> {{ $applicantdata->Nida ?? 'N/A' }}</p>
                            <p class="mb-2"><strong><i class="bx bx-envelope"></i> Email:</strong> {{ $applicantdata->ApplicantEmail }}</p>
                            <p class="mb-2"><strong><i class="bx bx-phone"></i> Phone:</strong> {{ $applicantdata->phone }}</p>
                            <p class="mb-2"><strong><i class="bx bx-map"></i> Location:</strong> {{ $applicantdata->Location }}</p>
                        </div>

                        <hr>

                        <!-- Score Summary -->
                        @if($scores->count() > 0)
                        <div class="score-summary mt-3">
                            <h6 class="mb-2">Interview Score Summary</h6>
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <div class="display-6 fw-bold text-primary">{{ $applicantdata->averagePercentage }}%</div>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-{{ $applicantdata->averagePercentage >= 70 ? 'success' : ($applicantdata->averagePercentage >= 50 ? 'warning' : 'danger') }}"
                                     style="width: {{ $applicantdata->averagePercentage }}%"></div>
                            </div>
                            <small class="text-muted">{{ $applicantdata->totalScore }}/{{ $applicantdata->maxPossibleScore }} points</small>
                        </div>
                        @endif

                        <div class="d-grid mt-3">
                            <a href="mailto:{{ $applicantdata->ApplicantEmail }}" class="btn btn-outline-primary radius-15">
                                <i class="bx bx-envelope"></i> Contact Applicant
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Content Area -->
            <div class="col-md-9">
                <div class="card-body">
                    @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- Application Status Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="bx bx-edit"></i> Update Application Status</h5>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="saveapplication">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Application Status</label>
                                        <select wire:model="status" class="form-select">
                                            <option value="">Select Status</option>
                                            <option value="Active">Pending</option>
                                            <option value="Approved">Approved</option>
                                            <option value="Rejected">Rejected</option>
                                        </select>
                                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Current Status</label>
                                        <div>
                                            @switch($applicantdata->status)
                                                @case('Approved')
                                                    <span class="badge bg-success fs-6">Approved</span>
                                                    @break
                                                @case('Rejected')
                                                    <span class="badge bg-danger fs-6">Rejected</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-warning text-dark fs-6">Pending</span>
                                            @endswitch
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Remarks</label>
                                        <textarea class="form-control" wire:model="Remarks" rows="3" placeholder="Add remarks about this application..."></textarea>
                                        @error('Remarks') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-save"></i> Save Changes
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-tabs nav-primary mb-0" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#certificates" role="tab">
                                <i class='bx bx-file font-18 me-1'></i> Certificates
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#scores" role="tab">
                                <i class='bx bx-star font-18 me-1'></i> Interview Scores
                                @if($scores->count() > 0)
                                    <span class="badge bg-primary ms-1">{{ $scores->count() }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content border border-top-0 p-3">
                        <!-- Certificates Tab -->
                        <div class="tab-pane fade show active" id="certificates" role="tabpanel">
                            <div class="row g-3">
                                @php
                                    $documents = [
                                        ['field' => 'birthCert', 'label' => 'Birth Certificate', 'icon' => 'bx-file'],
                                        ['field' => 'fourFourCert', 'label' => 'Form Four Certificate', 'icon' => 'bx-certification'],
                                        ['field' => 'sixCertificate', 'label' => 'Form Six Certificate', 'icon' => 'bx-certification'],
                                        ['field' => 'collageCert', 'label' => 'College Certificate', 'icon' => 'bx-certification'],
                                        ['field' => 'internshipCert', 'label' => 'Internship Certificate', 'icon' => 'bx-briefcase'],
                                        ['field' => 'mctCertificate', 'label' => 'MCT/TNMC Certificate', 'icon' => 'bx-plus-medical'],
                                        ['field' => 'license', 'label' => 'Professional License', 'icon' => 'bx-id-card'],
                                        ['field' => 'CariculumVitae', 'label' => 'Curriculum Vitae', 'icon' => 'bx-user'],
                                        ['field' => 'applicationLetter', 'label' => 'Application Letter', 'icon' => 'bx-envelope'],
                                    ];
                                @endphp

                                @foreach($documents as $doc)
                                    <div class="col-md-4">
                                        <div class="card h-100 {{ $applicantdata->{$doc['field']} ? 'border-success' : 'border-secondary' }}">
                                            <div class="card-body text-center">
                                                <i class="bx {{ $doc['icon'] }} fs-1 {{ $applicantdata->{$doc['field']} ? 'text-success' : 'text-muted' }}"></i>
                                                <h6 class="mt-2 mb-2">{{ $doc['label'] }}</h6>
                                                @if($applicantdata->{$doc['field']})
                                                    <a href="{{ Storage::url($applicantdata->{$doc['field']}) }}" target="_blank" class="btn btn-sm btn-primary">
                                                        <i class="bx bx-download"></i> View
                                                    </a>
                                                @else
                                                    <span class="badge bg-secondary">Not Uploaded</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Interview Scores Tab -->
                        <div class="tab-pane fade" id="scores" role="tabpanel">
                            @if (session()->has('score_message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('score_message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <!-- Add/Edit Score Form -->
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="bx bx-plus-circle"></i>
                                        {{ $editingScoreId ? 'Edit Score' : 'Add New Score' }}
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <form wire:submit.prevent="saveScore">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label">Criteria <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" wire:model="criteria"
                                                       placeholder="e.g., Communication Skills">
                                                @error('criteria') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Score <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" wire:model="score"
                                                       placeholder="0" min="0" step="0.01">
                                                @error('score') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Max Score</label>
                                                <input type="number" class="form-control" wire:model="maxScore"
                                                       placeholder="100" min="1">
                                                @error('maxScore') <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Remarks</label>
                                                <input type="text" class="form-control" wire:model="scoreRemarks"
                                                       placeholder="Optional remarks">
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bx bx-save"></i>
                                                    {{ $editingScoreId ? 'Update Score' : 'Add Score' }}
                                                </button>
                                                @if($editingScoreId)
                                                <button type="button" wire:click="cancelEdit" class="btn btn-secondary">
                                                    <i class="bx bx-x"></i> Cancel
                                                </button>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Scores List -->
                            @if($scores->count() > 0)
                            <div class="card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0"><i class="bx bx-list-ul"></i> Interview Scores</h6>
                                    <span class="badge bg-primary">Total: {{ $applicantdata->totalScore }}/{{ $applicantdata->maxPossibleScore }} ({{ $applicantdata->averagePercentage }}%)</span>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Criteria</th>
                                                    <th>Score</th>
                                                    <th>Percentage</th>
                                                    <th>Remarks</th>
                                                    <th>Scored By</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($scores as $index => $scoreItem)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td><strong>{{ $scoreItem->criteria }}</strong></td>
                                                    <td>
                                                        <span class="fw-bold">{{ $scoreItem->score }}</span>
                                                        <span class="text-muted">/{{ $scoreItem->max_score }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1 me-2" style="height: 8px; width: 60px;">
                                                                <div class="progress-bar bg-{{ $scoreItem->percentage >= 70 ? 'success' : ($scoreItem->percentage >= 50 ? 'warning' : 'danger') }}"
                                                                     style="width: {{ $scoreItem->percentage }}%"></div>
                                                            </div>
                                                            <span class="badge bg-{{ $scoreItem->percentage >= 70 ? 'success' : ($scoreItem->percentage >= 50 ? 'warning' : 'danger') }}">
                                                                {{ $scoreItem->percentage }}%
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td>{{ $scoreItem->remarks ?? '-' }}</td>
                                                    <td>{{ $scoreItem->scorer->name ?? 'Unknown' }}</td>
                                                    <td>{{ $scoreItem->created_at->format('d M Y') }}</td>
                                                    <td>
                                                        <button wire:click="editScore({{ $scoreItem->id }})" class="btn btn-sm btn-outline-primary">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                        <button wire:click="deleteScore({{ $scoreItem->id }})"
                                                                onclick="return confirm('Are you sure you want to delete this score?')"
                                                                class="btn btn-sm btn-outline-danger">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot class="table-light">
                                                <tr>
                                                    <td colspan="2"><strong>Total</strong></td>
                                                    <td><strong>{{ $applicantdata->totalScore }}/{{ $applicantdata->maxPossibleScore }}</strong></td>
                                                    <td>
                                                        <span class="badge bg-{{ $applicantdata->averagePercentage >= 70 ? 'success' : ($applicantdata->averagePercentage >= 50 ? 'warning' : 'danger') }} fs-6">
                                                            {{ $applicantdata->averagePercentage }}%
                                                        </span>
                                                    </td>
                                                    <td colspan="4"></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="text-center py-5">
                                <i class="bx bx-star fs-1 text-muted"></i>
                                <p class="mt-2 text-muted">No interview scores recorded yet.</p>
                                <p class="small text-muted">Use the form above to add scores for different criteria.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
