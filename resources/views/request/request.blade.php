@extends('admin.admin')
@section('title')
Vendors
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
                @include('partials.vendor-top-nav')
                <li class="nav-item ml-auto">
                    <a class="nav-link" href="{{route('vendor.request.approve', $request->id)}}">       Approve Request
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="return confirm('Are you sure ?')" href="{{ route('vendor.request.destroy', $request->id ) }}">
                        Remove Request
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="col-md-12">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><span>Name : </span>{{$request->name}}</li>
                    <li class="list-group-item"><span>Email : </span>{{$request->email}}</li>
                    <li class="list-group-item"><span>Company : </span>{{$request->business_name}}</li>
                    <li class="list-group-item"><span>Phone : </span>{{$request->business_phone}}</li>
                    <li class="list-group-item"><span>Address : </span>{{$request->address}}</li>
                    <li class="list-group-item"><span>Message : </span>{{$request->message}}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection