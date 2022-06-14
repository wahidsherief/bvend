<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Machine;
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

        $sales_report = $admin->salesReport($date);

        return $sales_report;
    }

    public function getMachines()
    {
        $machines = Machine::with('vendor')->get();

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

        $transactions = $transaction_service->getAllTransactionsOfVendor($vendor_id, $paginate);

        return view('transaction.admin_transactions', compact('transactions'));
    }

    public function showTransactionDetails($vendor_id, $transaction_id, TransactionService $transaction_service)
    {
        $transaction = $transaction_service->getSpecificTransactionOfVendor($vendor_id, $transaction_id);

        return view('transaction.admin_transaction_details', compact('transaction'));
    }

    /*
    ========================
      End of Transaction Section
    ========================
    */
}
