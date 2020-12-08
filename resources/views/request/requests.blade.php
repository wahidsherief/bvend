@extends('admin.admin')

@section('title')
Vendor Section
@endsection

@section('subtitle')
Admin
@endsection

@section('content')
<div class="row">
    <div class="col">
        @include('partials.alert')
        <div class="card card-small mb-4">
            <div class="card-header border-bottom">
                <ul class="nav">
                    @include('partials.vendor-top-nav')
                </ul>
            </div>
            <div class="card-body p-0 pb-3 text-center">
            @if($requests->count() > 0)
                <table class="table mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col" class="border-0">Sl No.</th>
                            <th scope="col" class="border-0">Business Name</th>
                            <th scope="col" class="border-0">Email</th>
                            <th scope="col" class="border-0">Mobile</th>
                            <th scope="col" class="border-0">View</th>
                            <!-- <th scope="col" class="border-0">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                        $i=1;
                        @endphp
                        @foreach($requests as $request)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$request->business_name}}</td>
                                <td>{{$request->email}}</td>
                                <td>{{$request->business_phone}}</td>
                                <td><a href="{{route('vendor.request.show',$request->id) }}"> View </a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted font-italic font-weight-light p-5">No Request Found</p>
            @endif
            </div> 
        </div> 
    </div>
  </div>
        </div>
    </div>
</div>
@endsection