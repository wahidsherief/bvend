<?php

use Illuminate\Database\Seeder;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\MLTransaction::class,10)->create();
        $faker = \Faker\Factory::create();
        for ($i=1;$i<=20;$i++) {
            DB::table('transactions')->insert([
                'id' => $i,
                // 'machine_code' => 'ML0080213160312',
                'machine_id' => rand(1, 3),
                'refill_id' => rand(1, 100),
                'vendor_id' => 1,
                'user_id' => $i,
                'invoice_no' => $faker->randomDigit,
                'payment_id' => $faker->randomDigit,
                'bkash_trx_id' => rand(1, 5000),
                'total_amount' => $faker->randomFloat,
                'discount' => $faker->randomFloat,
                'payment_method_id' => $faker->randomDigit,
                'status' => "success",
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' =>\Carbon\Carbon::now()
             ]);
        }
    }
}
