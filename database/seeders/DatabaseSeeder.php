<?php
namespace Database\Seeders;

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
        $this->call(ProductSeeder::class);
        // $this->call(VendorTableSeeder::class);
        // $this->call(VendorRequestSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(ProductBrandSeeder::class);
        $this->call(RefillSeeder::class);
        // $this->call(VendorProductCategoryTableSeeder::class);
        $this->call(TransactionSeeder::class);
    }
}
