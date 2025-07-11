<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'url',
        'product_id',
        'image_type'
    ];

    // Mối quan hệ với sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
