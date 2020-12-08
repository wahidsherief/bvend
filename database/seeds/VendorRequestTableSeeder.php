<?php

use Illuminate\Database\Seeder;
use App\VendorRegistration;

class VendorRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory(App\VendorRegistration::class,10)->create();
    }
}
