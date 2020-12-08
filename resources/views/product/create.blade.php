@extends('admin.admin')
@section('title')
Machine
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
                    <form action="{{route('product_store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Product Name</label>
                            <input type="text" value="{{old('product_name')}}" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label>Select Category</label>
                            <select id="inputState" class="form-control" name='product_category_id'>
                                @foreach($categories as $category)
                                <option value="{{old('product_category_id',$category->id)}}">
                                    {{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Select Brand</label>
                            <select id="inputState" class="form-control" name='product_brand_id'>
                                @foreach($brands as $brand)
                                <option value="{{old('product_brand_id',$brand->id)}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Product Color</label>
                            <input type="text" value="{{old('color')}}" class="form-control" name="color">
                        </div>
                        <div class="form-group">
                            <label for="">Product Weight</label>
                            <input type="text" value="{{old('weight')}}" class="form-control" name="weight">
                        </div>
                        <div class="form-group">
                            <label for="">Product Flavour</label>
                            <input type="text" value="{{old('flavor')}}" class="form-control" name="flavor">
                        </div>
                        <div class="form-group">
                            <label for="">Product Unit</label>
                            <input type="text" value="{{old('unit')}}" class="form-control" name="unit">
                        </div>
                        <div class="form-group">
                            <label for="">Product Description</label>
                            <textarea value="{{old('description')}}" rows="5" name="description"
                                class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="file" class="form-control" name="image" value="{{old('image')}}"
                                placeholder="">
                        </div>
                        <!-- <div class="form-check-inline">
                          <label class="form-check-label">
                            <input type="checkbox" name="active" class="form-check-input" checked="checked" value="1">Uncheck for Draft
                          </label>
                      </div> -->
                        </br>
                        <button type="submit" class="mb-2 btn btn-bvend mr-1">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection