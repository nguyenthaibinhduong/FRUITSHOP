<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $view_path='admin.order.';
    protected $route_path='order';

    public function index(){
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view($this->view_path.'index',compact('orders'));
    }
    public function detail($id){
        $status = OrderStatus::all();
        $order = Order::find($id);
        $order_detail = OrderDetail::where('order_id','=',$id)->get();
        return view($this->view_path.'detail',compact('order','order_detail','status'));
    }
    public function updateStatus($id,Request $request){
        try{
            Order::find($id)->update([
                'status'=>$request->status
            ]);
            return redirect()->route($this->route_path)->with('success','Cập nhật thành công');;
        }catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
        }
    }
}