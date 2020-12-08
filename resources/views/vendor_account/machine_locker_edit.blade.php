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
                    <form action="{{route('vendor_account_locker_machine_update')}}" method="POST">
                        @csrf
                        <input type="hidden" name='machine_id' value="{{ $machine->id }}" />
                        <div class="form-group">
                            <label for="">Vendor</label>
                            <input type="hidden" value="{{ ucfirst($vendor->id) }}" class="form-control"
                                name="vendor_id">
                            <input disabled type="text" value="{{ ucfirst($vendor->business_name) }}"
                                class="form-control">
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
                            <input type="hidden" name='model' value="{{ $machine->machine_model }}"
                                class="form-control">
                            <input disabled type="text" name='model' value="{{ $machine->machine_model }}"
                                class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Product Category</label>
                            <select disabled name="category_id[]" class="form-control" multiple>
                                @foreach($categories as $category )
                                <option value="{{$category->id}}">
                                    {{ucfirst($category->name)}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Address</label>
                            <textarea name="address" id="" cols="30" rows="5"
                                class="form-control">{{ $machine->address }}</textarea>
                        </div>
                        <button onclick="return confirm('Are you sure ?')" type="submit"
                            class="mb-2 btn btn-sm btn-bvend mr-1">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection