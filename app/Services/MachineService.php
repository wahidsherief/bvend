<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class MachineService
{
    public function store($request)
    {
        $stored = false;
        $machine_table = $this->getLockerMachineTable($request->model);

        $machine = DB::table($machine_table)->get();

        if ($machine->isEmpty()) {
            $stored = $this->storeFirstMachine($request, $machine_table);

            if ($stored) {
                return true;
            } else {
                return false;
            }
        } else {
            $stored = $this->storeNewMachine($request, $machine_table);

            if ($stored) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function toggleMachine($model, $machine_id, $attributes)
    {
        $machine_table = $this->getLockerMachineTable($model);

        return \DB::table($machine_table)->where('id', $machine_id)->update($attributes);
    }

    public function update($request)
    {
        $attributes = $this->processUpdateInputs($request);

        $machine_table = $this->getLockerMachineTable($request->model);

        return \DB::table($machine_table)->where('id', $request->machine_id)->update($attributes);
    }

    private function processUpdateInputs($request)
    {
        $data = [];
        if (isset($request->address)) {
            $data['address'] = $request->address;
        }

        return $data;
    }

    public function mlMachineByID($model, $id)
    {
        $table = $this->getLockerMachineTable($model);
        return DB::table($table)->where('id', $id)->first();
    }

    public function getLockerMachineTable($model)
    {
        $locker_machines = [
            8 => 'ml_8_machines',
            16 => 'ml_16_machines',
            32 => 'ml_32_machines',
            64 => 'ml_64_machines',
            96 => 'ml_96_machines',
            128 => 'ml_128_machines'
        ];

        if ($model == 'all') {
            return $locker_machines;
        }

        return $locker_machines[$model];
    }

    public function getStoremachine_table($model)
    {
        $store_machines = [
            8 => 'ms_8_machines',
            16 => 'ms_16_machines',
            32 => 'ms_32_machines',
            64 => 'ms_64_machines',
            96 => 'ms_96_machines',
            128 => 'ms_128_machines'
        ];

        if ($model == 'all') {
            return $store_machines;
        }

        return $store_machines[$model];
    }

    private function storeFirstMachine($request, $machine_table)
    {
        $prefix = $request->type . $this->getPrefix($request->model);
        $machine_code = $prefix . mt_rand(100000, 999999);
        $locker_start = 1;
        $locker_end = $request->model;

        if ($this->generateQRCode($machine_code, $request->type, $request->model)) {
            $machine_id = $this->insertMachineToDB($machine_table, $locker_start, $locker_end, $machine_code, $request);
            if ($machine_id) {
                $stored = $this->storeLocker($request->model, $machine_id);
                return $stored;
            }
        }
    }

    private function storeNewMachine($request, $machine_table)
    {
        $prefix = $request->type . $this->getPrefix($request->model);

        $machine_code = $prefix . mt_rand(100000, 999999);
        $last_record = DB::table($machine_table)->latest('id')->first();
        $last_locker_end = $last_record->locker_end;
        $locker_start = $last_locker_end + 1;
        $locker_end = $locker_start + $request->model - 1;

        if ($this->generateQRCode($machine_code, $request->type, $request->model)) {
            $machine_id = $this->insertMachineToDB($machine_table, $locker_start, $locker_end, $machine_code, $request);

            if ($machine_id) {
                $saved = $this->storeLocker($request->model, $machine_id);
                return $saved;
            }
        }
    }

    private function storeLocker($model, $machine_id)
    {
        $lockers = [];
        for ($i = 0;$i < $model;$i++) {
            $lockers[$i]['machine_id'] = $machine_id;
            $lockers[$i]['refill_id'] = 0;
            $lockers[$i]['created_at'] = now();
            $lockers[$i]['updated_at'] = now();
        }

        $machine_lockers_table = $this->getLockersTable($model);

        return DB::table($machine_lockers_table)->insert($lockers);
    }

    private function generateQRCode($machine_code, $type, $model)
    {
        try {
            $code = 'BVENDMACHINECODE-' . $machine_code;
            $url = public_path('uploads/machine_qr_codes/' . $type . '/' . $model . '/' . $machine_code . '.png');

            \QrCode::format('png')
                ->margin(0)
                ->size(500)
                ->generate($code, $url);

            return true;
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }

    private function insertMachineToDB($machine_table, $locker_start, $locker_end, $machine_code, $request)
    {
        $category_stored = 1;

        $data = [
            'vendor_id' => $request->vendor_id,
            'machine_type' => $request->type,
            'machine_model' => $request->model,
            'locker_start' => $locker_start,
            'locker_end' => $locker_end,
            'address' => $request->address,
            'machine_code' => $machine_code,
            'qr_code' => $machine_code,
            'temperature' => 'test_code',
            'humidity' => 1,
            'fan_status' => 'off',
        ];

        $machine_id = DB::table($machine_table)->insertGetId($data);

        if ($request->category_id) {
            $categories = [];
            foreach ($request->category_id as $category_id) {
                $category = [
                    'vendor_id' => $request->vendor_id,
                    'machine_id' => $machine_id,
                    'machine_type' => $request->type,
                    'machine_model' => $request->model,
                    'product_category_id' => $category_id,
                ];

                array_push($categories, $category);
            }

            $category_stored = DB::table('vendor_product_categories')->insert($categories);
        }

        if (!$category_stored) {
            return false;
        }

        $vendor_machine_data = [
            'vendor_id' => $request->vendor_id,
            'machine_id' => $machine_id,
            'machine_type' => $request->type,
            'machine_model' => $request->model,
            'active' => 1
        ];

        $vendor_machine_stored = DB::table('vendor_machines')->insert($vendor_machine_data);

        if (!$vendor_machine_stored) {
            return false;
        }

        return $machine_id;
    }

    public function getModel($model)
    {
        $models = [
            '008' => '8',
            '016' => '16',
            '032' => '32',
            '064' => '64',
            '096' => '96',
            '128' => '128'
        ];

        return $models[$model];
    }

    private function getPrefix($model)
    {
        $prefix = [
            8 => '008',
            16 => '016',
            32 => '032',
            64 => '064',
            96 => '096',
            128 => '128'
        ];

        return $prefix[$model];
    }

    public function getLockersTable($model)
    {
        $lockers = [
            8 => 'ml_8_machine_lockers',
            16 => 'ml_16_machine_lockers',
            32 => 'ml_32_machine_lockers',
            64 => 'ml_64_machine_lockers',
            96 => 'ml_96_machine_lockers',
            128 => 'ml_128_machine_lockers'
        ];

        return $lockers[$model];
    }

    public function getStoresTable($model)
    {
        $stores = [
            8 => 'ms_8_machine_motors',
            16 => 'ms_16_machine_motors',
            32 => 'ms_32_machine_motors',
            64 => 'ms_64_machine_motors',
            96 => 'ms_96_machine_motors',
            128 => 'ms_128_machine_motors'
        ];

        return $stores[$model];
    }

    public function getAllLockerMachinesOfThisVendor($vendor_id)
    {
        $models = DB::table('vendor_machines')->where(['vendor_id' => $vendor_id])->get()->pluck(['machine_model'])->unique();

        $machines = [];
        foreach ($models as $model) {
            $machine_table = $this->getLockerMachineTable($model);
            $machine = DB::table($machine_table)->where('vendor_id', $vendor_id)->get();
            array_push($machines, $machine);
        }

        return $machines;
    }

    public function getThisLockerMachineOfThisVendor($vendor_id, $model, $machine_id)
    {
        $machine_table = $this->getLockerMachineTable($model);
        $machine = DB::table($machine_table)->where(['id' => $machine_id, 'vendor_id' => $vendor_id])->first();

        return $machine;
    }

    public function getMachineProduct($vendor_id, $model)
    {
        $machine_table = $this->getLockerMachineTable($model);

        $products = DB::table('products')
                    ->select('products.id', 'products.name')
                    ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
                    ->join('vendor_product_categories', 'vendor_product_categories.product_category_id', '=', 'product_categories.id')
                    ->join($machine_table, 'vendor_product_categories.machine_id', '=', $machine_table . '.id')
                    ->where($machine_table . '.vendor_id', '=', $vendor_id)
                    ->distinct()
                    ->get();

        return $products;
    }
}
