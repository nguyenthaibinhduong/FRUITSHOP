<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    protected $view_path = 'admin.coupon.';
    protected $route_path = 'coupon';
    private $coupon;
    public function index()
    {
        $coupons = Coupon::all();
        return view($this->view_path . 'index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view_path . 'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string|min:5|max:200',
                'type' => 'required',
                'value' => 'required|numeric|min:0',
                'expiration_date' => 'required|date|after:today',
            ];

            // Custom error messages
            $messages = [
                'required' => 'Bắt buộc nhập',
                'string' => 'Phải là kiểu kí tự',
                'numeric' => 'Phải là kiểu số',
                'min' => 'Giá trị quá nhỏ',
                'max' => 'Giá trị vượt quá cho phép',
                'after' => 'Ngày hết hạn phải sau hôm nay'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            // If validation fails, return back with errors
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            Coupon::create($request->all());
            return redirect()->back()->with('success', 'Thêm thành công');
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger', 'Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::find($id);
        return view($this->view_path . 'edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $rules = [
                'name' => 'required|string|min:5|max:200',
                'type' => 'required',
                'value' => 'required|numeric|min:0',
                'expiration_date' => 'required|date|after:today',
            ];

            // Custom error messages
            $messages = [
                'required' => 'Bắt buộc nhập',
                'string' => 'Phải là kiểu kí tự',
                'numeric' => 'Phải là kiểu số',
                'min' => 'Giá trị quá nhỏ',
                'max' => 'Giá trị vượt quá cho phép',
                'after' => 'Ngày hết hạn phải sau hôm nay'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            // If validation fails, return back with errors
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            Coupon::find($id)->update($request->all());
            return redirect()->route($this->route_path)->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger', 'Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
            Coupon::find($id)->delete();
            return redirect()->route($this->route_path)->with('success', 'Xóa thành công');
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger', 'Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
        }
    }

}