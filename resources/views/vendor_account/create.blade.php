@extends('admin.admin')

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
                    <form action="{{route('vendor_account_machine_create')}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="">Vendor Name</label>
                            <input type="text" value="{{old('name')}}" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="email" value="{{old('email')}}" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label for="">Mobile</label>
                            <input type="text" value="{{old('phone')}}" class="form-control" name="phone">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" value="{{old('password')}}" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label for="">Business Name</label>
                            <input type="text" value="{{old('business_name')}}" class="form-control"
                                name="business_name">
                        </div>
                        <div class="form-group">
                            <label for="">Business Phone</label>
                            <input type="text" value="{{old('business_phone')}}" class="form-control"
                                name="business_phone">
                        </div>
                        <div class="form-group">
                            <label for="">Bank Account</label>
                            <label for="" class='text-muted small'>(max 20 digits)</label>
                            <input type="text" value="{{old('bank_account_no')}}" class="form-control"
                                name="bank_account_no">
                        </div>
                        <div class="form-group">
                            <label for="">NID No</label>
                            <label for="" class='text-muted small'>(between 10 - 13 digits)</label>
                            <input type="text" value="{{old('nid')}}" class="form-control" name="nid">
                        </div>
                        <div class="form-group">
                            <label for="">Trade Licence</label>
                            <label for="" class='text-muted small'>(max 20 digits)</label>
                            <input type="text" value="{{old('trade_licence_no')}}" class="form-control"
                                name="trade_licence_no">
                        </div>
                        <div class="form-group">
                            <label>Profile Picture</label>
                            <input type="file" class="form-control" name="image" value="{{old('image')}}"
                                placeholder="">
                        </div>

                        </br>
                        <button type="submit" class="mb-2 btn btn-bvend mr-1">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection