<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Mail as ModelsMail;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class ShopController extends Controller
{
   private 
   $product,
   $all_products,
   $sale_products,
   $brand,
   $banner,
   $productImage,
   $post
   ;

   public function __construct(Product $product, Brand $brand, Banner $banner, ProductImage $productImage,Post $post)
   {
      $this->product = $product->where('uploaded',1);
      $this->all_products = $product->where('uploaded',1)->paginate(9);
      $this->sale_products = $product->where('uploaded',1)->where('sale_percent','<>',1)->paginate(15);
      $this->banner = $banner->where('uploaded',1)->get();
      $this->productImage = $productImage->where('image_type',0)->get();
      $this->brand = $brand->all();
      View::share('categories',Category::all());
      $this->post = $post->where('uploaded',1) ;
      View::share('types',Type::all());
   }
   public function index(){
      
      $banners = $this->banner;
      $brands = $this->brand;
      $images = $this->productImage;
      $sale_products = $this->sale_products;
      $non_sale_products = $this->product->where('sale_percent',1)->get();
      $products = $this->all_products; 
      $posts = $this->post->paginate(3);
      return view('client.home',compact('brands','banners','sale_products','non_sale_products','images','products','posts'));
  }
   public function contact(){
   return view('client.contact');   
   }
   public function postcontact(Request $request){

      $admin_mail='natteam1998@gmail.com';
      $name=$request->name;
      $email=$request->email;
      $content=$request->content;
      $view_mail= View::make('client.mail.contact', compact('name', 'email', 'content'))->render();
      if(Mail::mailer('smtp')
      ->to($admin_mail)
      ->send(new ContactMail($name, $email, $content))){
         ModelsMail::create([
         'type'=>1,
         'subject'=>'Mail liên hệ từ khách hàng '.$name,
         'body'=>$view_mail,
         'sender_email'=>$email,
         'recipient_email'=>$admin_mail
         ]);
      }
      
      return redirect()->route('contact')->with('success', "Đã gửi mail"); 
   }
   public function product(){
      $minPrice = Product::min('price');
      $maxPrice = Product::max('price');
      $images = $this->productImage;
      $sale_products = $this->sale_products;
      $products = $this->all_products; 
      $brands = $this->brand;
      return view('client.shop',compact('sale_products','images','products','brands'));
   }
   
   public function getProductByCategory($id){
      $products = Product::whereHas('categories', function ($query) use ($id) {
         $query->where('category_id', $id);
     })
     ->where('uploaded',1)
     ->paginate(9);
      $images = $this->productImage;
      $brands = $this->brand;
      if(count($products)){
         return view('client.shop',compact('images','products','brands'));
      }else{
         return redirect()->route('404');
      }
      
   }
   public function getProductByBrand($id){
      $products = Product::whereHas('brand', function ($query) use ($id) {
         $query->where('id', $id);
     })
     ->where('uploaded',1)
     ->paginate(9);;
      $images = $this->productImage;
      $brands = $this->brand;
      if($products!=null){
         return view('client.shop',compact('images','products','brands'));
      }else{
         return redirect()->route('404');
      }
      
   }
   public function getProductByName(Request $request){
      $products = $this->product->where('name','like','%'.$request->key.'%')->paginate(9)->withQueryString();
      $images = $this->productImage;     
      $brands = $this->brand;
      if($products!=null){
         return view('client.shop',compact('images','products','brands'));
      }else{
         return redirect()->route('404');
      };

      
   }
   public function getProductDetail($id){
      $image = ProductImage::where('product_id',$id)
      ->where('image_type',0)
      ->first();
      $thumps = ProductImage::where('product_id',$id)
      ->where('image_type',1)
      ->get();
      $product = $this->product->find($id);
      $comments = $product->comments;
      
      if($product!=null){
         return view('client.product-detail',compact('product','image','thumps','comments'));
      }else{
         return redirect()->route('404');
      }
      

   }
   public function post(){
      $posts =  $this->post->paginate(4); 
      return view('client.blog',compact('posts'));
   }
   public function getPostByType($id){
      $posts = Post::whereHas('types', function ($query) use ($id) {
         $query->where('type_id', $id);
     })
     ->where('uploaded',1)
     ->paginate(4);
      return view('client.blog',compact('posts'));
   }
   public function getPostByTitle(Request $request){
      $posts = $this->post->where('title','like','%'.$request->key.'%')->paginate(4)->withQueryString();
      return view('client.blog',compact('posts'));
   }
   public function getPostById($id){ 
      $posts = $this->post->where('id','<>',$id)->get();
      $blog = Post::where('uploaded',1)->find($id); 
      $comments = $blog->comments; 
      return view('client.blog-detail',compact('blog','posts','comments'));
   }
}