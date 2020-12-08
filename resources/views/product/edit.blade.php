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
                    <form action="{{route('product_update',$product->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{method_field('PUT')}}
                        <div class="form-group">
                            <label for="">Product Name</label>
                            <input type="text" value="{{$product->name}}" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label>Select Category</label>
                            <select id="inputState" class="form-control" name='product_category_id'>
                                @foreach($categories as $category)
                                <option value="{{old('product_category_id',$category->id)}}">
                                    {{ucwords($category->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Brand</label>
                            <select id="inputState" class="form-control" name='product_brand_id'>
                                @foreach($brands as $brand)
                                <option value="{{old('product_brand_id', $brand->id)}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Product Color</label>
                            <input type="text" value="{{$product->color}}" class="form-control" name="color">
                        </div>
                        <div class="form-group">
                            <label for="">Product Weight</label>
                            <input type="text" value="{{$product->weight}}" class="form-control" name="weight">
                        </div>
                        <div class="form-group">
                            <label for="">Product Flavour</label>
                            <input type="text" value="{{$product->flavor}}" class="form-control" name="flavor">
                        </div>
                        <div class="form-group">
                            <label for="">Product Unit</label>
                            <input type="text" value="{{$product->unit}}" class="form-control" name="unit">
                        </div>
                        <div class="form-group">
                            <label for="">Product Description</label>
                            <textarea rows="5" name="description"
                                class="form-control">{{$product->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control" name="image">
                            <br>
                            <img src="{{asset('uploads/products/'.$product->image)}}" alt="image" width="50"
                                height="50">
                        </div>
                        <button type="submit" class="mb-2 btn btn-bvend mr-1">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection