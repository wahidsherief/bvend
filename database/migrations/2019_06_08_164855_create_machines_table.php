<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('machine_code');
            $table->enum('machine_type', ['store', 'box']);
            $table->integer('no_of_channels');
            $table->integer('locks_per_channel');
            $table->integer('vendor_id');
            $table->string('qr_code');
            $table->text('address');
            $table->string('temperature');
            $table->string('humidity');
            $table->enum('fan_status', ['off', 'on'])->default('off');
            $table->boolean('maintainance')->default(0);
            $table->boolean('active')->default(0);
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
        Schema::dropIfExists('machines');
    }
}
