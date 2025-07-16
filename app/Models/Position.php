<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;
    protected $fillable = ['section_id', 'name', 'code', 'row', 'col', 'width', 'width_sm', 'width_md', 'width_lg', 'align', 'order'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function blocks()
    {
        return $this->belongsToMany(Block::class, 'block_position')
            ->withPivot('order', 'active')
            ->withTimestamps()
            ->orderBy('pivot_order');
    }
}
