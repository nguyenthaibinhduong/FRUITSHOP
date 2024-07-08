<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    protected $view_path='admin.category.';
    protected $route_path='category';
    protected $upload_path='img/category';
    private $category;
    public function __construct(Category $category)
    {
        $this->category=$category;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $category = $recusive->RecusiveCategory();
        return view($this->view_path.'index',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $option= $this->getcategory($parent_id='');
        return view($this->view_path.'create',compact('option'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $rules = [
                'name' => 'required|string|max:255',
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
            // Upload image
            $image = $request->file('image');
            $imageName = time(). '_category.' . $image->getClientOriginalExtension(); 
            $request->image->move(public_path($this->upload_path), $imageName);
            $url =$this->upload_path.'/'.$imageName;
            $category= new Category();
            $category->name = $request->name;
            $category->parent_id = $request->parent_id;
            $category->image = $url;
            $category->save();
            return redirect()->back()->with('success','Thêm thành công');
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
        $category = Category::find($id);
        $option= $this->getcategory($category->parent_id);
        return view($this->view_path.'edit',compact('category','option'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{

       
            $rules = [
                'name' => 'required|string|max:255',
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
            $category = Category::find($id);
            if($request->hasFile('image')){
                unlink($category->image);
                $image = $request->file('image');
                $imageName = time(). '_category.' . $image->getClientOriginalExtension(); 
                $request->image->move(public_path($this->upload_path), $imageName);
                $url =$this->upload_path.'/'.$imageName;

            }else{
                $url = $category->image;
            }

            $category->update([
                'name'=>$request->name,
                'parent_id'=>$request->parent_id,
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
            $category = Category::find($id);
            unlink($category->image);
            $category->delete();
            return redirect()->back()->with('success','Đã xóa thành công');
        }catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.');
        }
    }
    public function getcategory($parent_id)
    {
        $data = $this->category->all();
        $recusive = new Recusive($data);
        $option = $recusive->categoryRecusive($parent_id);
        return $option;
    }
}
