<div>
    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                </div>
                <div class="ms-auto"><a href="javascript:;" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add New Order</a></div>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Location</th>
                            <th>Application Date</th>
                            <th>Certificate</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applicantslist as $applicant)
                        
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                    </div>
                                    <div class="ms-2">
                                        <h6 class="mb-0 font-14"> {{ $applicant->id }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $applicant->ApplicantName }}</td>
                            <td>{{ $applicant->ApplicantEmail }}</td>
                            <td>{{ $applicant->phone }}</td>
                            <td>{{ $applicant->Gender }}</td>
                            <td>{{ $applicant->dob }}</td>
                            <td>{{ $applicant->Location }}</td>
                            <td>{{ $applicant->created_at }}</td>
                            <td><a href="{{ Storage::url('uploads/' .$applicant->fourFourCert ) }}" target="_blank">View Attachment</a></td>
                            <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>