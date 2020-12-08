@extends('admin.admin')
@section('title')
Brands
@endsection
@section('subtitle')
Admin
@endsection
@section('content')
<div class="row">
    <div class="col">
        <div class="card card-small mb-4">
            <div class="card-header border-bottom">
                <ul class="nav">
                    @include('partials.product-top-nav')
                </ul>
            </div>
            <div class="card-body p-0 pb-3">
                <div class="col-md-6 mt-4">
                    <form action="{{route('product_brand_update',$brand->id)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{method_field('PUT')}}
                        <div class="form-group">
                            <label for="">Brand Name</label>
                            <input type="text" class="form-control" name="name" value="{{$brand->brand_name}}">

                        </div>
                        <div class="form-group">
                            <label for="">Brand Logo</label>
                            <input type="file" name="image" class="form-control">
                            <br>
                            <img src="{{ asset('uploads/product_brands/'.$brand->image) }}" width="100px" height="100px"
                                class="img-fluid" alt="{{$brand->name}}">
                        </div>
                        <button type="submit" class="mb-2 btn btn-sm btn-bvend mr-1">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection