<li class="nav-item">
    <a class="nav-link font-weight-bold" href="{{route('vendor_account_show', $vendor_id)}}">Vendor</a>
</li>
<li class="nav-item">
    <a class="nav-link font-weight-bold" href="{{route('vendor_account_locker_machine', $vendor_id)}}">Machine</a>
</li>
<li class="nav-item">
    <a class="nav-link font-weight-bold" href="{{route('vendor_account_transactions', $vendor_id)}}">Transaction</a>
</li>

@if (\Request::is('admin/vendor/machine/*'))
<li class="nav-item ml-auto">
    <a class="btn btn-bvend" href="{{route('vendor_account_locker_machine_create', $vendor_id)}}">Create Machine</a>
</li>
@endif