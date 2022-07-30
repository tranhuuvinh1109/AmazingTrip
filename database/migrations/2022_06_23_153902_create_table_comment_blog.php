<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCommentBlog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_blog', function (Blueprint $table) {
            $table->id('comment_blog_id');
            $table->bigInteger('blog_id')->unsigned();
            $table->bigInteger('id_user')->unsigned();
            $table->string('comment_blog_image')->nullable();
            $table->longtext('comment_blog_content')->notnull();
            $table->timestamps();

            $table->foreign('blog_id','id_user')
            ->references('blog_id','id')->on('blog','user_travel')
            ->onDelete('CASCADE')
            ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_blog');
    }
}
