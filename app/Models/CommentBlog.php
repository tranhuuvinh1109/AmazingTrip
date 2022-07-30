<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentBlog extends Model
{
    use HasFactory;
    protected $table = 'comment_blog';
    protected $primaryKey = 'comment_blog_id';
    protected $filltable=[
        'comment_blog_id',
        'blog_id',
        'id_user',
        'comment_blog_image',
        'comment_blog_content',
        'created_at',
        'updated_at'
    ];
    public $timestamp= true;
}
