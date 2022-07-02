<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VendorRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // adding seed for the vendor request

        $faker = \Faker\Factory::create();
        for ($i=0;$i<=100;$i++) {
            DB::table('registration_requests')->insert([
                    'name' => $faker->userName,
                    'email' => $faker->email,
                    'business_name' => Str::random(7),
                    'business_phone' => $faker->phoneNumber,
                    'address' => Str::random(5),
                    'message' => $faker->sentence,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' =>\Carbon\Carbon::now()
                 ]);
        }
    }
}
