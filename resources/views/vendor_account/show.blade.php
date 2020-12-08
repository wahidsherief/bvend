@extends('admin.admin')

@section('content')
<div class="card card-small">
  <div class="card-header border-bottom">
    <ul class="nav">
      @include('partials.vendor-details-top-nav', ['vendor_id' => $vendor->id])
    </ul>
  </div>
  <div class="card-body p-0">
    <ul class="list-group list-group-small list-group-flush cap-text">
      <li class="list-group-item d-flex px-3">
        <span class="ml-auto text-right text-semibold text-reagent-gray">
          <img width=100 height=100 src="{{ asset('uploads/vendors/'.$vendor->image)}}" alt=""></span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Name</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$vendor->name}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Email</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray text-lowercase">{{$vendor->email}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Mobile</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$vendor->phone}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Company</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$vendor->business_name}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Contact</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$vendor->business_phone}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Trade Licence</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$vendor->trade_licence_no}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Bank Acc. No</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$vendor->bank_account_no}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">NID No</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$vendor->nid}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Status</span>
        <span
          class="ml-auto text-right text-semibold text-reagent-gray">{{$vendor->is_approved == 0 ? 'Not Active' : 'Active'}}</span>
      </li>
    </ul>
  </div>
  <div class="card-footer border-top">
    <div class="col-6 col-sm-3 ml-auto">
      <ul class="nav row">
        <li class="nav-item ml-auto">
          <a class="btn btn-sm btn-info" href="{{route('vendor_account_edit', $vendor->id)}}">Edit</a>
        </li>
        <li class="nav-item ml-auto">
          @if ($vendor->is_approved == 1)
          <a class="btn btn-sm btn-danger" role="menuitem" href="{{ route('vendor_account_toggle', $vendor->id) }}"
            onclick="return confirm('Are you sure ?')">Dectivate</a>
          @else
          <a class="btn btn-sm btn-bvend" role="menuitem" href="{{ route('vendor_account_toggle', $vendor->id) }}"
            onclick="return confirm('Are you sure ?')">Activate</a>
          @endif
        </li>
      </ul>
    </div>
  </div>
</div>
@endsection