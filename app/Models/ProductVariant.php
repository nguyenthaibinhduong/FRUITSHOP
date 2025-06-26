<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'sku', 'price', 'stock', 'image'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function values()
    {
        return $this->belongsToMany(ProductAttributeValue::class, 'product_variant_values');
    }
    public function attributes()
    {
        return $this->hasMany(ProductVariantAttribute::class, 'variant_id');
    }
}
