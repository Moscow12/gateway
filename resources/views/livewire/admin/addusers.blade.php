<div>
    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <h5 class="mb-4">ADD USERS</h5>
                </div>
                <div class="ms-auto"><a href="{{ route('users') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>USER LISTS</a></div>
            </div>
            <div class="table-responsive">
                <form action="" method="POST" wire:submit.prevent="addUser">
                    @csrf
                    <div class="card">
                        <div class="card-body p-4">
                            @if(session()->has('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <div class="row mb-3">
                                <label for="input35" class="col-sm-3 col-form-label">Enter Your Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name" name="name" wire:model="name" placeholder="Enter Your Name">
                                        @error('name') <span style="color:red;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="input36" class="col-sm-3 col-form-label">Phone No</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="phone" name="phone" wire:model="phone" placeholder="Phone No">
                                        @error('phone') <span style="color:red;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="input37" class="col-sm-3 col-form-label">Email Address</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" wire:model="email" placeholder="Email Address">
                                        @error('email') <span style="color:red;">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="input38" class="col-sm-3 col-form-label">Enter Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" wire:model="password" placeholder="Choose Password">
                                        @error('password') <span style="color:red;">{{ $message }}</span> @enderror
                                </div>
                            </div> 
                            <div class="row mb-3">
                                <label for="input38" class="col-sm-3 col-form-label">Confirm Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" wire:model="password_confirmation"  placeholder="Choose Password">
                                        @error('password') <span style="color:red;">{{ $message }}</span> @enderror
                                </div>
                            </div>     
                            <div class="p-4">
                            <input type="file" wire:model="photos" multiple accept="image/*" class="mb-2">

                            @error('photos.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                            @if ($photos)
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach ($photos as $photo)
                                        <div>
                                            <img src="{{ $photo->temporaryUrl() }}" class="w-full h-auto border rounded">
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            
                        </div>
                     
                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="button" class="btn btn-light px-4">Reset</button>
                                        <x-primary-button> Add user</x-primary-button>                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>