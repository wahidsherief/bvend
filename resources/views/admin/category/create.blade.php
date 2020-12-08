@extends('admin.admin')
@section('title')
Category
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
                    @include('partials.alert')
                    <form action="{{route('category.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                        	<label for="">Category Name</label>
                        	<input type="text" class="form-control" name="category_name">
                        </div>
                        <button type="submit" class="mb-2 btn btn-sm btn-success mr-1">Create Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection