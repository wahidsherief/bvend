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

    public function __construct(VendorRepository $vendor, MachineService $machine_service, RefillService $refill_service)
    {
        $this->middleware('auth:vendor');
        $this->vendor = $vendor;
        $this->machine_service = $machine_service;
        $this->refill_service = $refill_service;
    }

    public function getLockerMachine()
    {
        $machines_with_models = $this->machine_service->getAllLockerMachinesOfThisVendor(Auth::id());

        return view('vendor.locker_machine', compact('machines_with_models'));
    }

    public function showLockerMachine($model, $machine_id)
    {
        $vendor_id = Auth::id();

        $machine = $this->machine_service->getThisLockerMachineOfThisVendor($vendor_id, $model, $machine_id);

        $vendor = $this->vendor->find($vendor_id);

        return view('vendor.locker_machine_show')->with(['vendor' => $vendor, 'machine' => $machine]);
    }

    public function getLocker($model, $machine_id)
    {
        $vendor_id = Auth::id();

        $lockers = $this->refill_service->allRefillLockers($model, $machine_id);

        $count = $this->refill_service->countRefilledLocker($lockers);

        $empty = isset($count[0]) ? $count[0] : 0;

        return view('vendor.lockers', compact('model', 'lockers', 'empty'));
    }

    public function showLocker($model, $machine_id, $locker_id)
    {
        $vendor_id = Auth::id();

        $machine = $this->machine_service->getThisLockerMachineOfThisVendor($vendor_id, $model, $machine_id);

        if ($locker_id > $machine->locker_end || $locker_id < $machine->locker_start) {
            return redirect()->back();
        }

        $locker = $this->refill_service->getRefillLocker($vendor_id, $model, $machine_id, $locker_id);
        $calc = $locker->locker->id % $model;
        $box_number = $calc != 0 ? $calc : $model;
        $products = $this->machine_service->getMachineProduct($vendor_id, $model);

        return view('vendor.locker_refill', compact('model', 'locker', 'products', 'box_number'));
    }

    public function openLocker($model, $machine_id, $locker_id)
    {
        return $this->refill_service->updateLocker($model, $machine_id, $locker_id, 'on');
    }

    public function closeLocker($model, $machine_id, $locker_id)
    {
        return $this->refill_service->updateLocker($model, $machine_id, $locker_id, 'off');
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

        $transactions = $transaction_service->getAllLockerMachineTransactionsOfThisVendor($vendor_id, $paginate);

        return view('transaction.locker_transactions', compact('transactions'));
    }

    public function showTransactionDetails($transaction_id, TransactionService $transaction_service)
    {
        $vendor_id = Auth::id();

        $transaction = $transaction_service->getLockerTransactionOfThisVendor($vendor_id, $transaction_id);

        return view('transaction.locker_transaction_details', compact('transaction'));
    }

    private function processRefillInput($request)
    {
        return [
            'machine_id' => $request->machine_id,
            'machine_type' => $request->machine_type,
            'machine_model' => $request->machine_model,
            'locker_id' => $request->locker_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'buy_unit_price' => $request->buy_unit_price,
            'sale_unit_price' => $request->sale_unit_price
        ];
    }
}
