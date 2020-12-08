<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateML32MachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ml_32_machines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('machine_code');
            $table->enum('machine_type', ['ML', 'MS']);
            $table->enum('machine_model', ['8', '16', '32', '64', '96', '128', '256']);
            $table->integer('vendor_id');
            $table->integer('locker_start');
            $table->integer('locker_end');
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
        Schema::dropIfExists('ml_32_machines');
    }
}
