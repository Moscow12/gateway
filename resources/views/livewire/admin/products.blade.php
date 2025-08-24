<div>
    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                </div>
                
                <div class="ms-auto">
                    <button type="sub" class="btn btn-success btn-sm radius-30 px-4" data-bs-toggle="modal" data-bs-target="#jabad" >Add Product</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th> PRODUCT NAME</th>
                            <th>PRICE</th>
                            <th>DESCRIPTION</th>
                            <th>Added By</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                            @php
                            $number = 0;
                            @endphp
                            @foreach($products ?? [] as $product)
                            @php
                            $number++;  
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-2">
                                            <h6 class="mb-0 px-2 font-14"> {{ $number }}</h6>
                                        </div>
                                        <div>
                                            <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                        </div>

                                    </div>
                                </td>
                                <td>{{ $product->productname }}</td>                          
                                <td>{{ $product->initialprice }}</td>
                                <td>{{ $product->productdescription }}</td>
                                <td>{{ $product->user->name ?? 'No user' }}</td>
                                <td>{{ $product->created_at }}</td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="#" class=""  data-bs-toggle="modal" data-bs-target="#jabad"><i class='bx bxs-edit'></i></a>
                                        <button wire:click="delete({{ $product->id }})" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm ms-3"><i class='bx bxs-trash'></i></button>
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
                    <h5 class="modal-title">ADD PRODUCT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                <div class="border border-3 p-4 rounded">
                    <form wire:submit.prevent="addproduct">
                        @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="inputProductTags" class="form-label">Product Product</label>
                                    <input type="text" class="form-control" wire:model="productname" id="inputProductTags" placeholder="Enter Product name">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputPrice" class="form-label">Initial Price</label>
                                    <input type="text" class="form-control" id="inputPrice" wire:model="initialprice" placeholder="00.00">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputCompareatprice" class="form-label">Top  Price</label>
                                    <input type="text" class="form-control" wire:model="topprice" id="inputCompareatprice" placeholder="00.00">
                                </div>
                                <div class="col-12">
                                    <label for="inputProductType" class="form-label">Payment Type</label>
                                    <select class="form-select" id="inputProductType" wire:model="paymenttype">
                                        <option></option>
                                        <option value="Recurring">Recurring</option>
                                        <option value="One_Time_Payment">One Time Payment</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                               <div class="col-12 mb-3">
								<label for="inputProductDescription" class="form-label">Description</label>
								<textarea class="form-control" id="inputProductDescription" wire:model="productdescription" rows="3"></textarea>
							  </div>
                                
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Save Product</button>
                                    </div>
                                </div>
                            </div> 
                        </form>
                    </div>
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