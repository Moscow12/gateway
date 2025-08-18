
<div>
    <div class="page-title">
        <h3>FP Employee Registered</h3>
        <p class="text-subtitle text-muted">List of employees registered in the fingerprint system</p>
    </div>
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Home</div>
        <div class="breadcrumb-item"><a href="javascript:;">Dashboard</a></div>
        <div class="breadcrumb-item active">FP Employee Registered</div>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h3 class="card-title mb-0">FP Employee Registered</h3>
            </div>
        </div>
        <div class="card-body">
           @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <form wire:submit.prevent="uploadExcel">
                <input type="file" wire:model="excelFile">

                @error('excelFile') <span class="text-danger">{{ $message }}</span> @enderror

                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
    <!-- Card -->
    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5 radius-30" wire:model.live="search" placeholder="Search employee..."  > <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                </div>
                <div class="ms-auto"><a href="javascript:;" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>  Add Employee</a></div>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Account Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="jabad" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Employee Registered In Finger Print </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
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