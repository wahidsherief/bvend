<?php

use Illuminate\Database\Seeder;

class RefillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        	
    	foreach (range(2,6) as $value) {
            DB::table('refills')->insert([
        		'machine_id' => $value,
                'machine_type' => 'ML',
                'machine_model' => '8',
        		'locker_id' => 1,
        		'product_id' => $value,
        		'quantity' => 1,
        		'buy_unit_price' => 10,
        		'sale_unit_price' => 30,
        		'created_at' => now(),
        		'updated_at' => now(),
        	]);
        }
    }
}
