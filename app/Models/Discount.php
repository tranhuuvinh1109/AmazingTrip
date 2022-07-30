<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    protected $table = 'discount';
    protected $primaryKey = 'discount_id';
    protected $filltable=[
        'discount_id',
        'address_id',
        'time_start',
        'time_finish',
        'discount_rate',
        'discount_quantity',
        'number_registed',
        'created_at',
        'updated_at'
    ];
    public $timestamp= true;
}
