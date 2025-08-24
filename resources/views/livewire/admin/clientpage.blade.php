<div>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Client Details</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Client File</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary">Settings</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                    <a class="dropdown-item" href="javascript:;">Another action</a>
                    <a class="dropdown-item" href="javascript:;">Something else here</a>
                    <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                </div>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="row">
        <div class="col-12 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <form wire:submit.prevent="createinvoice">
                        <div class="d-grid"> <button href="javascript:;" class="btn btn-primary">+ Create invoice</button>
                    </div>
                    </form>
                    
                    <h5 class="my-3">Client File</h5>
                    <div class="fm-menu">
                        <div class="list-group list-group-flush"> <a href="javascript:;" class="list-group-item py-1"><i class='bx bx-folder me-2'></i><span>All Files</span></a>
                            <a href="javascript:;" class="list-group-item py-1"><i class='bx bx-analyse me-2'></i><span>Recents</span></a>
                            <a href="javascript:;" class="list-group-item py-1"><i class='bx bx-plug me-2'></i><span>Reported Issues</span></a>
                            <a href="javascript:;" class="list-group-item py-1"><i class='bx bx-trash-alt me-2'></i><span>Deleted Invoices</span></a>
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-0 text-primary font-weight-bold">5,500,000 <span class="float-end text-secondary">2,500,000</span></h5>
                    <p class="mb-0 mt-2"><span class="text-secondary">Paid</span><span class="float-end text-primary">Pending</span>
                    </p>
                    <div class="progress mt-3" style="height:7px;">
                        <div class="progress-bar" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="mt-3"></div>
                    <div class="d-flex align-items-center">
                        <div class="fm-file-box bg-light-success text-success"><i class='bx bx-image'></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">Paid</h6>
                            <p class="mb-0 text-success">1,7 Invoices</p>
                        </div>
                        <h6 class="text-primary mb-0">5,500,000</h6>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="fm-file-box bg-light-primary text-primary"><i class='bx bxs-file-doc'></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">Pending Invoices</h6>
                            <p class="mb-0 text-secondary">7 Invoices</p>
                        </div>
                        <h6 class="text-primary mb-0">2,500,000</h6>
                    </div>
                    <div class="d-flex align-items-center mt-3">
                        <div class="fm-file-box bg-light-danger text-danger"><i class='bx bx-video'></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h6 class="mb-0">Exipired Invoices</h6>
                            <p class="mb-0 text-secondary">4 invoices</p>
                        </div>
                        <h6 class="text-primary mb-0">1,000,000</h6>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-9">
            <div class="card shadow-none border radius-15">
                <div class="card-body">
                   
                    <div class="d-flex align-items-center">
                        <div>
                            <h5 class="mb-0">Recent invoices</h5>
                        </div>
                        <div class="ms-auto"><a href="javascript:;" class="btn btn-sm btn-outline-secondary">View all</a>
                        </div>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-hover table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Created Date<i class='bx bx-up-arrow-alt ms-2'></th>
                                    <th>Due Date</th>
                                    <th>Control Number</th>
                                    <th>Items Quantity</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $number = 0;
                                @endphp
                                @foreach($invoices ?? [] as $invoice)
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
                                    <td>{{ $invoice->created_at }}</td>
                                    <td>{{ $invoice->created_at->adddays(30) }}</td>
                                    <td>{{ $invoice->control_number }}</td>
                                    <td>{{ $invoice->invoiceitems->count() }} Items</td>
                                    <td> {{ number_format($invoice->invoiceitems->sum('amount')) }}</td>
                                    <td>{{ $invoice->Status }}</td>
                                    <td>
                                        <div class="d-flex order-actions">
                                            <a href="{{ route('clientinvoice',['clientId' => $invoice->client_id, 'invoiceId' => $invoice->id]) }}" class="btn btn-info btn-sm ms-3"><i class='bx bxs-edit'></i></a>
                                            <button wire:click="delete({{ $invoice->id }})" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm ms-3"><i class='bx bxs-trash'></i></button>
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
    <!--end row-->
</div>
