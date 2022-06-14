@extends('vendor.vendor')
<!-- @section('extra-js')
<script>
    function showRefillFormWithModal() {
        document.getElementById('open-lock').classList.add("d-none");  
        document.getElementById('refill-show-btn').classList.add("d-none");  
        document.getElementById('refill-form').classList.remove("d-none");  
        document.getElementById('open-lock').click();
    }
    function showRefillForm() {
        document.getElementById('open-lock').classList.add("d-none");  
        document.getElementById('refill-show-btn').classList.add("d-none");  
        document.getElementById('refill-form').classList.remove("d-none");  
    }  
</script>
@endsection -->
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Modal -->
        <div class="modal fade" id="bd-example-modal-sm" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header p-2 border-0">
                        <h5 class="modal-title font-weight-bold" id="exampleModalCenterTitle">
                            Box Opening ...</h5> {{-- <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> --}}
                    </div>
                    <div class="modal-body p-2 mt-4 text-center">
                        <p>Check the box open in the machine.</p>
                    </div>
                    <div class="modal-footer p-2 border-0">
                        <strong>If box opened </strong>
                        <button onclick="showRefillFormWithModal()" type="button" class="btn btn-dark">Refill
                            Box</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-small mb-4">
            <div class="card-header border-bottom">
                <div class="row pl-4 pr-4">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="{{route('vendor_machine_locks', $lock->lock->machine_id)}}"
                                class="nav-link active font-weight-bold">Back</a>
                        </li>
                    </ul>
                    <ul class="nav ml-auto">
                        <li class="nav-item">
                            <a href="{{route('vendor_machine_show_lock', [$lock->lock->machine_id, $lock->lock->lock_id-1])}}"
                                class="nav-link active font-weight-bold">
                                < Previous Box </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('vendor_machine_show_lock', [$lock->lock->machine_id, $lock->lock->lock_id+1])}}"
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
                                    <span>Box : </span>{{ 'Need to update' }}
                                </h5>
                                {{-- Using react component to open box --}}

                                <!-- Button trigger modal -->
                                <div data-backdrop='static' data-keyboard='false' class='mt-4'
                                    data-machine_id="{{$lock->lock->machine_id}}"
                                    data-lock_id="{{$lock->lock->lock_id}}" id='open-lock' data-toggle="modal"
                                    data-target="#bd-example-modal-sm">
                                </div>

                                <button id='refill-show-btn' onclick="showRefillForm()"
                                    class='btn btn-block btn-dark mt-2'>Refill
                                    Box</button>
                                <div id='refill-form' class='d-none'>
                                    <form action="{{route('vendor_machine_refill')}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Select Product</label>
                                            <select name="product_id" class="form-control">
                                                <option value="">Choose Product</option>
                                                @foreach($products as $product)
                                                <option value="{{$product->id}}">{{ucwords($product->product_name)}}
                                                </option>
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
                                            <input type="number" name="buy_unit_price" class="form-control"
                                                placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label>Sale Price</label>
                                            <input type="number" name="sale_unit_price" class="form-control"
                                                placeholder="">
                                        </div>

                                        <input type="hidden" name="machine_id" value="{{$lock->lock->machine_id}}"
                                            class="form-control">
                                        <input type="hidden" name="machine_type" value="ML" />
                                        <input type="hidden" name="lock_id" value="{{$lock->lock->lock_id}}"
                                            class="form-control">
                                        <div class='row'>
                                            <div class="col-md-12 mt-2 mt-sm-0">
                                                <button type="submit" class="btn btn-bvend btn-block">Refill</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6  mt-4">
                                @if(isset($lock->product))
                                <div class="product-list mt-5 mt-md-0">
                                    <div class='mb-3 d-block d-sm-none'><strong class='font-weight-bold'>Product
                                            Details</strong></div>

                                    <ul class="list-group list-group-small list-group-flush cap-text">
                                        <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                                            <span class="ml-auto"><img height="30" width="30"
                                                    src="{{ asset('uploads/products/'.  $lock->product->image)}}"
                                                    alt="">
                                            </span>
                                        </li>
                                        <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                                            <span class="text-semibold text-fiord-blue">Name</span>
                                            <span class="ml-auto text-right text-semibold text-reagent-gray">{{
                                                $lock->product->name }}</span>
                                        </li>
                                        <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                                            <span class="text-semibold text-fiord-blue">Description</span>
                                            <span class="ml-auto text-right text-semibold text-reagent-gray">{{
                                                $lock->product->description }}</span>
                                        </li>
                                        <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                                            <span class="text-semibold text-fiord-blue">Category</span>
                                            <span class="ml-auto text-right text-semibold text-reagent-gray">{{
                                                ucfirst($lock->product->category->name) }}</span>
                                        </li>
                                        <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                                            <span class="text-semibold text-fiord-blue">Brand</span>
                                            <span class="ml-auto text-right text-semibold text-reagent-gray">{{
                                                isset($lock->product->brand) ? ucfirst($lock->product->brand->name)
                                                : 'N/A'}}</span>
                                        </li>
                                        <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                                            <span class="text-semibold text-fiord-blue">Quantity</span>
                                            <span class="ml-auto text-right text-semibold text-reagent-gray">{{
                                                $lock->refill->quantity }}</span>
                                        </li>
                                        <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                                            <span class="text-semibold text-fiord-blue">Buy Unit Price</span>
                                            <span class="ml-auto text-right text-semibold text-reagent-gray">{{
                                                $lock->refill->buy_unit_price }}</span>
                                        </li>
                                        <li class="list-group-item list-shrinked list-borderless d-flex px-3">
                                            <span class="text-semibold text-fiord-blue">Sale Unit Price</span>
                                            <span class="ml-auto text-right text-semibold text-reagent-gray">{{
                                                $lock->refill->sale_unit_price }}</span>
                                        </li>
                                    </ul>
                                </div>
                                @else
                                <p class="text-muted font-italic font-weight-light p-5">The lock has not been
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