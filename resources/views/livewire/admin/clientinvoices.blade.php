<div>
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Applications</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Invoice</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary">Settings</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item" href="javascript:;">Action</a>
                    <a class="dropdown-item" href="javascript:;">Another action</a>
                    <a class="dropdown-item" href="javascript:;">Something else here</a>
                    <div class="dropdown-divider"></div> <a class="dropdown-item" href="javascript:;">Separated link</a>
                </div>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <div class="card">
        <div class="card-body">
            <div id="invoice">
                <div class="toolbar hidden-print">
                    <div class="text-end">
                        <button type="button" class="btn btn-dark"><i class="fa fa-print"></i> Print</button>
                        <button type="button" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
                    </div>
                    <hr />
                </div>
                <div class="invoice overflow-auto">
                    <div style="min-width: 600px">
                        <header>
                            <div class="row">
                                <div class="col">
                                    <a href="javascript:;">
                                        <img src="assets/images/logo-icon.png" width="80" alt="" />
                                    </a>
                                </div>
                                <div class="col company-details">
                                    <h2 class="name">
                                        <a target="_blank" href="javascript:;">
                                           {{ $invoice->user->name ?? 'No user' }}
                                        </a>
                                    </h2>
                                    <div>455 Foggy Heights, AZ 85004, US</div>
                                    <div>(123) 456-789</div>
                                    <div>company@example.com</div>
                                </div>
                            </div>
                        </header>
                        <main>
                            <div class="row contacts">
                                <div class="col invoice-to">
                                    <div class="text-gray-light">INVOICE TO:</div>
                                    <h2 class="to">{{ $client?->clientname }}</h2>
                                    <div class="address"> {{ $client?->clientaddress }}</div>
                                    <div class="email"><a href="mailto:{{ $client?->clientemail }}">{{ $client?->clientemail }}</a>
                                    
                                    </div>
                                </div>
                                <div class="col invoice-details">
                                    <h1 class="invoice-id">INVOICE NO.# {{ $invoice?->user->id }}-{{ $clientId }}-{{ $invoiceId }}</h1>
                                    <div class="date">Date of Invoice: {{ $invoice?->created_at }}</div>
                                    <div class="date">Due Date: 30 days  {{ $invoice?->ControlNumberExpiretime }}</div>
                                    <div class="date">Total Amount: {{ number_format($invoice?->TotalAmount) }}</div>
                                    <div class="date"> Control Number:
                                        @if ($invoice?->Status == 'Pending')
                                            <span class="badge bg-warning text-dark"> {{ $invoice?->Status }} </span>
                                        @else
                                             <span class="badge bg-success text-light">  {{ $invoice?->control_number }} </span>
                                        @endif

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card shadow-none border radius-15">
                                    <div class="card-body">
                                        <form  wire:submit.prevent="addItem">
                                            @csrf
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label for="inputCompareatprice" class="form-label">Product Name</label>
                                                    <select name="" id="" wire:model="product_id" class="form-control">
                                                        <option value=""> Select Product</option>
                                                        @foreach($products ?? [] as $product)
                                                        <option value="{{ $product->id }}">{{ $product->productname }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="inputCompareatprice" class="form-label">Quantity</label>
                                                    <input type="text" class="form-control" wire:model="quantity" id="inputCompareatprice" placeholder="00">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="inputPrice" class="form-label">Price</label>
                                                    <input type="text" class="form-control" wire:model="amount" id="inputPrice" value="" placeholder="00.00">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="inputProductDescription" class="form-label">Description</label>
                                                    <input type="text" class="form-control" wire:model="description" id="inputProductDescription" placeholder="Enter Description">
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-primary  radius-30 px-4">Add Item</button>
                                                </div>
                                                
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-left">DESCRIPTION</th>
                                        <th class="text-right">Qty</th>
                                        <th class="text-right"> PRICE</th>                                        
                                        <th class="text-right">TOTAL</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $number = 0;
                                        $totalamount = 0;
                                    @endphp
                                    @foreach($invoice_items ?? [] as $item)
                                    @php
                                        $number++;
                                    @endphp
                                    <tr>
                                        <td class="no">{{ $number }}</td>
                                        <td class="text-left">
                                            <h3>{{ $item->product->productname ?? 'N/A' }}</h3>{{ $item->description ?? 'N/A' }}
                                        </td>
                                        <td class="qty"> {{ $item->quantity ?? 'N/A' }}</td>
                                        <td class="unit">{{ number_format($item->amount) ?? 0 }} <br/> Price Range ({{ number_format($item->product->topprice) }} - {{ number_format($item->product->initialprice) }})</td>
                                        
                                        <td class="total">{{ number_format($item->quantity * $item->amount) }}</td>
                                        <td class="content-center">
                                            <div class="d-flex order-actions">
                                                <a href="#" class="btn btn-info btn-sm ms-3"><i class='bx bxs-edit'></i></a>
                                                <button wire:click="delete({{ $item->id }})" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm ms-3"><i class='bx bxs-trash'></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                    @php
                                        $totalamount += $item->quantity * $item->amount;
                                    @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">SUBTOTAL</td>
                                        <td> {{ number_format($totalamount) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">TAX 18%</td>
                                        <td> {{ number_format($totalamount * 0.18) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">GRAND TOTAL</td>
                                        <td> {{ number_format($totalamount * 1.18) }}</td>
                                        <td>
                                            
                                            @if ($invoice?->Status == 'Pending' && $number != 0)
                                                <form action="" method="POST" wire:submit.prevent="generateinvoice">
                                                    @csrf
                                                    <button type="submit"  class="btn btn-danger btn-sm ms-3">GENERERATE INVOICE</button>
                                                </form>
                                            @else
                                            <span class="float-end text-success">Control Number: {{ $invoice?->control_number }}</span>
                                                
                                            @endif

                                            
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="thanks">Thank you!</div>
                            <div class="notices">
                                <div>NOTICE:</div>
                                <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                            </div>
                        </main>
                        <footer>Invoice was created on a computer and is valid without the signature and seal.</footer>
                    </div>
                    <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                    <div></div>
                </div>
            </div>
        </div>
    </div>
</div>