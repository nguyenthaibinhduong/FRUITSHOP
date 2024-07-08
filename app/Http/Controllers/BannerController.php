<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    protected $view_path='admin.banner.';
    protected $route_path='banner';
    protected $upload_path='img/banner';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();
        return view($this->view_path.'index',compact('banners'));
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
                'title' => 'max:255',
                'sub_title' => 'max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
    
            // Custom error messages
            $messages = [
                'required' => 'Bắt buộc nhập',
                'string' => 'Phải là kiểu kí tự',
                'max' => 'Dữ liệu vượt quá cho phép',
                'image' => 'Phải là file ảnh',
                'mimes' => 'Đinh dạng không hợp lệ',
            ];
    
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $messages);
    
            // If validation fails, return back with errors
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            // Upload image
            $image = $request->file('image');
            $imageName = time(). '_banner.' . $image->getClientOriginalExtension(); 
            $request->image->move(public_path($this->upload_path), $imageName);
            $url =$this->upload_path.'/'.$imageName;
           
    
            // Create new Banner
            $banner = new Banner();
            $banner->name = $request->name;
            $banner->title = $request->title;
            $banner->sub_title = $request->sub_title;
            $banner->image = $url; // Lưu tên file vào cơ sở dữ liệu
            $banner->uploaded = $request->uploaded;
            $banner->save();
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
        $banner = Banner::find($id);
        return view($this->view_path.'edit',compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            
       
            $rules = [
                'name' => 'required|string|max:255',
                'title' => 'max:255',
                'sub_title' => 'max:255',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ];

            // Custom error messages
            $messages = [
                'required' => 'Bắt buộc nhập',
                'string' => 'Phải là kiểu kí tự',
                'max' => 'Dữ liệu vượt quá cho phép',
                'image' => 'Phải là file ảnh',
                'mimes' => 'Đinh dạng không hợp lệ',
            ];

            // Validate the request
            $validator = Validator::make($request->all(), $rules, $messages);

            // If validation fails, return back with errors
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $banner = Banner::find($id);
            if($request->hasFile('image')){
                unlink($banner->image);
                $image = $request->file('image');
                $imageName = time(). '_banner.' . $image->getClientOriginalExtension(); 
                $request->image->move(public_path($this->upload_path), $imageName);
                $url =$this->upload_path.'/'.$imageName;

            }else{
                $url = $banner->image;
            }

            $banner->update([
                'name'=>$request->name,
                'title'=>$request->title,
                'sub_title'=>$request->sub_title,
                'uploaded'=>$request->uploaded,
                'image'=>$url,
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
            $banner = Banner::find($id);
            unlink($banner->image);
            $banner->delete();
            return redirect()->back()->with('success','Đã xóa thành công');
        }catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.');
        }

    }
}
