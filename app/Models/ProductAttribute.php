<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'display_type'];

    public function values()
    {
        return $this->hasMany(ProductAttributeValue::class, 'product_attribute_id');
    }
}
