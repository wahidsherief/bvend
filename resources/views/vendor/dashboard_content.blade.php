<div>
	<div class="row">
            <div class="col-lg col-md-6 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                    <div class="card-body p-0 d-flex">
                        <div class="d-flex flex-column m-auto">
                            <div class="stats-small__data text-center">
                                <span class="stats-small__label text-uppercase">Vendor Machines</span>
                                <h6 class="stats-small__value count my-3">{{$ml_machines->count()}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg col-md-6 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                    <div class="card-body p-0 d-flex">
                        <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                            <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                            </div>
                        </div>
                        <div class="d-flex flex-column m-auto">
                            <div class="stats-small__data text-center">
                                <span class="stats-small__label text-uppercase">Total Sales Amount</span>
                                <h6 class="stats-small__value count my-3">{{$total_sales_amount}} BDT</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg col-md-4 col-sm-6 mb-4">
                <div class="stats-small stats-small--1 card card-small">
                    <div class="card-body p-0 d-flex">
                        <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                            <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                            </div>
                        </div>
                        <div class="d-flex flex-column m-auto">
                            <div class="stats-small__data text-center">
                                <span class="stats-small__label text-uppercase">Total Product Sale</span>
                                <h6 class="stats-small__value count my-3">{{ $total_sales_product }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12 mb-4">
            @if($ml_machines->count() > 0)
            <div>
                <h6><strong style="color: red">Top Product Sale</strong></h6>
                <div class="mb-3 row">
                    <div class="col-xs-12 col-md-12 p-3">
                        <div class="card card-small">
                            <div class="card-header border-bottom">
                                <h6 class="m-0">Locker Machine</h6>
                            </div>
                            <div class="card-body p-0">
                                <table class="table mb-0 text-center" style="font-size: 12px">
                                  <thead class="bg-light">
                                    <tr>
                                      <th scope="col" class="border-0 text-left">Product</th>
                                      <th scope="col" class="border-0">Sold</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach($ml_machines as $ml_machine)
                                        @foreach($ml_machine->products as $product)
                                            <tr>
                                                <td class="text-left"><a href="">{{ $product['item']->product_name }}</a></td>
                                                <td>{{ $product['count'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                  </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 mb-4">
            @if($ml_machines->count() > 0)
            <div>
                <h6><strong>Locker Machines</strong></h6>
                <div class="mb-3 row">
                    @if($ml_8_machines->count() > 0)
                        <div class="col-xs-12 col-md-6 p-3">
                            <div class="card card-small">
                                <div class="card-header border-bottom">
                                    <h6 class="m-0">Model : 8</h6>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table mb-0 text-center" style="font-size: 12px">
                                      <thead class="bg-light">
                                        <tr>
                                          <th scope="col" class="border-0 text-left">Machine</th>
                                          <th scope="col" class="border-0">Product Sale</th>
                                          <th scope="col" class="border-0">Amount</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($ml_8_machines as $ml_8_machine)
                                        <tr>
                                          <td class="text-left">{{ $ml_8_machine->machine_code }}</td>
                                          <td>{{ $ml_8_machine->total_sales_product }}</td>
                                          <td>{{ $ml_8_machine->total_sales_amount }} BDT</td>
                                        </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($ml_16_machines->count() > 0)
                        <div class="col-xs-12 col-md-6 p-3">
                            <div class="card card-small">
                                <div class="card-header border-bottom">
                                    <h6 class="m-0">Model : 16</h6>
                                </div>
                                <div class="card-body p-0 text-center">
                                    <table class="table mb-0" style="font-size: 12px">
                                        <thead class="bg-light">
                                            <tr>
                                        <th scope="col" class="border-0 text-left">Machine</th>
                                        <th scope="col" class="border-0">Product Sale</th>
                                        <th scope="col" class="border-0">Amount</th>
                                            </tr>
                                        </thead>
                                      <tbody>
                                        @foreach($ml_16_machines as $ml_16_machine)
                                        <tr>
                                          <td class="text-left">{{ $ml_16_machine->machine_code }}</td>
                                          <td>{{ $ml_16_machine->total_sales_product }}</td>
                                          <td>{{ $ml_16_machine->total_sales_amount }} BDT</td>
                                        </tr>
                                        @endforeach
                                      </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>