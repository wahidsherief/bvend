@extends('admin.admin')

@section('content')
<div class="card card-small">
    <div class="card-header border-bottom">
        <ul class="nav">
            @include('partials.vendor-details-top-nav', ['vendor_id' => $vendor_id])
        </ul>
    </div>
    <div class="card-body p-0 text-center">
        @if(count($machines) > 0)
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="bg-light">
                    <tr class='table-row'>
                        <th scope="col" class="border-0">Sl No.</th>
                        <th scope="col" class="border-0">Machine Code</th>
                        <th scope="col" class="border-0">Location</th>
                        <th scope="col" class="border-0">Type</th>
                        <th scope="col" class="border-0">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach ($machines as $machine)
                    <tr class='table-row'>
                        <td>{{$i++}}</td>
                        <td><a class="btn btn-sm btn-info"
                                href="{{route('vendor_account_machine_show', [$vendor_id, $machine->id])}}">{{$machine->machine_code}}</a>
                        </td>
                        <td>{{$machine->address}}</td>
                        <td>{{$machine->machine_type == 'store' ? 'Store' : 'Box' }}</td>
                        <td>{{$machine->active == 0 ? 'Not active' : 'active'}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-muted font-italic font-weight-light p-5">No machine found</p>
        @endif
    </div>
</div>
@endsection