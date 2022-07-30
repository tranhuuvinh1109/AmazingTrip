<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;
    protected $table = 'bookmark';
    protected $primaryKey = 'bookmark_id';
    protected $filltable=[
        'bookmark_id',
        'address_id',
        'status',
        'id_user',
    ];
    public $timestamp= true;
}
