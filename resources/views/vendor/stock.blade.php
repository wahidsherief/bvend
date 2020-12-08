@extends('layouts.master')

@section('role')
Vendor
@endsection

@section('sidebar')
    @include('vendor.sidebar')
@endsection

@section('title')
<h2>Sales Report</h2>

@endsection
@section('content')
<div class="row">
    <div class="col">
        <div class="card card-small mb-4">
            <div class="card-header border-bottom clearfix">
                <div class="float-left">
                    <select>
                        <option value="">Today</option>
                        <option value="">Last week</option>
                        <option value="">15 Days</option>
                        <option value="">30 Days</option>
                    </select>
                    <label>Select Machine:</label>
                     <select>
                        <option value="">Machine one</option>
                        <option value="">Machine Two</option>
                    </select>
                </div>
                <div class="float-right">
                        <div id="blog-overview-date-range" class="input-daterange input-group input-group-sm my-auto ml-auto mr-auto ml-sm-auto mr-sm-0" style="max-width: 350px;"><lable>From</lable>&nbsp;
                          <input type="text" class="input-sm form-control" name="start" placeholder="Start Date" id="blog-overview-date-range-1">
                          &nbsp;<label>To</label> &nbsp;
                          <input type="text" class="input-sm form-control" name="end" placeholder="End Date" id="blog-overview-date-range-2">
                          <span class="input-group-append">
                            <span class="input-group-text">
                              <i class="material-icons"></i>
                            </span>
                          </span>
                        </div>
                   
                    </div>
                </div>
         
            <div class="card-body p-0 pb-3 text-center">
               <table class="table mb-0">
                <thead class="bg-light">
                    <tr>
                        <th scope="col" class="border-0">Sl No.</th>
                        <th scope="col" class="border-0">Machine Name</th>
                        <th scope="col" class="border-0">Product Name</th>
                        <th scope="col" class="border-0">bkash Transaction</th>
                        <th scope="col" class="border-0">Product Buy Price</th>
                        <th scope="col" class="border-0">Product Sale Price</th>
                        <th scope="col" class="border-0">Profit</th>
                        <th scope="col" class="border-0">Action</th>
                    </tr>
                </thead>
                <tbody>
                @php 
                $i=1;
                $profit=0;
                @endphp
                @foreach($unitPrice as $unitPrice)
                   <tr>
                       <td>{{$i++}}</td>
                       <td> {{$unitPrice->machine_id}}</td>
                       <td> {{$unitPrice->name}}</td>
                       <td> {{$unitPrice->bkash_trx_id}}</td>
                       <td> {{$unitPrice->buy_unit_price}} BDT</td>
                       <td> {{$unitPrice->sale_unit_price}} BDT</td>
                       <td>{{$unitPrice->Profit}} BDT</td>
                       <td><a href="" class="btn btn-success">View</td>
                   </tr>
                   @endforeach
                </tbody>
            </table>
            </div>
        </div>
        </div>
</div>
@endsection
