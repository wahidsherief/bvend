<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('machine_id');
            $table->enum('machine_type', ['store', 'box']);
            $table->integer('channel_id');
            $table->integer('lock_id');
            $table->integer('product_id');
            $table->integer('quantity');
            $table->integer('buy_unit_price');
            $table->integer('sale_unit_price');
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
        Schema::dropIfExists('refill');
    }
}
