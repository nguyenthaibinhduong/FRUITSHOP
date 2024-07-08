<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=[
        'user_id',
        'customer_name',
        'customer_email',
        'customer_tel',
        'customer_address',
        'total',
        'discount',
        'total_price',
        'payment_method',
        
        'status'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function statuses(){
        return $this->belongsTo(OrderStatus::class,'status');
    }
   
}
