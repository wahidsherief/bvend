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
    <div class="card-body p-4">
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ $empty > 0 ? $empty . ' boxes are empty.' : 'No boxes are empty.' }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="row">

            @php
            $i=0
            @endphp
            @foreach($locks as $lock)
            <div class="col-lg-3 col-6 mb-2">
                <div class="{{ $lock->refilled == 0 ? 'bg-red-light' : 'bg-white'}} stats-small stats-small--1 card card-small"
                    style="min-height: 0">
                    <div class="p-1 d-flex">
                        <div class="d-flex flex-column m-auto">
                            <div class="stats-small__data text-center">
                                <a href="{{route('vendor_machine_show_locks', 
                                            [$lock->machine_id, $lock->lock_id])}}">
                                    <p class='pt-4'>
                                        <span class='{{ $lock->refilled == 0 ? ' text-white' : 'text-dark'
                                            }}'>Box</span>
                                        <h6
                                            class="{{ $lock->refilled == 0 ? 'text-white' : ''}}  stats-small__value count my-3">
                                            {{++$i}}
                                        </h6>
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</div>
@endsection