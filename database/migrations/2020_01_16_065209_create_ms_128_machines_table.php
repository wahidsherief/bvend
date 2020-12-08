<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMS128MachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_128_machines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vendor_id');
            $table->integer('locker_start');
            $table->integer('locker_end');
            $table->string('machine_code');
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
        Schema::dropIfExists('ms_128_machines');
    }
}
