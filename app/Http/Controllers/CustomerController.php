<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    private $path_view= 'admin.customer.';
    private $route_path= 'customer';
    protected $upload_path='img/user';
    public function index(){
       
        // Lấy tất cả người dùng và các đơn hàng của họ
        $users = User::with('orders')->get();

        // Lặp qua từng người dùng để thêm thuộc tính đơn hàng gần nhất và tổng chi tiêu
        $users->each(function($user) {
            $user->latest_order_date = $user->orders->sortByDesc('created_at')->first()->created_at ?? null;
            $user->total = $user->orders->sum('total_price');
        });

        return view($this->path_view.'index', compact('users'));
    }
    public function detail($id){
        $user = User::find($id);
        $orders = Order::where('user_id','=',$id)->get();
        $total = $orders->sum('total_price');
        return view($this->path_view.'detail', compact('user','orders','total'));
    }
    public function edit($id){
        $user = User::find($id);
        return view($this->path_view.'edit',compact('user'));
    }
    public function update($id,Request $request){
        try{
           
            $rules = [
                'name' => 'required|string|max:255',
                'phone_number' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:15',
                'address' => 'string|max:255',
                'birth_date' => 'date|before:' . Carbon::now()->subYears(15)->format('Y-m-d'),
            ];
            
            // Custom error messages
            $messages = [
                'name.required' => 'Trường tên là bắt buộc.',
                'name.string' => 'Tên phải là một chuỗi ký tự.',
                'name.max' => 'Tên không được vượt quá 255 ký tự.',
                'phone_number.regex' => 'Số điện thoại không hợp lệ.',
                'phone_number.min' => 'Số điện thoại phải có ít nhất 10 ký tự.',
                'phone_number.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
                'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',
                'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
                'birth_date.date' => 'Ngày sinh không hợp lệ.',
                'birth_date.before' => 'Bạn phải ít nhất 15 tuổi.',
            ];
    
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $messages);
    
            // If validation fails, return back with errors
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            
            User::find($id)->update([
                'name'=>$request->name,
                'phone_number'=>$request->phone_number,
                'address'=>$request->address,
                'gender'=>$request->gender,
                'birth_date'=>$request->birth_date
            ]);
            return redirect()->route('customer')->with('success','Cập nhật thành công');
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
        }
    }
    public function delete($id){
        $user = User::find($id);
        Cart::where('user_id',$id)->delete();
        unlink($user->image_link);
        $user->delete();
        $user->roles()->detach();
        return redirect()->route($this->route_path);
    }
}