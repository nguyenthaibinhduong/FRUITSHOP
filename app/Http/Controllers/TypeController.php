<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{
    protected $view_path='admin.type.';
    protected $route_path='type';
    private $type;
    public function __construct(Type $type)
    {
        $this->type=$type;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->type->all();
        $recusive = new Recusive($data);
        $type = $recusive->RecusiveType();
        return view($this->view_path.'index',compact('type'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $option= $this->gettype($parent_id='');
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
            $type= new Type();
            $type->name = $request->name;
            $type->parent_id = $request->parent_id;
            $type->save();
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
        $type = Type::find($id);
        $option= $this->gettype($type->parent_id);
        return view($this->view_path.'edit',compact('type','option'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{

       
            $rules = [
                'name' => 'required|string|max:255',
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
            $type = Type::find($id);

            $type->update([
                'name'=>$request->name,
                'parent_id'=>$request->parent_id,
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
            $type = Type::find($id)->delete();
            return redirect()->back()->with('success','Đã xóa thành công');
        }catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.');
        }
    }
    public function gettype($parent_id)
    {
        $data = $this->type->all();
        $recusive = new Recusive($data);
        $option = $recusive->typeRecusive($parent_id);
        return $option;
    }
}
