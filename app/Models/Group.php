<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'group';
    protected $primaryKey= 'group_id';
    protected $fillable=[
        'group_id',
        'group_name',
        'group_image',
        'address_id',
        'group_admin',
        'group_member'
    ];
    public $timestamps = true;
    /**
     * @var mixed
     */

}
