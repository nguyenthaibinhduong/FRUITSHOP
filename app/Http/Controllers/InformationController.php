<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class InformationController extends Controller
{
    protected $view_path='client.user.';
    protected $route_path='information';
    protected $upload_path='img/user';
    public function __construct(){
        View::share('categories',Category::all());
        View::share('types',Type::all());
    }
    public function index(){
        $customer = User::find(Auth::user()->id);
        return view($this->view_path.'index',compact('customer'));
    }
    public function orders(){
        $orders = Order::where('user_id','=',Auth::user()->id)->get();
        return view($this->view_path.'orders',compact('orders'));
    }
    public function orderDetail($id){
        $order = Order::find($id);
        $order_detail = OrderDetail::where('order_id','=',$id)->get();
        return view($this->view_path.'detail-order',compact('order_detail','order'));
    }
    public function edit(){
        $customer = User::where('id','=',Auth::user()->id)->first();
        return view($this->view_path.'edit',compact('customer'));
    }
    public function update($id,Request $request){
       
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
            'address' => 'required|string|max:255',
            'birth_date' => 'date|before:' . Carbon::now()->subYears(15)->format('Y-m-d'),
            'image_url' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'birth_date.date' => 'Ngày sinh không hợp lệ.',
            'birth_date.before' => 'Bạn phải ít nhất 15 tuổi.',
            'image_url.image' => 'Ảnh đại diện phải là một tệp hình ảnh.',
            'image_url.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg, gif, hoặc svg.',
            'image_url.max' => 'Ảnh đại diện không được vượt quá 2048 KB.',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = new User;
        if($request->hasFile('image_url')){
            $imageName = time().'.'.$request->image_url->extension();  
            $request->image_url->move(public_path($this->upload_path), $imageName);
            $url =$this->upload_path.'/'.$imageName;
            $user->find($id)->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone_number'=>$request->phone_number,
                'address'=>$request->address,
                'gender'=>$request->gender,
                'birth_date'=>$request->birth_date,
                'image_url'=>$url
            ]);
        }else{
            $user->find($id)->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone_number'=>$request->phone_number,
                'address'=>$request->address,
                'gender'=>$request->gender,
                'birth_date'=>$request->birth_date
            ]);
        }  
        return redirect()->route($this->route_path);
    }
    public function newPassword(){
        return view('client.user.new-pass');
    }
    public function postPassword(Request $request){
        $rules = [
            'oldpassword'=> 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ];
        
        // Custom error messages
        $messages = [
            'required' => 'Bắt buộc nhập',
            'string' => 'Phải là kiểu kí tự',
            'min' => 'Mật khẩu phải nhiều hơn 8 kí tự',
            'confirmed'=>"Mật khẩu không khớp"    
        ];
        
        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);
         
        // If validation fails, return back with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if ($request->oldpassword != $request->password) {
            
            if(Auth::attempt(['email' => $request->email, 'password' =>$request->oldpassword])){
                $user = User::where('email', $request->email)->first();
                $user->password = Hash::make($request->password);
                $user->save();
                Auth::logout();
                return redirect()->route('login')->with('success','Cập nhật mật khẩu mới thành công. Hãy đăng nhập lại');
            }else{
                return redirect()->back()->with('danger','Xác thực không đúng vui lòng thử lại');
            }
        }else{
            return redirect()->back()->with('danger','Mật khẩu mới phải khác mật khẩu cũ');
        }
        
    }
}