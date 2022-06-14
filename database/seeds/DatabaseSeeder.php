<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProductTableSeeder::class);
        // $this->call(VendorTableSeeder::class);
        // $this->call(VendorRequestSeeder::class);
        $this->call(ProductCategoryTableSeeder::class);
        $this->call(ProductBrandTableSeeder::class);
        $this->call(RefillTableSeeder::class);
        // $this->call(VendorProductCategoryTableSeeder::class);
        $this->call(TransactionTableSeeder::class);
    }
}
