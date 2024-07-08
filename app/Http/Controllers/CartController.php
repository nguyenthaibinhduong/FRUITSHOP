<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmOrderEmail;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Mail as ModelsMail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class CartController extends Controller
{
    protected $cart;
    protected $product;
    protected $cartProduct;
    protected $subtotal;
    public function __construct(Product $product, Cart $cart, CartProduct $cartProduct)
    {
        $this->product = $product;
        $this->cart = $cart;
        $this->cartProduct = $cartProduct;
        View::share('types',Type::all());
        View::share('categories',Category::all());
    }
    public function index(){
        $cart = $this->cart->findOrCreate(auth()->user()->id);
        $cartproduct = $this->cartProduct->where('cart_id','=',$cart->id)->get();
        $this->subtotal = 0;
        $images = ProductImage::where('image_type',0)->get();
        foreach ($cartproduct as $cart){
            $this->subtotal += ($cart->product_price*$cart->quantity);
       }

       if(session()->has('couponpercent')){
            $subtotal=$this->subtotal * session('couponpercent');
       }else if(session()->has('couponvalue')){
            $subtotal=$this->subtotal - session('couponvalue');
       }else{
            $subtotal=$this->subtotal;
       }
       $oldtotal = $this->subtotal ; 
       session(['discount' => $oldtotal-$subtotal ]);
        return view('client.cart.index',compact('cartproduct','subtotal','images','oldtotal'));
    }
    public function store(Request $request){
        $cart = $this->cart->findOrCreate(auth()->user()->id);
        $product = $this->product->find($request->id);
        $cartproduct = $this->cartProduct->where('cart_id', $cart->id)
        ->where('product_id', $product->id)
        ->first();
        if($product->quantity>0){
            if($cartproduct==null){
            
                $this->cartProduct->create([
                    'user_id'=>auth()->user()->id,
                    'cart_id'=>$cart->id,
                    'product_id'=>$request->id,
                    'product_name'=>$product->name,
                    'product_price'=>$product->price*$product->sale_percent,
                    'quantity'=>$request->quantity
        
                ]);
                session()->flash('message',1);
                return redirect()->route('cart');
            }else{  
                $quantity = $cartproduct->quantity + $request->quantity; 
                
                $cartproduct->update([
                    'quantity'=>$quantity
                ]);
                session()->flash('message',1);
                return redirect()->back();
            }
        }else{
            session()->flash('message',0);
            return redirect()->back();
        }
    }
    public function update(Request $request){
        $cart = $this->cart->findOrCreate(auth()->user()->id);
        $count = count($request->product_id);
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        for($i=0;$i < $count;$i++){
            CartProduct::where('cart_id', $cart->id)->where('product_id',$product_id[$i])->update([
                        'quantity'=> $quantity[$i]
            ]);
        }
        
        return redirect()->route('cart');
    }
    public function delete($id){
        $cart = $this->cart->findOrCreate(auth()->user()->id);
        $this->cartProduct->where('cart_id','=',$cart->id)->where('product_id','=',$id)->forceDelete();
        return redirect()->route('cart');
    }
    public function applyCoupon(Request $request){
        
        $code = $request->coupon;
        $coupon =  Coupon::where('name',$code)->first();
        
        if($coupon!=null){
            if (!Carbon::now()->gt($coupon->expiration_date)) {
                
                if($coupon->type==1){

                    $value =1-($coupon->value/100);
                    if($value==0){
                        session(['couponpercent' =>  0 ]);
                        session(['coupon' => $coupon->name ]);
                    }else{
                        session(['couponpercent' =>  $value ]); 
                        session(['coupon' => $coupon->name ]);
                    }
                    
                    $message = 'Áp Mã giảm giá thành công !';
                }
                else if($coupon->type==0){
                    $value = $coupon->value;
                    
                    session(['couponvalue' => $value ]);
                    session(['coupon' => $coupon->name ]);
                    $message = 'Áp Mã giảm giá thành công !';
                }
            }else{
                $message = 'Mã giảm giá không tồn tại hoặc hết hạn!';
            }
           
        }else{
            $message = 'Mã giảm giá không tồn tại hoặc hết hạn!';
        }
        return redirect()->back()->with([
            'message' => $message
        ]);
;
    }
    public function removeCoupon(){
        if( session()->has('couponpercent')){
                session()->forget('couponpercent');
                session(['coupon' => '' ]);
                session(['discount' => 0 ]);

        }else if(session()->has('couponvalue')){
                session()->forget('couponvalue');
                session(['coupon' => '' ]);
                session(['discount' => 0 ]);
        }
        return redirect()->back();
    }
    public function checkout(){
        $cart = $this->cart->findOrCreate(auth()->user()->id);
        $cart_id =$cart->id;
        $cartproduct = $this->cartProduct->where('cart_id','=',$cart->id)->get();
        $this->subtotal = 0;
        $images = ProductImage::where('image_type',0)->get();
        foreach ($cartproduct as $cart){
            $this->subtotal += ($cart->product_price*$cart->quantity);
       }
        if(session()->has('couponpercent')){
            $subtotal=$this->subtotal * session('couponpercent');
        }else if(session()->has('couponvalue')){
            $subtotal=$this->subtotal - session('couponvalue');
        }else{
            $subtotal=$this->subtotal;
        }
        $oldtotal = $this->subtotal ; 
        session(['discount' => $oldtotal-$subtotal ]);
        $customer = User::where('id',auth()->user()->id)->first();
        return view('client.cart.checkout',compact('cart_id','customer','cartproduct','subtotal','oldtotal'));
    }
    public function createOrder(Request $request){
        //dd($request->all());
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
            'address' => 'required|string|max:255',
        ];
        
        // Custom error messages
        $messages = [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.string' => 'Tên phải là một chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'email.required' => 'Trường email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'phone_number.required' => 'Trường số điện thoại là bắt buộc.',
            'phone_number.regex' => 'Số điện thoại không hợp lệ.',
            'phone_number.min' => 'Số điện thoại phải có ít nhất 10 ký tự.',
            'phone_number.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'address.required' => 'Trường địa chỉ là bắt buộc.',
            'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $type_payment=$request->payment_method;
        $order = new Order;
        $order->order_code = $this->generateOrderCode();
        $order->user_id = auth()->user()->id;
        $order->customer_name=$request->name;
        $order->customer_email=$request->email;
        $order->customer_tel=$request->phone_number;
        $order->customer_address=$request->address;
        $order->total_price=$request->subtotal;
        $order->total=$request->total;
        $order->discount=$request->discount;
        $order->payment_method= $request->payment_method;
        $order->status=($request->payment_method!=1)?9:1;
        $order->save();
      
        $cartproduct = $this->cartProduct->where('cart_id','=',$request->cart_id)->get();
        foreach ($cartproduct as $cart){
            $order_detail = new OrderDetail();
            $order_detail->order_id = $order->id;
            $order_detail->product_id= $cart->product_id;
            $order_detail->product_name= $cart->product_name;
            $order_detail->product_price= $cart->product_price;
            $order_detail->quantity = $cart->quantity;
            $order_detail->price = $cart->quantity*$cart->product_price;
            $order_detail->save();
        }
        $this->cartProduct->where('cart_id','=',$request->cart_id)->forceDelete();
        $this->cart->where('id',$request->cart_id)->forceDelete();
        if( session()->has('couponpercent')){
            session()->forget('couponpercent');
            session(['coupon' => '' ]);
            session(['discount' => 0 ]);

        }else if(session()->has('couponvalue')){
            session()->forget('couponvalue');
            session(['coupon' => '' ]);
            session(['discount' => 0 ]);
        }
        $order_detail= OrderDetail::where('order_id',$order->id)->get();
        $view_mail= View::make('client.mail.order-detail', compact('order','order_detail'))->render();
        //dd($order->id);
        if( Mail::mailer('smtp')
        ->to($order->customer_email)
        ->send(new ConfirmOrderEmail($order->id))){
            ModelsMail::create([
                'type'=>0,
                'subject'=>'Đơn hàng #'.$order->order_code,
                'body'=>$view_mail,
                'sender_email'=>'natteam1998@gmail',
                'recipient_email'=>$order->customer_email,
                ]);
        }
        if($type_payment==1){
           return redirect()->route('orders.detail',['id'=>$order->id]); 
        }else{
            return redirect()->route('payment',['code'=>$order->order_code]);
        }
        
    }
       
    
    


    private function generateOrderCode()
    {
        do {
            $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (Order::where('order_code', $code)->exists());

        return $code;
    }
}
