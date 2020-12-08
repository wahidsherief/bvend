<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Refill;
use App\Services\MachineService;
use DB;

class LockerController extends Controller
{
    // app gets the product list in the lockers
    public function getLockers($code)
    {
        $type = substr($code, 0, 2);
        $model_string = substr($code, 2, 3);
        $machine_service = new MachineService;
        $model = $machine_service->getModel($model_string);
        $machine_table = $machine_service->getLockerMachineTable($model);
        $locker_table = $machine_service->getLockersTable($model);
        $machine = DB::table($machine_table)->where('machine_code', $code)->first();
        $lockers = DB::table($locker_table)->where('machine_id', $machine->id)->get();
        $results = [];
        $box = 1;
        foreach ($lockers as $locker) {
            $locker->box_no = $box++;
            $refill = Refill::where('id', '=', $locker->refill_id)->first();
            if ($refill) {
                $product = Product::where('id', '=', $refill->product_id)->first();
                if ($product) {
                    $locker->product_id = $product->id;
                    $locker->sale_price = $refill->sale_unit_price;
                    $locker->image = $product->image;
                    $locker->name = ucwords($product->name);
                    if (!$locker->refilled) {
                        $locker->display = false;
                    } else {
                        $locker->display = true;
                    }
                } else {
                    return response()->json($results);
                }
            } else {
                $locker->display = false;
            }
        }

        $results['type'] = $type;
        $results['model'] = $model;
        $results['machine_id'] = $machine->id;
        $results['vendor_id'] = $machine->vendor_id;
        $results['items'] = $lockers;

        return response()->json($results);
    }

    /* hardware gets the info using this method */
    public function getLocker($type, $model, $mid, $lid)
    {
        $machine_service = new MachineService;
        $locker_table = $machine_service->getLockersTable($model);
        $locker = \DB::table($locker_table)->where(['id' => $lid, 'machine_id' => $mid])->first(['id', 'status']);

        return response()->json($locker);
    }

    // public function turnOffLockers(Request $request)
    // {
    //     $model = $request->machine_model;
    //     $reset = (new ResetLockers($model))->delay(now()->addSeconds(1));
    //     dispatch($reset);
    //     return response()->json(true);
    // }
}
