<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormRegister extends Model
{
    use HasFactory;
    protected $table = 'form_registed';
    protected $primaryKey = 'form_id';
    protected $filltable=[
        'form_id',
        'discount_id',
        'id_user',
        'quantity_registed',
        'created_at',
        'updated_at'
    ];
    public $timestamp= true;
}
