<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('photo')->default('default.png');
            $table->string('code')->unique();
            $table->string('name');
            $table->boolean('gender')->default(true);
            $table->integer('department_id')->unsigned();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->integer('position_id')->unsigned();
            $table->foreign('position_id')->references('id')->on('positions');
            $table->date('date_of_join');
            $table->date('date_of_birth')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('account_number')->nullable();
            $table->integer('salary');
            $table->date('date_of_resignation')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
