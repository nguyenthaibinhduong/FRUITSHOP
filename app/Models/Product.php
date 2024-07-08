<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'name',
        'description',
        'longdescription',
        'price',
        'sale_percent',
        'quantity',
        'uploaded',
        'brand_id',
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }
    public function image()
    {
        return $this->belongsToMany(ProductImage::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
