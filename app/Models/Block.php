<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'code', 'type', 'content', 'status', 'css', 'script'];

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'block_position')
            ->withPivot('order', 'active')
            ->withTimestamps();
    }
}
