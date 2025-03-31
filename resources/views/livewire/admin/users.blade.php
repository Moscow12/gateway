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
                            <th>Order#</th>
                            <th>Company Name</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>View Details</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Users as $User)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                    </div>
                                    <div class="ms-2">
                                        <h6 class="mb-0 font-14"> {{ $User->id }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $User->name }}</td>
                            <td>
                                <div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class='bx bxs-circle align-middle me-1'></i>Partially shipped</div>
                            </td>
                            <td>{{ $User->email }}</td>
                            <td>{{ $User->created_at }}</td>
                            <td><button type="button" class="btn btn-primary btn-sm radius-30 px-4">View Details</button></td>
                            <td>
                                <div class="d-flex order-actions">
                                    <a href="javascript:;" class=""><i class='bx bxs-edit'></i></a>
                                    <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>