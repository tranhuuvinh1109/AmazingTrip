<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReactionBlog extends Model
{
    use HasFactory;
    protected $table = 'reaction_blog';
    protected $primaryKey= 'reaction_blog_id';
    protected $fillable=[
        'reaction_blog_id',
        'blog_id',
        'id_user',
        'reaction',
        'reaction_blog_status',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
