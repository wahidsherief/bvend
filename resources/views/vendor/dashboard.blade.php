@extends('vendor.vendor')
@section('title')
<h2>Dashboard</h2>
@endsection
@section('subtitle')
<h6>Vendor</h6>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @yield('tasks')
    </div>
    <div id='vendor-dashboard'>
    </div>
</div>
@endsection