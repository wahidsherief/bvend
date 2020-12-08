@extends('admin.admin')

@section('content')
<div class="row">
    <div class="col">
        <div class="card card-small mb-4">
            <div class="card-header border-bottom">
                <ul class="nav">
                    @include('partials.vendor-details-top-nav', ['vendor_id' => $vendor->id])
                </ul>
            </div>
            <div class="card-body p-0 pb-3">
                <div class="col-md-6 mt-4">
                    <form action="{{route('vendor_account_locker_machine_store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Vendor</label>
                            <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
                            <input disabled type="text" value="{{ ucwords($vendor->business_name) }}"
                                class="form-control" name="vendor_id">
                        </div>
                        <div class="form-group">
                            <label for="">Machine Type</label>
                            <input type="hidden" name="type" value='ML'>
                            <select id="inputState" class="form-control" name='type' disabled>
                                <option selected value="ML">Locker</option>
                                <option value="MS">Store</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Machine Model</label>
                            <select id="inputState" class="form-control" name='model'>
                                <option selected value="8">8</option>
                                <option value="32">32</option>
                                {{-- <option value="16">16</option>
                                <option value="32">32</option>
                                <option value="64">64</option>
                                <option value="96">96</option>
                                <option value="128">128</option>
                                <option value="128">256</option> --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Product Category</label>
                            <select name="category_id[]" class="form-control" multiple>
                                @foreach($categories as $category )
                                <option value="{{$category->id}}">
                                    {{ucwords($category->name)}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Address</label>
                            <textarea name="address" id="" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <button onclick="return confirm('Are you sure ?')" type="submit"
                            class="mb-2 btn btn-sm btn-bvend mr-1">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection