@extends('admin.admin')
@section('content')
<div class="row">
    <div class="col">
        @include('partials.alert')
        <div class="card card-small mb-4">
            <div class="card-header border-bottom">
                <ul class="nav">
                    @include('partials.product-top-nav')
                    <li class="nav-item ml-auto">
                        <a class="btn btn-outline-success mt-1" href="{{ route('category.create') }}">Create
                            Category</a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0 pb-3 text-center">
                @if($categories->count() > 0)
                <table class="table mb-0">
                    <thead class="bg-light">
                        <tr class='table-row'>
                            <th scope="col" class="border-0">Sl No.</th>
                            <th scope="col" class="border-0">Category Name</th>
                            <th scope="col" class="border-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i=1 @endphp
                        @foreach($categories as $category)
                        <tr class='table-row'>
                            <td>{{$i++}}</td>
                            <td>{{ $category->category_name }}</td>
                            <td>
                                <a href="{{route('category.edit',$category->id)}}"
                                    class="btn btn-sm btn-outline-info">Edit</a>
                                <form class='d-inline ml-1' action="{{ route('category.destroy', $category->id ) }}"
                                    method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('GET') }}
                                    <button onclick="return confirm('Are you sure ?')"
                                        class="btn btn-sm btn-outline-danger">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class='mt-5'>
                    {{ $categories->links() }}
                </div>
                @else
                <p class="text-muted font-italic font-weight-light p-5">No Category Found</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection