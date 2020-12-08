<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMSTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('machine_id');
            $table->integer('user_id');
            $table->integer('motor_id');
            $table->integer('product_id');
            $table->integer('quantity');
            $table->string('invoice_no');
            $table->string('payment_id')->nullable();
            $table->string('trx_id')->nullable();
            $table->integer('total_amount');
            $table->integer('discount');
            $table->integer('payment_method_id')->nullable();
            $table->enum('status', ['success', 'fail']);
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
        Schema::dropIfExists('ms_transactions');
    }
}
