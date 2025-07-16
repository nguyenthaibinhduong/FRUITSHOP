<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'type',
        'description'
    ];

    public function pages()
    {
        return $this->belongsToMany(Page::class)
            ->withPivot('order')
            ->withTimestamps()
            ->orderBy('page_section.order');
    }

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
}
