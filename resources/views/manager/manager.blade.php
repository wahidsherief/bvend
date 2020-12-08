@extends('layouts.master')

@section('role')
{{ ucfirst($manager->name) }}
@endsection

@section('sidebar')
	@include('manager.sidebar')
@endsection

@section('subtitle')
Manager
@endsection

@section('title')
Dashboard
@endsection
