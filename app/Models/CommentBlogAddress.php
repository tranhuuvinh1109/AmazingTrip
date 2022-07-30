<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentBlogAddress extends Model
{
    use HasFactory;
    protected $table = 'comment_blog_address';
    protected $primaryKey = 'comment_blog_id';
    protected $filltable=[
        'comment_blog_id',
        'blog_address_id',
        'id_user',
        'comment_address_image',
        'comment_address_content',
        'created_at',
        'updated_at'
    ];
    public $timestamp= true;
}
