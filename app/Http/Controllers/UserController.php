<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Mail as ModelsMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        $roles = DB::table('users')
        ->join('role_user','users.id','=','role_user.user_id')
        ->join('roles','roles.id','=','role_user.role_id')->get()->toArray();
        return view('admin.user.index',compact('users','roles'));
    }
    public function create(){
        $roles = Role::all();
        return view('admin.user.create',compact('roles'));
    }
    public function store(Request $request){
        try{
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required' 
        ];
        
        // Custom error messages
        $messages = [
            'required' => 'Bắt buộc nhập',
            'string' => 'Phải là kiểu kí tự',
            'email'=>'Phải đúng định dạng email@xxxxx.com',
            'min' => 'Mật khẩu phải nhiều hơn 8 kí tự',
            'max' => 'Dữ liệu vượt quá cho phép',
            'confirmed'=>"Mật khẩu không khớp"    
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $request->merge(['password'=>Hash::make($request->password)]);
        // dd($request->all());
        $userCreate =User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password
        ]);
        $userCreate->roles()->attach($request->role);
        return redirect()->back()->with('success','Thêm tài khoản thành công');
    } catch (\Exception $e) {
        // Handle other exceptions
        return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
    }
    }
    public function edit($id){
        $roles = Role::all();
        $user = User::find($id);
        $getAllRolesOfUser = DB::table('role_user')->where('user_id',$id)->pluck('role_id');
        return view('admin.user.edit',compact('user','roles','getAllRolesOfUser'));
    }
    public function update($id,Request $request){
        try{
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255', 
        ];
        if($request->password!=null){
            $rules = array_merge($rules, [
                'password' => 'string|min:8|confirmed',
            ]);
        }
        // Custom error messages
        $messages = [
            'required' => 'Bắt buộc nhập',
            'string' => 'Phải là kiểu kí tự',
            'email'=>'Phải đúng định dạng email@xxxxx.com',
            'min' => 'Mật khẩu phải nhiều hơn 8 kí tự',
            'max' => 'Dữ liệu vượt quá cho phép' ,
            'confirmed'=>"Mật khẩu không khớp"  
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
       $user = User::find($id);
       if(!empty($request->password)){
            $request->merge(['password'=>Hash::make($request->password)]);
       }else{
            $request->merge(['password'=>$user->password]);
       }
       
       $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password
       ]);
       $user->roles()->detach();
       $user->roles()->attach($request->role);
        return redirect()->route('user')->with('success','Cập nhật tài khoản thành công');
    } catch (\Exception $e) {
        // Handle other exceptions
        return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
    }
    }
    public function delete($id){
        $user = User::find($id);
        Cart::where('user_id',$id)->delete();
        $user->delete();
        $user->roles()->detach();
       
        return redirect()->route('user');
    }
    public function login(){
        return view('auth.login');
    }
    public function loginadmin(){
        return view('auth.loginadmin');
    }
    public function register(){
        return view('auth.register');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('home');
    }
    public function post_register(Request $request){
         try{
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|',
            'password' => 'required|string|min:8|confirmed',
        ];
        
        // Custom error messages
        $messages = [
            'required' => 'Bắt buộc nhập',
            'string' => 'Phải là kiểu kí tự',
            'email'=>'Phải đúng định dạng email@xxxxx.com',
            'min' => 'Mật khẩu phải nhiều hơn 8 kí tự',
            'max' => 'Dữ liệu vượt quá cho phép',
            'confirmed'=>"Mật khẩu không khớp"    
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $request->merge(['password'=>Hash::make($request->password)]);
        User::create($request->all());
        $user = User::where('name', '=', $request->name)
        ->where('email', '=', $request->email)
        ->where('password', '=', $request->password)
        ->first();
        $userRole= Role::where('name','=','user')->first();
        DB::table('role_user')->insert([
            'user_id' => $user->id,
            'role_id' => $userRole->id,
            'created_at' => now(), 
            'updated_at' => now(), 
        ]);
        return redirect()->route('login')->with('success','Đăng ký thành công. Hãy đăng nhập tài khoản');
    } catch (\Exception $e) {
        // Handle other exceptions
        return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
    }
    }
    public function post_login(Request $request){
         try{
        $rules = [
            'email' => 'required|string|email|max:255|',
            'password' => 'required',
        ];
        
        // Custom error messages
        $messages = [
            'required' => 'Bắt buộc nhập',
            'string' => 'Phải là kiểu kí tự',
            'email'=>'Phải đúng định dạng email@xxxxx.com',
            'max' => 'Dữ liệu vượt quá cho phép',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if (Auth::attempt(['email' => $request->email, 'password' =>$request->password])) {
            return redirect()->route('home');
        }
         return redirect()->back()->with('danger','Email hoặc mật khẩu không đúng.');
    } catch (\Exception $e) {
        // Handle other exceptions
        return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
    }
    }
    public function post_loginadmin(Request $request){
          try{
        $rules = [
            'email' => 'required|string|email|max:255|',
            'password' => 'required',
        ];
        
        // Custom error messages
        $messages = [
            'required' => 'Bắt buộc nhập',
            'string' => 'Phải là kiểu kí tự',
            'email'=>'Phải đúng định dạng email@xxxxx.com',
            'max' => 'Dữ liệu vượt quá cho phép',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        if (Auth::attempt(['email' => $request->email, 'password' =>$request->password])) {
            return redirect()->route(config('app_define.admin_prefix'));
        }
         return redirect()->back()->with('danger','Email hoặc mật khẩu không đúng.');
    } catch (\Exception $e) {
        // Handle other exceptions
        return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
    }
    }
    public function forgotPassword(){
        return view('auth.forgot-password');
    } 
    public function resetPassword($token){
        return view('auth.reset-password',compact('token'));
    }
    public function confirmInformation(Request $request){
        try{
             
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255', 
            ];
            // Custom error messages
            $messages = [
                'required' => 'Bắt buộc nhập',
                'string' => 'Phải là kiểu kí tự',
                'email'=>'Phải đúng định dạng email@xxxxx.com',
                'min' => 'Mật khẩu phải nhiều hơn 8 kí tự',
                'max' => 'Dữ liệu vượt quá cho phép'   
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            // If validation fails, return back with errors
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
           $name = $request->name;
           $email = $request->email;
           $user = User::where('name',$name)->where('email',$email)->limit(1)->get();
          
           if($user->count()==1){
                $token = Str::random(60);
                DB::table('password_reset_tokens')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => now(),
                ]); 
                $view_mail=View::make('client.mail.forgot-pass',compact('name','email','token'))->render();
                if(Mail::mailer('smtp')
                ->to($email)
                ->send(new ResetPasswordMail($name,$email,$token))){
                    ModelsMail::create([
                    'type'=>0,
                    'subject'=>'Lấy lại mật khẩu khách hàng '.$name,
                    'body'=>$view_mail,
                    'sender_email'=>'natteam1998@gmail.com',
                    'recipient_email'=>$email
                    ]);
                    return redirect()->back()->with('success','Chúng tôi đã gửi Email để xác thực tài khoản. Hãy truy cập để lấy lại mật khẩu.');
                }else{
                    return redirect()->back()->with('danger','Gửi Mail lỗi chúng tôi sẽ liên hệ lại sau');
                }
                
           }else{
                return redirect()->back()->with('danger','Thông tin tài khoản không đúng vui lòng thử lại');
           }
        
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
        }
    }
    public function createPassword(Request $request){
        $rules = [
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
        $reset = DB::table('password_reset_tokens')->where('token',$request->token_reset)->first();
        if($reset){
            
            $user = User::where('email', $reset->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('login')->with('success','Cập nhật mật khẩu mới thành công. Hãy đăng nhập lại');
        }else{
            return redirect()->back()->with('danger','Xác thực không đúng vui lòng thử lại');
        }
        
    }
    
}