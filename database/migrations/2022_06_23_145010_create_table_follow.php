<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFollow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow', function (Blueprint $table) {
            $table->id('follow_id');
            $table->bigInteger('follower')->unsigned()->references('id')->on('user_travel')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');;
            $table->bigInteger('being_follower')->unsigned() ->references('id')->on('user_travel')
                ->onDelete('CASCADE')
                ->onUpdate('CASCADE');;
            $table->unsignedInteger('follow_status')->default(0);  //0:unfollow 1: follow
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
        Schema::dropIfExists('follow');
    }
}
