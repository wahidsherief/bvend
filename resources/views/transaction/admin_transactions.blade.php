@extends('admin.admin')

@section('content')
<div class="row">
    <div class="col">
        <div class="card card-small mb-4">
            <div class="card-header border-bottom">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" href="{{ url()->previous() }}">Back</a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-0 pb-3 text-center">
                @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" class="border-0">Sl No.</th>
                                <th scope="col" class="border-0">Machine Code</th>
                                <th scope="col" class="border-0">Bkash Trx No</th>
                                <th scope="col" class="border-0">Total Amount</th>
                                <th scope="col" class="border-0">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1 @endphp
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>
                                    <a class="btn btn-sm btn-info"
                                        href="{{route('vendor_account_machine_show', [$transaction->vendor_id, $transaction->machine_id])}}">{{$transaction->machine_code}}</a>
                                </td>
                                <td>{{ $transaction->bkash_trx_id }}</td>
                                <td>{{ $transaction->total_amount }} BDT</td>
                                <td>
                                    <a class="btn btn-secondary btn-sm"
                                        href="{{
                                        route('vendor_account_transactions', [$transaction->vendor_id, $transaction->id])}}">
                                        Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class='mt-5'>
                    {{ $transactions->links() }}
                </div>
                @else
                <p class="text-muted font-italic font-weight-light p-5">No Trasnsaction Found</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection