<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_assigns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->integer('device_id')->unsigned();
            $table->foreign('device_id')->references('id')->on('devices');
            $table->integer('process_assign')->unsigned();
            $table->foreign('process_assign')->references('id')->on('employees');
            $table->integer('process_remove')->unsigned()->nullable();
            $table->foreign('process_remove')->references('id')->on('employees');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_assigns');
    }
}
