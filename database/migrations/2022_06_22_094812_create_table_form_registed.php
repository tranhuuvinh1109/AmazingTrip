<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFormRegisted extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_registed', function (Blueprint $table) {
            $table->id('form_id');
            $table->bigInteger('discount_id')->unsigned();
            $table->bigInteger('id_user')->unsigned();
            $table->integer('quantity_registed');
            $table->foreign('discount_id')->references('discount_id')->on('discount')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_user')->references('id')->on('user_travel')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('form_registed');
    }
}
