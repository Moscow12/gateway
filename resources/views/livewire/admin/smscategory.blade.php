<div>
    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                </div>
                
                <div class="ms-auto">
                    <button type="sub" class="btn btn-success btn-sm radius-30 px-4" data-bs-toggle="modal" data-bs-target="#jabad" >Add Category</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th> Name</th>
                            <th>Added By</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $number = 0;
                        @endphp
                        @foreach($smscategoires as $category)
                        @php
                            $number++;  
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                    </div>
                                    <div class="ms-2">
                                        <h6 class="mb-0 font-14"> {{ $number }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $category->name }}</td>                          
                           <td>{{ $category->user->name ?? 'No user' }}</td>
                            
                            <td>{{ $category->created_at }}</td>
                            <td>
                                <div class="d-flex order-actions">
                                    <button type="button" class="btn btn-success btn-sm radius-30 px-4" data-bs-toggle="modal" data-bs-target="#jabad" wire:click.prevent="viewattachments({{ $category->id }})">View Details</button>
                                    <a href="#" class=""><i class='bx bxs-edit'></i></a>
                                    <button wire:click="delete({{ $category->id }})" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm ms-3"><i class='bx bxs-trash'></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
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
                    <h5 class="modal-title">JOB APPLICATION ATTACHMENTS FOR </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <form wire:submit.prevent="addcategory">
                        @csrf
                        <div class="position-relative">
                            <input type="text" wire:model="categoryname" class="form-control ps-5 radius-30" placeholder="Enter Category Name"> 
                        </div>
                        <div class="ms-auto">
                            <button type="submit" class="btn btn-success btn-sm radius-30 px-4">SAVE</button>                            
                        </div>
                    </form>
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