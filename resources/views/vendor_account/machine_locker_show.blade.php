@extends('admin.admin')

@section('content')
<div class="card card-small mb-4">
  <div class="card-header border-bottom">
    <ul class="nav">
      @include('partials.vendor-details-top-nav', ['vendor_id' => $vendor->id])
    </ul>
  </div>
  <div class="card-body p-0">
    <ul class="list-group list-group-small list-group-flush cap-text">
      <li class="list-group-item d-flex px-3">
        <span class="ml-auto text-right text-semibold text-reagent-gray">
          <img width=100 height=100
            src="{{ asset('uploads/machine_qr_codes/ML/'.$machine->machine_model.'/'.$machine->qr_code.'.png')}}"
            alt=""></span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Machine ID</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$machine->machine_code}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Machine Type</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$machine->machine_type}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Machine Model</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$machine->machine_model}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Locker Start</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$machine->locker_start}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Locker End</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$machine->locker_end}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Vendor</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$vendor->business_name}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Address</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$machine->address}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Temperature</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$machine->temperature}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Humidity</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$machine->humidity}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Fan</span>
        <span class="ml-auto text-right text-semibold text-reagent-gray">{{$machine->fan_status}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Maintainance</span>
        <span
          class="ml-auto text-right text-semibold text-reagent-gray">{{$machine->maintainance == 0 ? 'Yes' : 'Live'}}</span>
      </li>
      <li class="list-group-item d-flex px-3">
        <span class="text-semibold text-fiord-blue">Status</span>
        <span
          class="ml-auto text-right text-semibold text-reagent-gray">{{$machine->active == 0 ? 'Not active' : 'active'}}</span>
      </li>
    </ul>
  </div>

  <div class="card-footer border-top">
    <div class="col-6 col-sm-3 ml-auto">
      <ul class="nav row">
        <li class="nav-item ml-auto">
          <a class="btn btn-sm btn-info"
            href="{{route('vendor_account_locker_machine_edit', [$vendor->id, $machine->machine_model, $machine->id])}}">Edit
          </a>
        </li>
        <li class="nav-item ml-auto">
          @if ($machine->active == 1)
          <a class="btn btn-sm btn-danger" role="menuitem"
            href="{{ route('vendor_account_machine_toggle', [$vendor->id, $machine->machine_model, $machine->id]) }}"
            onclick="return confirm('Are you sure ?')">Dectivate</a>
          @else
          <a class="btn btn-sm btn-bvend" role="menuitem"
            href="{{ route('vendor_account_machine_toggle', [$vendor->id, $machine->machine_model, $machine->id]) }}"
            onclick="return confirm('Are you sure ?')">Activate</a>
          @endif
        </li>
      </ul>
    </div>
  </div>
</div>
@endsection