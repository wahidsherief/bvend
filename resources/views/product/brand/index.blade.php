@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col">
        <div class="card card-small mb-4">
            <div class="card-header border-bottom">
                <ul class="nav">
                    @include('partials.product-top-nav')
                    <li class="nav-item ml-auto">
                        <a class="btn btn-bvend mt-1" href="{{ route('product_brand_create') }}">Create
                            Brand</a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0 pb-3 text-center">
                @if($brands->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="bg-light">
                            <tr class='table-row'>
                                <th scope="col" class="border-0">Sl No.</th>
                                <th scope="col" class="border-0">Brand Name</th>
                                <th scope="col" class="border-0">Logo</th>
                                <th scope="col" class="border-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp
                            @foreach($brands as $brand)
                            <tr class='table-row'>
                                <td>{{ $i++ }}</td>
                                <td>{{ $brand->name }}</td>
                                <td>
                                    <img src="{{ asset('uploads/product_brands/'.$brand->image) }}" width="40"
                                        height="50" alt="Image">
                                </td>
                                <td>
                                    <a href="{{route('product_brand_edit', $brand->id)}}"
                                        class="btn btn-sm btn-info mb-1 mb-md-0">Edit</a>
                                    <form class='d-inline ml-1'
                                        action="{{ route('product_brand_destroy', $brand->id ) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('GET') }}
                                        <button onclick="return confirm('Are you sure ?')"
                                            class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class='mt-5'>
                    {{ $brands->links() }}
                </div>
                @else
                <p class="text-muted font-italic font-weight-light p-5">No Brand Found</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection