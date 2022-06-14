<?php

namespace App\Services;

use App\Machine;
use Illuminate\Support\Facades\DB;

class MachineService
{
    public function store($request)
    {
        $machine_code = mt_rand(100000, 999999);

        if ($this->generateQRCode($machine_code, $request->type)) {
            $machine_id = $this->saveMachineToDB($machine_code, $request);

            if ($machine_id) {
                $saved = $this->saveLocksToDB($machine_id, $request);
                return $saved;
            }
        }
    }

    public function toggleMachineActivation($machine_id, $attributes)
    {
        return Machine::where('id', $machine_id)->update($attributes);
    }

    public function update($request)
    {
        $attributes = $this->processUpdateInputs($request);

        return Machine::where('id', $request->machine_id)->update($attributes);
    }

    private function processUpdateInputs($request)
    {
        $data = [];
        if (isset($request->address)) {
            $data['address'] = $request->address;
        }

        return $data;
    }

    public function machineByID($id)
    {
        return Machine::where('id', $id)->first();
    }


    private function saveLocksToDB($machine_id, $request)
    {
        $locks_per_channel = $request->locks_per_channel;
        $no_of_channels = $request->no_of_channels;
        $total_locks = $locks_per_channel * $no_of_channels;
        
        $locks = [];
        $channel = 1;
        $lock = 1;
        for ($i=1; $i <= $total_locks; $i++) {
            $locks[$i]['machine_id'] = $machine_id;
            $locks[$i]['channel_id'] = $channel;
            $locks[$i]['lock_id'] = $lock++;
            $locks[$i]['refill_id'] = 0;
            $locks[$i]['created_at'] = now();
            $locks[$i]['updated_at'] = now();

            if ($lock > $locks_per_channel) {
                $channel++;
                $lock = 1;
            }
        }

        return DB::table('locks')->insert($locks);
    }

    private function generateQRCode($machine_code, $type)
    {
        try {
            $code = 'BVENDMACHINECODE-' . $machine_code;
            $url = public_path('uploads/machine_qr_codes/' . $type . '-' . $machine_code . '.png');
            // dd($url);
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

    private function saveMachineToDB($machine_code, $request)
    {
        $category_stored = 1;

        $data = [
            'vendor_id' => $request->vendor_id,
            'machine_type' => $request->type,
            'no_of_channels' => $request->no_of_channels,
            'locks_per_channel' => $request->locks_per_channel,
            'address' => $request->address,
            'machine_code' => $machine_code,
            'qr_code' => $machine_code,
            'temperature' => 'test_code',
            'humidity' => 1,
            'fan_status' => 'off',
        ];

        $machine_id = Machine::insertGetId($data);

        if ($request->category_id) {
            $categories = [];
            foreach ($request->category_id as $category_id) {
                $category = [
                    'vendor_id' => $request->vendor_id,
                    'machine_id' => $machine_id,
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
            'active' => 1
        ];

        $vendor_machine_stored = DB::table('vendor_machines')->insert($vendor_machine_data);

        if (!$vendor_machine_stored) {
            return false;
        }

        return $machine_id;
    }

    public function getAllMachinesOfVendor($vendor_id)
    {
        return Machine::where('vendor_id', $vendor_id)->get();
    }

    public function getSpecificMachineOfVendor($vendor_id, $machine_id)
    {
        return Machine::where(['id' => $machine_id, 'vendor_id' => $vendor_id])->first();
    }

    public function getMachineProductsOfVendor($vendor_id)
    {
        $products = DB::table('products')
                    ->select('products.id', 'products.product_name')
                    ->join('product_categories', 'product_categories.id', '=', 'products.product_category_id')
                    ->join('vendor_product_categories', 'vendor_product_categories.product_category_id', '=', 'product_categories.id')
                    ->join('machines', 'vendor_product_categories.machine_id', '=', 'machines.id')
                    ->where('machines.vendor_id', '=', $vendor_id)
                    ->distinct()
                    ->get();

        return $products;
    }
}
