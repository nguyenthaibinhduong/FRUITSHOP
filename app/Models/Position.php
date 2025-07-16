<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'type',
        'row',
        'col',
        'width',
        'width_sm',
        'width_md',
        'width_lg',
        'align',
        'order'
    ];

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
}
