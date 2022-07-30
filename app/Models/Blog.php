<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blog';
    protected $primaryKey = 'blog_id';
    protected $filltable=[
        'blog_id',
        'id_user',
        'group_id',
        'blog_title',
        'blog_image',
        'blog_content',
    ];
    public $timestamp= true;
}
