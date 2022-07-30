<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReactionBlogAddress extends Model
{
    use HasFactory;
    protected $table = 'reaction_blog_address';
    protected $primaryKey= 'reaction_blog_address_id';
    protected $fillable=[
        'reaction_blog_address_id',
        'blog_address_id',
        'id_user',
        'reaction',
        'reaction_blog_status',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
