<?php

use Illuminate\Database\Seeder;

class VendorProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1,8) as $index) {
        	DB::table('vendor_product_categories')->insert([
	            'vendor_id' => 1,
	            'machine_id' => $index,
	            'machine_type' => 'ML',
	            'machine_model' => '8',
	            'product_category_id' => 1,
         	]);
        }
    }
}
