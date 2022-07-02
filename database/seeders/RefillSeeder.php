<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RefillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(2, 6) as $value) {
            \DB::table('refills')->insert([
                'machine_id' => $value,
                'machine_type' => 'store',
                'channel_id' => rand(1, 10),
                'lock_id' => 1,
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
