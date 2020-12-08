@extends('admin.admin')

@section('content')
<div class="card card-small mb-4">
    <div class="card-header border-bottom">
        <ul class="nav">
            @include('partials.vendor-top-nav')
            <li class="nav-item ml-auto">
                <a class="btn btn-bvend mt-1" role="menuitem" href="{{ route('vendor_account_create') }}">Create
                    Vendor
                </a>
            </li>
        </ul>
    </div>
    <div class="card-body p-0 pb-3 text-center">
        @if($vendors->count() > 0)
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="bg-light">
                    <tr class='table-row'>
                        <th scope="col" class="border-0">Sl No.</th>
                        <th scope="col" class="border-0">Vendor Name</th>
                        <th scope="col" class="border-0">Image</th>
                        <th scope="col" class="border-0">Mobile</th>
                        <th scope="col" class="border-0">Email</th>
                        <th scope="col" class="border-0">Business Name</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach($vendors as $vendor)
                    <div class="table-responsive">
                        <tr class='table-row'>
                            <td>{{$i++}}</td>
                            <td><a class="btn btn-sm btn-info"
                                    href="{{route('vendor_account_show',$vendor->id)}}">{{$vendor->name}}</a></td>
                            <td><img src="{{asset('uploads/vendors/'. $vendor->image)}}" width="60" height="60"></td>
                            <td>{{$vendor->phone}}</td>
                            <td class="text-lowercase">{{$vendor->email}}</td>
                            <td>{{$vendor->business_name}}</td>
                        </tr>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-muted font-italic font-weight-light p-5">No Active Vendor Found</p>
        @endif
    </div>
</div>
@endsection