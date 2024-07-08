<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'author',
        'title',
        'subtitle',
        'content',
        'user_id',
        'image',
        'public_date',
        'uploaded',
    ];
    public function types()
    {
        return $this->belongsToMany(Type::class, 'post_types');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
