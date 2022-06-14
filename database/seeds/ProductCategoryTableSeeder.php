<?php

use Illuminate\Database\Seeder;
use App\ProductCategory;

class ProductCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\ProductCategory::class, 10)->create();

        foreach (range(0, 10) as $index) {
            $category = new ProductCategory();
            $category->name = "category:" . $index;
            $category->save();
        }
    }
}
