@extends('layouts.app')

@section('content')
<div id='payment-screen'> {{$total_amount}}</div>

<form action="{{route('bkash')}}" method="POST" enctype="multipart/form-data">
    <button class="btn btn-md btn-success">Pay with bKash</button>
</form>
@endsection