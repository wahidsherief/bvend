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
                    <form action="{{route('vendor_account_machine_save')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Vendor</label>
                            <input type="hidden" name="vendor_id" value="{{ $vendor->id }}">
                            <input disabled type="text" value="{{ ucwords($vendor->business_name) }}"
                                class="form-control" name="vendor_id">
                        </div>
                        <div class="form-group">
                            <label for="">Machine Type</label>
                            <select id="inputState" class="form-control" name='type'>
                                <option selected value="box">Box</option>
                                <option value="store">Store</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">No of Channels</label>
                            <input type="number" name="no_of_channels" value=6 class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">No of Locks Per Channel</label>
                            <input type="number" name="locks_per_channel" value=10 class="form-control">
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