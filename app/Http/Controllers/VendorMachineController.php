<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\MachineService;
use App\Services\RefillService;
use App\Repositories\VendorRepository;
use App\Http\Requests\RefillLockerRequest;
use App\Services\TransactionService;

class VendorMachineController extends Controller
{
    protected $vendor;
    protected $machine_service;
    protected $refill_service;

    public function __construct(
        VendorRepository $vendor,
        MachineService $machine_service,
        RefillService $refill_service
    ) {
        $this->middleware('auth:vendor');
        $this->vendor = $vendor;
        $this->machine_service = $machine_service;
        $this->refill_service = $refill_service;
    }

    public function getMachine()
    {
        $machines = $this->machine_service->getAllMachinesOfVendor(Auth::id());

        return view('vendor.machine', compact('machines'));
    }

    public function showMachine($machine_id)
    {
        $vendor_id = Auth::id();

        $machine = $this->machine_service->getSpecificMachineOfVendor($vendor_id, $machine_id);

        $vendor = $this->vendor->find($vendor_id);

        return view('vendor.machine_show')->with(['vendor' => $vendor, 'machine' => $machine]);
    }

    public function getLocks($machine_id)
    {
        $vendor_id = Auth::id();

        $locks = $this->refill_service->allRefillLocks($machine_id);

        $count = $this->refill_service->countRefilledLocks($locks);

        $empty = isset($count[0]) ? $count[0] : 0;

        return view('vendor.locks_details', compact('locks', 'empty'));
    }

    public function showLocks($machine_id, $id)
    {
        $vendor_id = Auth::id();

        $machine = $this->machine_service->getSpecificMachineOfVendor($vendor_id, $machine_id);

        // if ($id > $machine->end || $id < $machine->start) {
        //     return redirect()->back();
        // }

        $lock = $this->refill_service->getRefillLocks($vendor_id, $machine_id, $id);
        // $calc = $locker->locker->id % $model;
        // $box_number = $calc != 0 ? $calc : $model;
        $products = $this->machine_service->getMachineProductsOfVendor($vendor_id);

        return view('vendor.refill', compact('lock', 'products'));
    }

    public function openLocker($model, $machine_id, $id)
    {
        return $this->refill_service->updateLocker($model, $machine_id, $id, 'on');
    }

    public function closeLocker($model, $machine_id, $id)
    {
        return $this->refill_service->updateLocker($model, $machine_id, $id, 'off');
    }

    public function refillLocker(RefillLockerRequest $request)
    {
        $attributes = $this->processRefillInput($request);

        $refilled = $this->refill_service->refill($attributes);

        if (!$refilled) {
            redirect()->back()->with('error', 'Product refill failed!');
        }

        return redirect()->back()->with('success', 'Product refilled successfully!');
    }

    public function getTransactions(TransactionService $transaction_service)
    {
        $vendor_id = Auth::id();

        $paginate = 15;

        $transactions = $transaction_service->getAllTransactionsOfVendor($vendor_id, $paginate);

        return view('transaction.transactions', compact('transactions'));
    }

    public function showTransactionDetails($transaction_id, TransactionService $transaction_service)
    {
        $vendor_id = Auth::id();

        $transaction = $transaction_service->getSpecificTransactionOfVendor($vendor_id, $transaction_id);

        return view('transaction.transaction_details', compact('transaction'));
    }

    private function processRefillInput($request)
    {
        return [
            'machine_id' => $request->machine_id,
            'machine_type' => $request->machine_type,
            'machine_model' => $request->machine_model,
            'id' => $request->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'buy_unit_price' => $request->buy_unit_price,
            'sale_unit_price' => $request->sale_unit_price
        ];
    }
}
