<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CartProduct extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'user_id',
        'cart_id',
        'product_id',
        'product_name',
        'product_price',
        'product_image',
        'quantity'
    ];
    use HasFactory;
    public function product(){
        return $this->hasMany(Product::class);
    }
    public function user(){
        return $this->hasMany(User::class);
    }
    public function cart(){
        return $this->hasMany(Cart::class);
    }
}
