<div>
    <div class="row">
        <div class="col-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Clients Information</h3>
                </div>
                <div class="card-body">
                    
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        
                    @endif
                    <form action="{{ route('clients') }}" method="post">
                        @csrf
                        <div class="position-relative">
                            <label class="py-2" for="clientname">Client Name</label>
                            <input type="text" wire:model="clientname" class="form-control radius-30" placeholder="Enter Client Name"> 
                        </div>
                        <div class="position-relative">
                            <label class="py-2" for="clientname">Client Email</label>
                            <input type="text" wire:model="clientemail" class="form-control radius-30" placeholder="Enter Client Email"> 
                        </div>
                        <div class="position-relative">
                            <label class="py-2" for="clientname">Client Phone</label>
                            <input type="text" wire:model="clientphone" class="form-control radius-30" placeholder="255756453412"> 
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
                            <button type="submit" class="btn btn-success btn-sm radius-30 py-2 mt-3 px-4">SAVE</button>                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card">
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</div>
