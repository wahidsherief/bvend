@extends('admin.admin')
@section('title')
Vendor
@endsection
@section('subtitle')
Admin
@endsection
@section('content')
<div class="row">
    <div class="col">
        <div class="card card-small mb-4">
            <div class="card-header border-bottom">
                <ul class="nav">
                    @include('partials.vendor-top-nav')
                </ul>
            </div>
            <div class="card-body p-0 pb-3">
                <div class="col-md-6 mt-4">
					@include('partials.alert')
                    <form action="{{route('vendor.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Vendor Name</label>
                            <input type="text" value="{{$vendor->name}}" class="form-control" name="name">
                        </div> 
                         <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" readonly="readonly" value="{{$vendor->email}}" class="form-control" name="email">
                        </div>   
                          <div class="form-group">
                            <label for="">Mobile</label>
                            <input type="text" value="{{$vendor->phone}}" class="form-control" name="phone">
                        </div>  
                         <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" value="{{$vendor->password}}" class="form-control" name="password">
                        </div>  
                         <div class="form-group">
                            <label for="">Business Name</label>
                            <input type="text" value="{{$vendor->business_name}}" class="form-control" name="business_name">
                        </div>  
                        <div class="form-group">
                            <label for="">Business Phone</label>
                            <input type="text" value="{{$vendor->business_phone}}" class="form-control" name="business_phone">
                        </div>   
                         <div class="form-group">
                            <label for="">Bank Account</label>
                            <input type="text" value="{{$vendor->bank_account_no}}" class="form-control" name="bank_account_no">
                        </div>  
                             <div class="form-group">
                            <label for="">NID No</label>
                            <input type="text" value="{{$vendor->nid}}" class="form-control" name="nid">
                        </div>   
                            <div class="form-group">
                            <label for="">Trade Licence</label>
                            <input type="text" value="{{$vendor->trade_licence_no}}" class="form-control" name="trade_licence_no">
                        </div>       
                        <div class="form-group">
                            <label>Profile Picture</label>
                        <input type="file" class="form-control" name="image">
                        <img src="{{asset($vendor->image)}}" width="60" height="60" class="img-thumbnail" alt="{{$vendor->name}}">
                        </div>
                       
                      </br>
                        <button type="submit" class="mb-2 btn btn-success mr-1">Approve Vendor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
