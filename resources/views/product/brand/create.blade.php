@extends('admin.admin')
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
                    <form action="{{route('product_brand_store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Brand Name</label>
                            <input type="text" class="form-control" value="{{old('name')}}" name="name">
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control" name="image" value="{{old('image')}}"
                                placeholder="">
                        </div>
                        <button type="submit" class="mb-2 btn btn-sm btn-bvend mr-1">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection