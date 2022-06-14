<?php

use Illuminate\Database\Seeder;
use App\ProductBrand;

class ProductBrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\ProductBrand::class, 10)->create();

        foreach (range(0, 10) as $index) {
            $brand = new ProductBrand();
            $brand->name = "brand:" . $index;
            $brand->image = "null";
            $brand->save();
        }
    }
}
