<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('file')->nullable();
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->integer('createdBy')->nullable();
            $table->dateTime('createdOn')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payrolls');
    }
}
