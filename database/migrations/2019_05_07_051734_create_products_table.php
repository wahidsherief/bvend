<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_category_id');
            $table->integer('product_brand_id')->nullable();
            $table->string('product_name');
            $table->string('description');
            $table->string('color')->nullable();
            $table->string('weight')->nullable();
            $table->string('flavor')->nullable();
            $table->string('unit')->nullable();
            $table->string('image');
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
