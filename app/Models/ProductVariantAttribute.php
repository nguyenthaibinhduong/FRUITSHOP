<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariantAttribute extends Model
{
    use HasFactory;
    protected $fillable = [
        'variant_id',
        'attribute_id',
        'value_id',
    ];

    // Biến thể cha
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    // Thuộc tính (Màu, Size, ...)
    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'attribute_id');
    }

    // Giá trị của thuộc tính (Đỏ, Xanh, S, M, ...)
    public function value()
    {
        return $this->belongsTo(ProductAttributeValue::class, 'value_id');
    }
}
