<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'code',
        'type',
        'content',
        'class',
        'status',
        'section_id',
        'position_id'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
