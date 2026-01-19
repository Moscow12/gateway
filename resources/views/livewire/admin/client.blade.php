<div>
    <div class="row">
        <div class="col-5 col-md-5 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $isEditMode ? 'Edit Clients Information' : 'Add New Clients Information' }}</h3>
                </div>
                <div class="card-body">

                    @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    @endif
                    <form wire:submit.prevent="clientform">
                        @csrf
                        <div class="position-relative">
                            <label class="py-2" for="clientname">Client Name</label>
                            <input type="text" wire:model="clientname" class="form-control radius-30" placeholder="Enter Client Name">
                            @error('clientname') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="position-relative">
                            <label class="py-2" for="clientname">Client Email</label>
                            <input type="text" wire:model="clientemail" class="form-control radius-30" placeholder="Enter Client Email">
                            @error('clientemail') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="position-relative">
                            <label class="py-2" for="clientname">Client Phone</label>
                            <input type="text" wire:model="clientphone" class="form-control radius-30" placeholder="255756453412">
                            @error('clientphone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="position-relative">
                            <label class="py-2" for="clientname">Client Address</label>
                            <input type="text" wire:model="clientaddress" class="form-control radius-30" placeholder="Enter Client Address">
                        </div>
                        <div class="position-relative">
                            <label class="py-2" for="clientname">Client City</label>
                            <input type="text" wire:model="clientcity" class="form-control radius-30" placeholder="Enter Client City">
                        </div>
                        <div class="ms-auto">
                            <button type="submit" class="btn btn-success btn-sm radius-30 py-2 mt-3 px-4">{{ $isEditMode ? 'UPDATE' : 'SAVE' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card">
                <div class="card-header">
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <div class="position-relative">
                            <input type="text" class="form-control ps-5 radius-30" placeholder="Search Clients"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                        </div>
                        <div class="position-relative">
                            <select name="" id="" class="form-control">
                                <option value=""> SMS Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ms-auto"><a href="{{ route('sendsms') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bx-message-rounded"></i>Send SMS</a></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#
                                        <div>
                                            <input type="checkbox"   wire:model="selectAll"  class="form-check-input me-1"    id="selectAll">
                                            <label for="selectAll">Select All</label>
                                        </div>
                                    </th>
                                    <th> Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Code</th>
                                    <th>Details</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $number = 0;
                                @endphp
                                @foreach($clients as $client)
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
                                                <input class="form-check-input me-1" type="checkbox" value="{{ $client->id }}" id="client-{{ $client->id }}" wire:model="selectedClients" wire:click="toggleClientSelection({{ $client->id }})">
                                            </div>

                                        </div>
                                    </td>
                                    <td>{{ $client->clientname }}</td>
                                    <td>{{ $client->clientemail }}</td>
                                    <td>{{ $client->clientphone }}</td>
                                    <td>{{ $client->Clientcode }}</td>
                                    <td><a href="{{ route('clientpage',$client->id) }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">View Details</a> </td>
                                    <td>
                                        <div class="d-flex order-actions">  
                                        <a href="{{ route('clients.editclient',$client->id) }}" class="btn btn-info btn-sm ms-3"><i class='bx bxs-edit'></i></a>
                                        <button wire:click="delete({{ $client->id }})" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm ms-3"><i class='bx bxs-trash'></i></button>
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
    </div>
</div>