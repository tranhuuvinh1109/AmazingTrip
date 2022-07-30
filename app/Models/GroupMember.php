<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    use HasFactory;
    protected $table = 'group_members';
    protected $primaryKey= 'group_members_id';
    protected $fillable=[
        'group_id',
        'id_user'
    ];
    public $timestamps = true;

    public static function count(string $string)
    {
    }
}
