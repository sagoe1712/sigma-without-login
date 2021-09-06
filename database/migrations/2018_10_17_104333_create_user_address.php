<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::enableForeignKeyConstraints();
//        Schema::create('shipping_address', function (Blueprint $table) {
//            $table->engine = 'InnoDB';
//            $table->increments('id');
//            $table->integer('user_id')->unsigned();
//            $table->foreign('user_id')->references('id')->on('users');
//            $table->integer('company_id')->unsigned();
//            $table->foreign('company_id')->references('id')->on('company');
//            $table->string('firstname');
//            $table->string('lastname');
//            $table->string('email');
//            $table->string('phone');
//            $table->string('address');
//            $table->integer('state_id')->unsigned();
//            $table->foreign('state_id')->references('state_id')->on('states');
//            $table->integer('city_id')->unsigned();
//            $table->foreign('city_id')->references('city_id')->on('cities');
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_address');
    }
}
