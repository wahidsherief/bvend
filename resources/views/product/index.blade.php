@extends('admin.admin')

@section('content')
<div class="row">
    <div class="col">
        <div class="card card-small mb-4">
            <div class="card-header border-bottom">
                <ul class="nav">
                    @include('partials.product-top-nav')
                    <li class="nav-item ml-auto">
                        <a class="btn btn-bvend mt-1" href="{{ route('product_create') }}">Create Product</a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0 pb-3 text-center">
                @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="bg-light">
                            <tr class='table-row'>
                                <th scope="col" class="border-0">Sl No.</th>
                                <th scope="col" class="border-0">Product Name</th>
                                <th scope="col" class="border-0">Category</th>
                                <th scope="col" class="border-0">Brand</th>
                                <th scope="col" class="border-0">Image</th>
                                <th scope="col" class="border-0">Color</th>
                                <th scope="col" class="border-0">Weight</th>
                                <th scope="col" class="border-0">Flavour</th>
                                <th scope="col" class="border-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = $products->perPage() * ($products->currentPage() - 1) @endphp
                            @foreach($products as $product)
                            <tr class='table-row'>
                                <td>{{ ++$i }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{$product->category->name}}</td>
                                <td>{{ isset($product->brand->name) ? $product->brand->name : 'N/A' }}</td>
                                <td><img src="{{asset('uploads/products/'.$product->image)}}" alt="" width="60"
                                        height="60">
                                </td>
                                <td>{{ isset($product->color) ? $product->color : 'N/A' }}</td>
                                <td>{{ isset($product->weight) ? $product->weight : 'N/A' }}</td>
                                <td>{{ isset($product->flavor) ? $product->flavor : 'N/A' }}</a></td>
                                <td>
                                    <a href="{{route('product_edit',$product->id)}}"
                                        class="btn btn-sm btn-info mb-1 mb-lg-0">Edit</a>
                                    <form class='d-inline ml-1' action="{{route('product_destroy', $product->id)}}"
                                        method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('GET') }}
                                        <button onclick="return confirm('Are you sure ?')"
                                            class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class='mt-5'>
                    {{ $products->links() }}
                </div>
                @else
                <p class="text-muted font-italic font-weight-light p-5">No Product Found</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection