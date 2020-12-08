<li class="nav-item">
    <a class="nav-link font-weight-bold" href="{{route('vendor_account_active')}}">Active</a>
</li>
<li class="nav-item">
    <a class="nav-link font-weight-bold" href="{{route('vendor_account_inactive')}}">Inactive</a>
</li>
{{-- <li class="nav-item">
    <a class="nav-link font-weight-bold" href="{{route('vendor_account_request')}}">Requests</a>
</li> --}}
@if (\Request::is('vendor/request/show', '*') == false)
<li class="nav-item ml-auto">
    <a class="btn btn-bvend" href="{{route('vendor.create')}}">Create Vendor</a>
</li>
@endif