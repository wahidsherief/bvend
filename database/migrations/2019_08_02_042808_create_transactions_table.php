<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('machine_id');
            $table->integer('refill_id');
            $table->integer('vendor_id');
            $table->integer('user_id');
            $table->string('invoice_no');
            $table->string('payment_id')->nullable();
            $table->string('bkash_trx_id')->nullable();
            $table->integer('total_amount');
            $table->integer('discount');
            $table->integer('payment_method_id')->nullable();
            $table->enum('status', ['success', 'fail'])->default('fail');
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
        Schema::dropIfExists('transactions');
    }
}
