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

    public function allRefillLocks($machine_id)
    {
        $locks = DB::table('locks')->where(['machine_id' => $machine_id])->get();

        return $locks;
    }

    public function getRefillLocks($vendor_id, $machine_id, $lock_id)
    {
        $locks = DB::table('locks')->where(['lock_id' => $lock_id,
            'machine_id' => $machine_id])->first();

        $refill = $this->refill->where('id', $locks->refill_id)->first();
        $product = isset($refill->product_id) ? Product::with(['category', 'brand'])->where('id', $refill->product_id)->first() : null;

        $locks->lock= $locks;
        $locks->refill = $refill;
        $locks->product = $product;

        return $locks;
    }

    public function refill(array $attributes)
    {
        $refill = $this->refill->create($attributes);

        if (!isset($refill)) {
            return false;
        }

        $lock_id = $attributes['lock_id'];


        DB::table('locks')->where('id', $lock_id)->update(
            [
                'refill_id' => $refill->id,
                'status' => 'off',
                'refilled' => 1,
            ]
        );

        return true;
    }

    public function updateLocker($machine_id, $lock_id, $status)
    {
        $updated = \DB::table('locks')->where([
            ['id', '=', $lock_id],
            ['machine_id', '=', $machine_id],
        ])->update(['status' => $status]);

        if (!$updated) {
            return response()->json(false);
        }

        $reset = (new ResetLockers($machine_id, $lock_id))->delay(now()->addMinutes(2));
        dispatch($reset);

        return response()->json(true);
    }

    public function countRefilledLocks($locks)
    {
        $count = $locks->countBy(function ($item) {
            return $item->refilled;
        });

        return $count;
    }
}
