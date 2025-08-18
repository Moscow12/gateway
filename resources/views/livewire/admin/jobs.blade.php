
<div>
    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5 radius-30" wire:model.live="search" placeholder="Search applicants..."  > <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                </div>
                <div class="ms-auto"><a href="javascript:;" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>  Add Applicant</a></div>
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
                            <th>Application Date</th>
                            <th>view Attachments</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applicantslists as $list)                        
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                    </div>
                                    <div class="ms-2">
                                        <h6 class="mb-0 font-14"> {{ $list->id }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $list->ApplicantName }}</td>
                            <td>{{ $list->ApplicantEmail }}</td>
                            <td>{{ $list->phone }}</td>
                            <td>{{ $list->Gender }}</td>
                            <td>{{ $list->dob }}</td>
                            <td>{{ $list->created_at }}</td>
                           <td>
                            @if ($list->birthCert != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($list->birthCert ) }}" target="_blank"> View Certificate <br></a> <br>                               
                            @endif 
                            @if ($list->fourFourCert != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($list->fourFourCert ) }}" target="_blank"> Form Four Certificate <br></a> <br>                               
                            @endif 
                            @if ($list->sixCertificate != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($list->sixCertificate ) }}" target="_blank"> Form Six Certificate</a> <br>                               
                            @endif
                            @if ($list->CariculumVitae != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($list->CariculumVitae ) }}" target="_blank"> Cariculum Vitae</a><br>
                            @endif  
                            @if ($list->collageCert != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($list->collageCert ) }}" target="_blank"> Collage Certificate</a><br>
                            @endif
                            @if ($list->applicationLetter != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($list->applicationLetter ) }}" target="_blank"> Application Letter</a> <br>                               
                            @endif
                            @if ($list->mctCertificate != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($list->mctCertificate ) }}" target="_blank"> MCT Certificate</a> <br>                               
                            @endif
                            @if ($list->license != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($list->license ) }}" target="_blank"> License</a> <br>                               
                            @endif
                           </td>
                            <td><button type="button" class="btn btn-success btn-sm radius-30 px-4" data-bs-toggle="modal" data-bs-target="#jabad" wire:click.prevent="viewattachments({{ $list->id }})">View Details</button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $applicantslists->links() }}
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="jabad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">JOB APPLICATION ATTACHMENTS FOR <b> {{ $applicant->ApplicantName }}</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <table class="table mb-0">
                    <tr>
                        <th>Attachments</th>
                        <th>View</th>
                    </tr>
                    <tr>
                        <td>Birth Certificate</td>
                        <td>
                            @if ($applicant->birthCert != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($applicant->birthCert ) }}" target="_blank"> View Certificate <br></a>                                
                            @endif                            
                        </td>
                    </tr>
                    <tr>
                        <td>Form Four Certificate</td>
                        <td>
                            @if ($applicant->fourFourCert != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($applicant->fourFourCert ) }}" target="_blank"> FourFour Certificate<br></a>
                            @endif                            
                        </td>
                    </tr>                   
                    <tr>
                        <td>Six Certificate</td>
                        <td>
                            @if ($applicant->sixCertificate != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($applicant->sixCertificate ) }}" target="_blank"> SixCertificate<br></a>
                                
                            @endif
                        </td>
                    </tr>                   
                    <tr>
                        <td>
                            Cv
                        </td>
                        <td>
                            @if ($applicant->CariculumVitae != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($applicant->CariculumVitae ) }}" target="_blank"> Cariculum Vitae<br></a>
                            @endif                            
                        </td>
                    </tr>
                    <tr>
                        <td> Collage Certificate</td>
                        <td>
                            @if ($applicant->collageCert != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($applicant->collageCert ) }}" target="_blank"> Collage Certificate<br></a>
                            @endif
                            
                        </td>
                    </tr>
                    <tr>
                        <td>Application Letter</td>
                        <td>
                            @if ($applicant->applicationLetter != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($applicant->applicationLetter ) }}" target="_blank"> Application Letter<br></a>                                
                            @endif
                        </td>
                    </tr> 
                    <tr>
                        <td>Internship Certificate</td>
                        <td>
                            @if ($applicant->internshipCert != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($applicant->internshipCert ) }}" target="_blank"> Internship Certificate<br></a>                                
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>MCT Certificate</td>
                        <td>
                            @if ($applicant->mctCertificate != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($applicant->mctCertificate ) }}" target="_blank"> MCT Certificate<br></a>                                
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>License</td>
                        <td>
                            @if ($applicant->license != null)
                                <a class="btn btn-primary btn-sm radius-30 px-4" href="{{ Storage::url($applicant->license ) }}" target="_blank"> License<br></a>                                
                            @endif
                        </td>
                           
                    </tr>                  
                </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
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