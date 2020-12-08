@extends('admin.admin')

@section('title')
Vendor Section
@endsection

@section('subtitle')
Admin
@endsection

@section('content')
<div class="row">
    <div class="col">
        @include('partials.alert')
        <div class="card card-small mb-4">
            <div class="card-header border-bottom">
                <ul class="nav">
                    @include('partials.vendor-top-nav')
                </ul>
            </div>
            <div class="card-body p-0 pb-3 text-center">
                @if($inactive_vendors->count() > 0)
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
                                <th scope="col" class="border-0">Approval</th>
                                <!-- <th scope="col" class="border-0">Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp
                            @foreach($inactive_vendors as $inactive_vendor)
                            <tr class='table-row'>
                                <td>{{$i++}}</td>
                                <td>{{$inactive_vendor->name}}</td>
                                <td><img src="{{asset('uploads/vendors/'. $vendor->image)}}" width="60" height="60">
                                </td>
                                <td>{{$inactive_vendor->phone}}</td>
                                <td>{{$inactive_vendor->email}}</td>
                                <td>{{$inactive_vendor->business_name}}</td>
                                <td>
                                    <a class="btn btn-sm btn-outline-info"
                                        href="{{route('vendor_account_show',$inactive_vendor->id)}}">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted font-italic font-weight-light p-5">No Inactive Vendor Found</p>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection