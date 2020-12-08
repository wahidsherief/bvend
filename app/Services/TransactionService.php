<?php

namespace App\Services;

use App\MLTransaction;
use App\TransactionLocker;

class TransactionService extends BaseService
{
    protected $locker_machine_transaction;
    protected $machine_service;
    protected $transaction_locker;

    public function __construct(
        MLTransaction $locker_machine_transaction,
        TransactionLocker $transaction_locker,
        MachineService $machine_service
    ) {
        $this->locker_machine_transaction = $locker_machine_transaction;
        $this->machine_service = $machine_service;
        $this->transaction_locker = $transaction_locker;
    }

    public function getAllLockerMachineTransactionsOfThisVendor($vendor_id, $paginate)
    {
        $transactions = $this->locker_machine_transaction->where(['vendor_id' => $vendor_id, 'status' => 'success'])->latest()->paginate($paginate);

        foreach ($transactions as $transaction) {
            $machine_table = $this->machine_service->getLockermachineTable($transaction->machine_model);
            $result = \DB::table($machine_table)->where('id', $transaction->machine_id)->first('machine_code');
            $transaction->machine_code = $result->machine_code;
        }

        return $transactions;
    }

    public function getLockerTransactionOfThisVendor($vendor_id, $transaction_id)
    {
        $transaction = MLTransaction::with(['lockers.refill.product.category', 'lockers.refill.product.brand', 'vendor'])
        ->where(['vendor_id' => $vendor_id, 'id' => $transaction_id])->first();

        $transaction->machine = $this->machine_service->getThisLockerMachineOfThisVendor($vendor_id, $transaction->machine_model, $transaction->machine_id);

        return $transaction;
    }

    public function storeAndReturn(array $attributes)
    {
        $transaction = $this->locker_machine_transaction->newInstance()->fill($attributes);

        $transaction->save();

        return $transaction;
    }

    public function storeLocker($data)
    {
        return $this->transaction_locker->insert($data);
    }
}
