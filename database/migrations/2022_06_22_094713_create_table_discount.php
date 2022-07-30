<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount', function (Blueprint $table) {
            $table->id('discount_id');
            $table->bigInteger('address_id')->unsigned();
            $table->date('time_start');
            $table->date('time_finish');
            $table->double('discount_rate');
            $table->integer('discount_quantity');
            $table->integer('number_registed');
            $table->foreign('address_id')->references('address_id')->on('address')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('discount');
    }
}
