@extends('vendor.vendor')

@section('content')
<div class="card card-small">
    <div class="card-header border-bottom">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link font-weight-bold" href="{{ url()->previous() }}">Back</a>
            </li>
        </ul>
    </div>
    <div class="card-body p-0 pb-3 text-center">
        @if(count($machines_with_models) > 0)
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="bg-light">
                    <tr class='table-row'>
                        <th scope="col" class="border-0">Sl No.</th>
                        <th scope="col" class="border-0">Machine Code</th>
                        <th scope="col" class="border-0 d-none d-sm-table-cell">Type</th>
                        <th scope="col" class="border-0 d-none d-sm-table-cell">Model</th>
                        <th scope="col" class="border-0 d-none d-sm-table-cell">Status</th>
                        <th scope="col" class="border-0">Refill</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach($machines_with_models as $machines)
                    @foreach ($machines as $machine)
                    <tr class='table-row'>
                        <td>{{$i++}}</td>
                        <td>
                            <a class="btn btn-sm btn-info"
                                href="{{route('vendor_locker_machine_show', [$machine->machine_model, $machine->id])}}">
                                {{$machine->machine_code}}
                            </a>
                        </td>
                        <td class='d-none d-sm-table-cell'>{{$machine->machine_type}}</td>
                        <td class='d-none d-sm-table-cell'>{{$machine->machine_model}}</td>
                        <td class='d-none d-sm-table-cell'>{{$machine->active == 0 ? 'Not active' : 'Active'}}</td>
                        <td>
                            <a href="{{route('vendor_locker_machine_locker', [$machine->machine_model, $machine->id])}}"
                                class="{{ $machine->active == 0 ? 'disabled' : '' }} btn btn-sm btn-bvend btn-block">Refill</a>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-muted font-italic font-weight-light p-5">No Machine Found</p>
        @endif
    </div>
</div>
@endsection