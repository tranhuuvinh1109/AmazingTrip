<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;
    protected $table = 'follow';
    protected $primaryKey= 'follow_id';
    protected $fillable=[
        'follow_id',
        'follower',
        'being_follower',
        'follow_status'
    ];
    public $timestamps = true;
}
