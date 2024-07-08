<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Type extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=['name','parent_id'];
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_types');
    }
    
}
