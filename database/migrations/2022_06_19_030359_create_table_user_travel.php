<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUserTravel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_travel', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->dateTime('birthday');
            $table->string('email')->unique();;
            $table->string('phone');
            $table->string('password');
            $table->string('address')->nullable();;
            $table->string('nickname')->nullable();;
            $table->string('avatar')->nullable();;
            $table->unsignedInteger('role')->default(1)->comment='0:admin 1:host 2:member';
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
        Schema::dropIfExists('user_travel');
    }
}
