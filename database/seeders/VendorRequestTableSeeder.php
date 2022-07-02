<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\VendorRegistration;

class VendorRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\VendorRegistration::class, 10)->create();
    }
}
