<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
   
    protected $view_path='admin.brand.';
    protected $route_path='brand';
    protected $upload_path='img/brand';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return view($this->view_path.'index',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->view_path.'create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:brands,email',
                'phone' => 'required|string|max:15|regex:/^[0-9\-\(\)\/\+\s]*$/',
                'address' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        
            // Define the custom error messages
            $messages = [
                'name.required' => 'Tên là bắt buộc',
                'name.string' => 'Tên phải là kiểu chuỗi',
                'name.max' => 'Tên không được vượt quá 255 ký tự',
        
                'email.required' => 'Email là bắt buộc',
                'email.email' => 'Email phải là một địa chỉ email hợp lệ',
                'email.max' => 'Email không được vượt quá 255 ký tự',
                'email.unique' => 'Email đã tồn tại',
        
                'phone.required' => 'Số điện thoại là bắt buộc',
                'phone.string' => 'Số điện thoại phải là kiểu chuỗi',
                'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự',
                'phone.regex' => 'Số điện thoại không hợp lệ',
        
                'address.required' => 'Địa chỉ là bắt buộc',
                'address.string' => 'Địa chỉ phải là kiểu chuỗi',
                'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',
        
                'image.required' => 'Ảnh là bắt buộc',
                'image.image' => 'Ảnh phải là file ảnh',
                'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif',
                'image.max' => 'Ảnh không được vượt quá 2MB',
            ];
    
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $messages);
    
            // If validation fails, return back with errors
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            // Upload image
            $image = $request->file('image');
            $imageName = time(). '_brand.' . $image->getClientOriginalExtension(); 
            $request->image->move(public_path($this->upload_path), $imageName);
            $url =$this->upload_path.'/'.$imageName;
           
    
            // Create new Brand
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->email = $request->email;
            $brand->phone = $request->phone;
            $brand->address = $request->address;
            $brand->image = $url; // Lưu tên file vào cơ sở dữ liệu
            $brand->save();
            return redirect()->back()->with('success', 'Thêm thành công');
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
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
        $brand = Brand::find($id);
        return view($this->view_path.'edit',compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:15|regex:/^[0-9\-\(\)\/\+\s]*$/',
                'address' => 'required|string|max:255',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
        
            //Define the custom error messages
            $messages = [
                'name.required' => 'Tên là bắt buộc',
                'name.string' => 'Tên phải là kiểu chuỗi',
                'name.max' => 'Tên không được vượt quá 255 ký tự',
        
                'email.required' => 'Email là bắt buộc',
                'email.email' => 'Email phải là một địa chỉ email hợp lệ',
                'email.max' => 'Email không được vượt quá 255 ký tự',
                'email.unique' => 'Email đã tồn tại',
        
                'phone.required' => 'Số điện thoại là bắt buộc',
                'phone.string' => 'Số điện thoại phải là kiểu chuỗi',
                'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự',
                'phone.regex' => 'Số điện thoại không hợp lệ',
        
                'address.required' => 'Địa chỉ là bắt buộc',
                'address.string' => 'Địa chỉ phải là kiểu chuỗi',
                'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',
        
                'image.required' => 'Ảnh là bắt buộc',
                'image.image' => 'Ảnh phải là file ảnh',
                'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif',
                'image.max' => 'Ảnh không được vượt quá 2MB',
            ];

            // Validate the request
            $validator = Validator::make($request->all(), $rules, $messages);

            // If validation fails, return back with errors
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $brand = Brand::find($id);
            if($request->hasFile('image')){
                unlink($brand->image);
                $image = $request->file('image');
                $imageName = time(). '_brand.' . $image->getClientOriginalExtension(); 
                $request->image->move(public_path($this->upload_path), $imageName);
                $url =$this->upload_path.'/'.$imageName;

            }
            $brand->update([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'address'=>$request->address,
                'image'=> $url
            ]);
            return redirect()->route($this->route_path)->with('success', 'Cập nhật thành công');
        }catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try{
            $brand = Brand::find($id);
            if($brand->image!=null){
                unlink($brand->image);
            }
            
            $brand->delete();
            return redirect()->back()->with('success','Đã xóa thành công');
        }catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.');
        }

    }
}
