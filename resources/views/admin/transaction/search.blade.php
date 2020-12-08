@extends('admin.admin')
@section('title')
Machine
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
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" href="{{ url()->previous() }}">Back</a>
                    </li>
                </ul>
            </div>
            <div class="card-body text-center">
                <form action="{{ route('admin_transaction_search') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name='trx_id' placeholder="Transaction ID (Trx ID)" />
                        <div class="input-group-append">
                            <button class="btn btn-bvend" type="submit">
                                Search
                            </button>
                        </div>
                    </div>
                </form>
                @if (session()->has('result'))
                @php
                $result = session()->get('result');
                @endphp
                <div class="mt-4">
                    @if (!is_array($result))
                    <p class="text-muted font-italic font-weight-light p-5">{{ $result }}</p>
                    @else
                    <ul class="list-group list-group-small list-group-flush">
                        <li class="list-group-item d-flex px-3">
                            <span class="font-weight-bold text-fiord-blue">Trx ID</span>
                            <span class="ml-auto text-right font-weight-bold text-reagent-gray">
                                {{$result['trxID']}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex px-3">
                            <span class="font-weight-bold text-fiord-blue">
                                Customer Number
                            </span>
                            <span class="ml-auto text-right font-weight-bold text-reagent-gray">
                                {{$result['customerMsisdn']}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex px-3">
                            <span class="font-weight-bold text-fiord-blue">Amount</span>
                            <span class="ml-auto text-right font-weight-bold text-reagent-gray">
                                {{$result['amount']}} BDT
                            </span>
                        </li>
                        <li class="list-group-item d-flex px-3">
                            <span class="font-weight-bold text-fiord-blue">Status</span>
                            <span class="ml-auto text-right font-weight-bold text-reagent-gray">
                                {{$result['transactionStatus']}}
                            </span>
                        </li>
                        <li class="list-group-item d-flex px-3">
                            <span class="font-weight-bold text-fiord-blue">Time</span>
                            <span class="ml-auto text-right font-weight-bold text-reagent-gray">
                                {{$result['completedTime']}}
                            </span>
                        </li>
                    </ul>
                    @endif
                </div>
                @endif



            </div>
        </div>
    </div>
</div>
@endsection