@extends('admin.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @yield('tasks')
    </div>
    <div id='admin-dashboard'></div>
</div>
@endsection