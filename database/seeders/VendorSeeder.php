<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Vendor;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            'kalam brothers ltd',
            'salam brothers ltd',
            'momin brothers ltd',
            'abul brothers ltd',
            'kader brothers ltd',
        ];

        foreach ($items as $key=>$item) {
            $vendor = new Vendor;
            $vendor->name = "Test User";
            $vendor->phone = "01825645569";
            $vendor->image = "test";
            $vendor->email = "test_".$key."@bvend.com";
            $vendor->password = "test";
            $vendor->business_name = $item;
            $vendor->business_phone = '01564589785';
            $vendor->trade_licence_no = '1234';
            $vendor->bank_account_no = 1234;
            $vendor->nid = 1234;
            $vendor->save();
        }
    }
}
