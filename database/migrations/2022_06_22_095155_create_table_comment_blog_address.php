<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCommentBlogAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_blog_address', function (Blueprint $table) {
            $table->id('comment_blog_id');
            $table->bigInteger('blog_address_id')->unsigned();
            $table->bigInteger('id_user')->unsigned();
            $table->text('comment_address_content');
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
        Schema::dropIfExists('comment_blog_address');
    }
}
