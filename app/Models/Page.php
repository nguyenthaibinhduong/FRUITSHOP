<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'css',
        'script',
        'meta_title',
        'meta_description',
        'status'
    ];

    public function sections()
    {
        return $this->belongsToMany(Section::class)
            ->withPivot('order')
            ->withTimestamps()
            ->orderBy('page_section.order');
    }
}
