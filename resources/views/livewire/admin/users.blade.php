<div>
    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                </div>
                <div class="ms-auto"><a href="{{ route('addusers') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add Users</a></div>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order#</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Photo</th>
                            <th>Date</th>
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
                            <td>{{ $User->email }}</td>
                            <td>{{ $User->phone }}</td>
                            <td>
                                @if ($User->photos && is_array($User->photos))
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        @foreach ($User->photos as $photo)
                                            <div>
                                                <img src="{{ asset('storage/' . $photo) }}" alt="User Photo" class="w-full h-auto rounded border">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p>No photos available.</p>
                                @endif
                            </td>
                            <td>{{ $User->created_at }}</td>
                            <td>
                                <div class="d-flex order-actions">
                                    <a href="#" class=""><i class='bx bxs-edit'></i></a>
                                    <a href="#" class="ms-3"><i class='bx bxs-trash'></i></a>
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