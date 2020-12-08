@extends('vendor.vendor')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-small mb-4">
            <div class="card-header border-bottom">
                <div class="row pl-4 pr-4">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="{{route('vendor_locker_machine_locker', [$model, $locker->locker->machine_id])}}"
                                class="nav-link active font-weight-bold">Back</a>
                        </li>
                    </ul>
                    <ul class="nav ml-auto">
                        <li class="nav-item">
                            <a href="{{route('vendor_locker_machine_locker_show', [$model, $locker->locker->machine_id, $locker->locker->id-1])}}"
                                class="nav-link active font-weight-bold">
                                < Previous Box </a> </li> <li class="nav-item">
                                    <a href="{{route('vendor_locker_machine_locker_show', [$model, $locker->locker->machine_id, $locker->locker->id+1])}}"
                                        class="nav-link active font-weight-bold">Next Box >
                                    </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body pb-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row align-items-center">
                            <div class="col-md-6 mt-2">
                                <h5 class="font-weight-bold">
                                    <span>Box : </span>{{$box_number}}
                                </h5>
                                <form action="{{route('vendor_locker_machine_refill')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Select Product</label>
                                        <select name="product_id" class="form-control">
                                            <option value="">Choose Product</option>
                                            @foreach($products as $product)
                                            <option value="{{$product->id}}">{{ucwords($product->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="number" name="quantity" class="form-control" value="1"
                                            placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label>Buy Price</label>
                                        <input type="number" name="buy_unit_price" class="form-control" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label>Sale Price</label>
                                        <input type="number" name="sale_unit_price" class="form-control" placeholder="">
                                    </div>
                                    <input type="hidden" name="machine_model" value="{{$model}}" class="form-control">
                                    <input type="hidden" name="machine_id" value="{{$locker->locker->machine_id}}"
                                        class="form-control">
                                    <input type="hidden" name="machine_type" value="ML" />
                                    <input type="hidden" name="locker_id" value="{{$locker->locker->id}}"
                                        class="form-control">
                                    <div class='row'>
                                        {{-- Using react component to open box  --}}
                                        <div id='open-locker' class="col-md-6"
                                            data-machine_id="{{$locker->locker->machine_id}}"
                                            data-locker_id="{{$locker->locker->id}}" data-model="{{$model}}">
                                        </div>
                                        <div class="col-md-6 mt-2 mt-sm-0">
                                            <button type="submit" class="btn btn-bvend btn-block">Refill</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6  mt-4">
                                @if(isset($locker->product))
                                <div class="product-list mt-5 mt-md-0">
                                    <div class='mb-3 d-block d-sm-none'><strong class='font-weight-bold'>Product
                                            Details</strong></div>

                                    <ul class="list-group list-group-small list-group-flush cap-text">
                                        <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                                            <span class="ml-auto"><img height="30" width="30"
                                                    src="{{ asset('uploads/products/'.  $locker->product->image)}}"
                                                    alt="">
                                            </span>
                                        </li>
                                        <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                                            <span class="text-semibold text-fiord-blue">Name</span>
                                            <span
                                                class="ml-auto text-right text-semibold text-reagent-gray">{{  $locker->product->name }}</span>
                                        </li>
                                        <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                                            <span class="text-semibold text-fiord-blue">Description</span>
                                            <span
                                                class="ml-auto text-right text-semibold text-reagent-gray">{{  $locker->product->description }}</span>
                                        </li>
                                        <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                                            <span class="text-semibold text-fiord-blue">Category</span>
                                            <span
                                                class="ml-auto text-right text-semibold text-reagent-gray">{{  ucfirst($locker->product->category->name) }}</span>
                                        </li>
                                        <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                                            <span class="text-semibold text-fiord-blue">Brand</span>
                                            <span
                                                class="ml-auto text-right text-semibold text-reagent-gray">{{  isset($locker->product->brand) ? ucfirst($locker->product->brand->name) : 'N/A'}}</span>
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
                                </div>
                                @else
                                <p class="text-muted font-italic font-weight-light p-5">The locker has not been
                                    refilled
                                    yet.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection