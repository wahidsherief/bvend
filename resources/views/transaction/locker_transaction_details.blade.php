@extends('vendor.vendor')

@section('content')
<div class="card card-small mb-4">
    <div class="card-header border-bottom">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link font-weight-bold" href="{{ url()->previous() }}">Back</a>
            </li>
        </ul>
    </div>

    <div class="card-body p-4">
        <div class="row">
            <div class="col-md-6">
                <div class='mb-3'><strong class='font-weight-bold'>Transaction Details</strong></div>
                <ul class="list-group list-group-small list-group-flush">
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Invoice No</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{ $transaction->invoice_no }}</span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Payment Method</span>
                        <span class="ml-auto text-right text-semibold text-reagent-gray">
                            {{-- {{ $transaction->payment_method_id }}</span> --}}
                        bKash</span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Payment ID</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{ $transaction->payment_id }}</span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">bKash Trx ID</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{ $transaction->bkash_trx_id }}</span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Machine Code</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{ $transaction->machine->machine_code }}</span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Machine Address</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{ $transaction->machine->address }}</span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Transaction Time</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{ $transaction->created_at }}</span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Total Amount</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{ $transaction->total_amount }}
                            BDT</span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Payer Mobile</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{ $transaction->user->mobile }}</span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Transaction Status</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{ $transaction->status }}</span>
                    </li>
                </ul>
            </div>
            <div class="col-md-6 product-list mt-5 mt-md-0">
                <div class='mb-3 d-block d-sm-none'><strong class='font-weight-bold'>Product Details</strong></div>
                @foreach($transaction->lockers as $locker)
                <ul class="list-group list-group-small list-group-flush cap-text">
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="ml-auto"><img height="30" width="30"
                                src="{{ asset('uploads/products/'.  $locker->refill->product->image)}}" alt="">
                        </span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Name</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{  $locker->refill->product->name }}</span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Category</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{  ucfirst($locker->refill->product->category->name) }}</span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Brand</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{  isset($locker->refill->product->brand->name) ? ucfirst($locker->refill->product->brand->name) : 'N/A'}}</span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Quantity</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{  $locker->refill->quantity }}</span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Buy Unit Price</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{ $locker->refill->buy_unit_price }}</span>
                    </li>
                    <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                        <span class="text-semibold text-fiord-blue">Sale Unit Price</span>
                        <span
                            class="ml-auto text-right text-semibold text-reagent-gray">{{ $locker->refill->sale_unit_price }}</span>
                    </li>
                </ul>
                <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection