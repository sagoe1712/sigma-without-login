<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_totals', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('member_id');
            $table->integer('company_id');
            $table->bigInteger('credit');
            $table->bigInteger('debit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('member_totals');
    }
}
