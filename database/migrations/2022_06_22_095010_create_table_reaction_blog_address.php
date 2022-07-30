<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableReactionBlogAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reaction_blog_address', function (Blueprint $table) {
            $table->id('reaction_blog_address_id');
            $table->bigInteger('blog_address_id')->unsigned();
            $table->bigInteger('id_user')->unsigned();
            $table->integer('reaction')->comment='0:dislike 1:like';
            $table->integer('reaction_blog_status')->default(1)->comment='1: exist  0: deleted';
            $table->foreign('blog_address_id')->references('blog_address_id')->on('blog_address')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('reaction_blog_address');
    }
}
