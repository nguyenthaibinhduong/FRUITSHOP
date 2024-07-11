<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function ajaxSearch($key){
        $data = DB::table('products')
        ->join('product_images', 'product_images.product_id', '=', 'products.id')
        ->where('products.name', 'like', '%' . $key . '%')
        ->where('product_images.image_type', 0)
        ->limit(5)->get();
        return $data;
    }
    public function getCartAjax($id){
        $data= DB::table('cart_products')
        ->join('product_images', 'product_images.product_id', '=', 'cart_products.product_id')
        ->where('user_id',$id)->get();
        return $data;
    }
    public function addCartAjax(Request $request){
        //print_r($request->all());
        $cart = new Cart;
        $cart =  $cart->findOrCreate($request->user_id);
        $product = Product::find($request->product_id);
        $cartproduct = CartProduct::where('cart_id', $cart->id)
        ->where('product_id', $product->id)
        ->first();
        if($product->quantity>0){
            if($cartproduct==null){
            
                CartProduct::create([
                    'user_id'=>$request->user_id,
                    'cart_id'=>$cart->id,
                    'product_id'=>$request->product_id,
                    'product_name'=>$product->name,
                    'product_price'=>$product->price*$product->sale_percent,
                    'quantity'=>1
        
                ]);
                
                return 1;
            }else{  
                $quantity = $cartproduct->quantity + 1; 
                
                $cartproduct->update([
                    'quantity'=>$quantity
                ]);
                return 1;
            }
        }else{
            return 0;
        }
    }
    public function MinMaxPriceAjax(){
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');
        $data = [$minPrice,$maxPrice];
        return $data;
    }
    public function getProductByPrice(Request $request){
        $minPrice = str_replace(['.', 'đ'], '', $request->minamount);
        $maxPrice =  str_replace(['.', 'đ'], '', $request->maxamount);
        $images = ProductImage::where('image_type',0)->get();
        $products = Product::whereBetween('price', [$minPrice, $maxPrice])
        ->orderBy('price', 'desc')
        ->paginate(9);
        return view('client.product.pagginate-list', compact('products','images'))->render();
        // return $products;
    }
    public function cartQuantity(){
        try{
            $cartproduct = CartProduct::where('user_id',Auth::user()->id)->get(); 
            $quantity = $cartproduct->count();
            return $quantity;
        }catch(\Exception $e){
            return 0;
        }
        
    }
}