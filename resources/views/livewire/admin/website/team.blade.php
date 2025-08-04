<div>
    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                </div>
                <div class="ms-auto"><a href="{{ route('addteam') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Add Team</a></div>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th> Name</th>
                            <th>Title</th>
                            <th>Photo</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teams as $team)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div>
                                        <input class="form-check-input me-3" type="checkbox" value="" aria-label="...">
                                    </div>
                                    <div class="ms-2">
                                        <h6 class="mb-0 font-14"> {{ $team->id }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $team->name }}</td>                          
                            <td>{{ $team->title }}</td>
                            <td>
                                @if ($team->photo)
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">                                        
                                        <div>
                                            <img src="{{ asset('storage/' . $team->photo) }}" alt="Photo" class="h-auto rounded border" style="width: 100px;">
                                        </div>
                                    </div>
                                @else
                                    <p>No photos available.</p>
                                @endif
                            </td>
                            <td>{{ $team->created_at }}</td>
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
