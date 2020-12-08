<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Refill;
use App\Product;
use App\Jobs\ResetLockers;

class RefillService extends BaseService
{
    protected $refill;
    protected $machine_service;

    public function __construct(Refill $refill, MachineService $machine_service)
    {
        $this->refill = $refill;
        $this->machine_service = $machine_service;
    }

    public function findByCondition(array $conditions)
    {
        return $this->refill->where($conditions)->first();
    }

    public function allRefillLockers($model, $machine_id)
    {
        $lockerTable = $this->machine_service->getLockersTable($model);
        $lockers = DB::table($lockerTable)->where(['machine_id' => $machine_id])->get();

        return $lockers;
    }

    public function getRefillLocker($vendor_id, $model, $machine_id, $locker_id)
    {
        $lockerTable = $this->machine_service->getLockersTable($model);
        $this_locker = collect();

        $locker = DB::table($lockerTable)->where(['id' => $locker_id,
            'machine_id' => $machine_id])->first();

        $refill = $this->refill->where('id', $locker->refill_id)->first();
        $product = isset($refill->product_id) ? Product::with(['category', 'brand'])->where('id', $refill->product_id)->first() : null;

        $this_locker->locker = $locker;
        $this_locker->refill = $refill;
        $this_locker->product = $product;

        return $this_locker;
    }

    public function refill(array $attributes)
    {
        $refill = $this->refill->create($attributes);

        if (!isset($refill)) {
            return false;
        }

        $model = $attributes['machine_model'];
        $locker_id = $attributes['locker_id'];

        $lockerTable = $this->machine_service->getLockersTable($model);

        DB::table($lockerTable)->where('id', $locker_id)->update(
            [
                'refill_id' => $refill->id,
                'status' => 'off',
                'refilled' => 1,
            ]
        );

        return true;
    }

    public function updateLocker($model, $machine_id, $locker_id, $status)
    {
        $lockerTable = $this->machine_service->getLockersTable($model);

        $updated = \DB::table($lockerTable)->where([
            ['id', '=', $locker_id],
            ['machine_id', '=', $machine_id],
        ])->update(['status' => $status]);

        if (!$updated) {
            return response()->json(false);
        }

        $reset = (new ResetLockers($model, $machine_id, $locker_id))->delay(now()->addMinutes(2));
        dispatch($reset);

        return response()->json(true);
    }

    public function countRefilledLocker($lockers)
    {
        $count = $lockers->countBy(function ($item) {
            return $item->refilled;
        });

        return $count;
    }
}
