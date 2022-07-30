<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogAddress extends Model
{
    use HasFactory;
    protected $table = 'blog_address';
    protected $primaryKey = 'blog_address_id';
    protected $filltable=[
        'blog_address_id',
        'id_user',
        'address_id',
        'blog_address_vote',
        'blog_address_image',
        'blog_address_content',
        'created_at',
        'updated_at'
    ];
    public $timestamp= true;
}
