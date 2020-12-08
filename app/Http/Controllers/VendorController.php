<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Vendor;
use App\Machine;

class VendorController extends Controller
{
    protected $transaction_service;

    public function __construct()
    {
        $this->middleware('auth:vendor');
    }

    public function dashboard()
    {
        $vendor = Vendor::where('id', Auth::id())->first();
        return view('vendor.dashboard', compact('vendor'));
    }

    public function getDashboardInfo($date)
    {
        $vendor = new Vendor;
        $machine = new Machine;
        $vendor_id = Auth::id();

        $date = \Carbon\Carbon::today()->subDays($date)->toDateString();

        $ml_8_machines = $vendor->salesReport('ML', '8', $date);

        // $ml_16_machines = $vendor->salesReport('ML', '16', $date);
        $ml_32_machines = $vendor->salesReport('ML', '32', $date);
        // $ml_64_machines = $vendor->salesReport('ML', '64', $date);
        // $ml_96_machines = $vendor->salesReport('ML', '96', $date);
        // $ml_128_machines = $vendor->salesReport('ML', '128', $date);

        $ml_machines = collect($ml_8_machines)
                        // ->merge($ml_16_machines)
                        ->merge($ml_32_machines);
        // ->merge($ml_64_machines)
        // ->merge($ml_96_machines)
        // ->merge($ml_128_machines);

        $total_sales_product = $ml_machines->sum('total_sales_product');
        $total_sales_amount = $ml_machines->sum('total_sales_amount');

        return response()->json([
            'ml_machines' => $ml_machines,
            'total_sales_product' => $total_sales_product,
            'total_sales_amount' => $total_sales_amount,
            'ml_8_machines' => $ml_8_machines,
            // 'ml_16_machines' => $ml_16_machines,
            'ml_32_machines' => $ml_32_machines,
            // 'ml_64_machines' => $ml_64_machines,
            // 'ml_96_machines' => $ml_96_machines,
            // 'ml_128_machines' => $ml_128_machines
        ]);
    }
}
