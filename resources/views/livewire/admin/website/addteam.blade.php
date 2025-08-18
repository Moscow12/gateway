<div>
    <div class="card shadow-none">
        <div class="p-4">
            

            @error('photo.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            @if ($photo)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">               
                <div>
                    <img src="{{ $photo->temporaryUrl() }}" class="h-auto border rounded" width="100">
                </div>
            </div>
            @endif
        </div>
        <div class="card-body">
            <div class="card-body p-4">
                 <form action="" method="POST" wire:submit.prevent="saveteam">
                    @csrf
                <div class="row mb-3">
                    <label for="input49" class="col-sm-3 col-form-label">Enter  Name</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-user'></i></span>
                            <input type="text" class="form-control"  id="name" name="name" wire:model="name" 
                                placeholder="Your Name">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="input50" class="col-sm-3 col-form-label">Title Name</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-microphone'></i></span>
                            <input type="text" class="form-control"  id="name"  wire:model="title"  placeholder="Title">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="input51" class="col-sm-3 col-form-label">Upload Photo</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="file" wire:model="photo"  accept="image/*" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9 right">
                        <div class="d-md-flex d-grid align-items-center gap-3">                            
                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="card-footer bg-white"> <small class="text-muted">Last updated 3 mins ago</small>
        </div>
    </div>
</div>