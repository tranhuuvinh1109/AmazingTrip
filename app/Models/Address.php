<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $primaryKey = 'address_id';
    protected $fillable = ['address_id', 'id_host', 'address_name', 'address_description', 'address_image', 'address_map', 'created_at', 'updated_at'];
    public $timestamps = true;
    use HasFactory;
}
