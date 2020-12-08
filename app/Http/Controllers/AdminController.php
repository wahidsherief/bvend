<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Machine\LockerMachine\ML8Machine;
use App\Machine\LockerMachine\ML16Machine;
use App\Machine\LockerMachine\ML32Machine;
use App\Machine\LockerMachine\ML64Machine;
use App\Machine\LockerMachine\ML96Machine;
use App\Machine\LockerMachine\ML128Machine;
use App\Services\PaymentService;
use App\Services\TransactionService;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function getDashboardInfo($date)
    {
        $admin = new Admin;

        $date = \Carbon\Carbon::today()->subDays($date)->toDateString();

        $ml_8_machines = $admin->salesReport('ML', '8', $date);
        // $ml_16_machines = $admin->salesReport('ML', '16', $date);
        $ml_32_machines = $admin->salesReport('ML', '32', $date);
        // $ml_64_machines = $admin->salesReport('ML', '64', $date);
        // $ml_96_machines = $admin->salesReport('ML', '96', $date);
        // $ml_128_machines = $admin->salesReport('ML', '128', $date);

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

    public function getMachines()
    {
        $ml_8_machines = ML8Machine::with('vendor')->get();
        // $ml_16_machines = ML16Machine::with('vendor')->get();
        $ml_32_machines = ML32Machine::with('vendor')->get();
        // $ml_64_machines = ML64Machine::with('vendor')->get();
        // $ml_96_machines = ML96Machine::with('vendor')->get();
        // $ml_128_machines = ML128Machine::with('vendor')->get();

        $machines = collect($ml_8_machines)
                        // ->merge($ml_16_machines)
                        ->merge($ml_32_machines);
        // ->merge($ml_64_machines)
        // ->merge($ml_96_machines)
        // ->merge($ml_128_machines);

        foreach ($machines as $key => $machine) {
            $machine->vendor = \App\Vendor::where('id', $machine->vendor_id)->first();
        }

        return view('admin.machine.machines', compact('machines'));
    }

    /*
    ========================
      Start of Transaction Section
    ========================
    */

    public function searchTransactions(Request $request)
    {
        return view('admin.transaction.search');
    }

    public function search(Request $request, PaymentService $payment_service)
    {
        $request->validate([
            'trx_id' => 'required'
        ]);

        $result = $payment_service->bkashSearchTransaction($request->trx_id);

        return redirect()->back()->with(compact('result'));
    }

    public function getTransactions($vendor_id, TransactionService $transaction_service)
    {
        $paginate = 15;

        $transactions = $transaction_service->getAllLockerMachineTransactionsOfThisVendor($vendor_id, $paginate);

        return view('transaction.admin_locker_transactions', compact('transactions'));
    }

    public function showTransactionDetails($vendor_id, $transaction_id, TransactionService $transaction_service)
    {
        $transaction = $transaction_service->getLockerTransactionOfThisVendor($vendor_id, $transaction_id);

        return view('transaction.admin_locker_transaction_details', compact('transaction'));
    }

    /*
    ========================
      End of Transaction Section
    ========================
    */
}
