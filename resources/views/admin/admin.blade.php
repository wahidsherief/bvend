@extends('layouts.master')

@section('sidebar')
@include('admin.sidebar')
@endsection

@section('main')
<div class="row">
    <div class="col-md-8 offset-md-2">
        @include('partials.alert')
        @yield('content')
    </div>
</div>
@endsection