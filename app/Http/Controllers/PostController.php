<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DateTime;

class PostController extends Controller
{
    protected $view_path='admin.post.';
    protected $route_path='post';
    protected $upload_path='img/post';
    protected $type;
    /**
     * Display a listing of the resource.
     */
    public function __construct(Type $type)
    {
        $this->type= $type;

    }
    public function showComment($id){
        $post = Post::find($id);
        $comments = $post->comments()->orderBy('created_at', 'desc')->paginate(5);
        return view('admin.post.comment',compact('comments'));
    }
    public function deleteComment($id){
        try{
        Comment::find($id)->delete();
         return redirect()->back()->with('success','Xóa thành công');
        } catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.')->withInput();
        }
    }
    public function getCategories($parent_id)
   {
       $data = $this->type->all();
       $recusive = new Recusive($data);
       $option = $recusive->typeRecusive($parent_id);
       return $option;
   }
    public function index()
    {
        $types = Type::all();
        $selected_types = DB::table('post_types')->get();
        $posts = Post::all();
        return view($this->view_path.'index',compact('posts','selected_types','types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $option= $this->getCategories($parent_id='');
        return view($this->view_path.'create',compact('option'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $rules = [
                'author'=>'required|string|max:30',
                'title' => 'required|string|max:255',
                'subtitle' => 'required|string|max:255',
                'type_id' => 'required',
                'content' => 'required|string|min:50',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
            
            // Custom error messages
            $messages = [
                'required' => 'Bắt buộc nhập',
                'string' => 'Phải là kiểu kí tự',
                'numeric' => 'Phải là kiểu số',
                'integer' => 'Phải là số nguyên',
                'min' => 'Dữ liệu quá nhỏ',
                'max' => 'Dữ liệu vượt quá cho phép',
                'image' => 'Phải là file ảnh',
                'mimes' => 'Định dạng không hợp lệ',
            ];
    
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $messages);
    
            // If validation fails, return back with errors
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            if ($request->hasFile('image')){
                $imageName = time().'.'.$request->image->extension();  
                $request->image->move(public_path($this->upload_path), $imageName);
                $url =$this->upload_path.'/'.$imageName;
            }

          
            $date_public = ($request->uploaded==1)?(new DateTime()):null;
            $post = new Post();
            $post->author = $request->author;
            $post->title = $request->title;
            $post->subtitle = $request->subtitle;
            $post->content = $request->content;
            $post->image = $url;
            $post->uploaded = $request->uploaded;
            $post->user_id = Auth::user()->id;
            $post->public_date =  $date_public;
            $post->save();
           
            foreach($request->type_id as $id){
                $post->types()->attach($id);
            }
            
            
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
        $selected_types = DB::table('post_types')
        ->where('post_id',$id)
        ->pluck('type_id')
        ->toArray();
        $types = Type::all();
        $post = Post::find($id);
        return view($this->view_path.'edit',compact('post','selected_types','types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{

            
            $rules = [
                'author'=>'required|string|max:30',
                'title' => 'required|string|max:255',
                'subtitle' => 'required|string|max:255',
                'type_id' => 'required',
                'content' => 'required|string|min:50',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ];
            
            // Custom error messages
            $messages = [
                'required' => 'Bắt buộc nhập',
                'string' => 'Phải là kiểu kí tự',
                'numeric' => 'Phải là kiểu số',
                'integer' => 'Phải là số nguyên',
                'min' => 'Dữ liệu quá nhỏ',
                'max' => 'Dữ liệu vượt quá cho phép',
                'image' => 'Phải là file ảnh',
                'mimes' => 'Định dạng không hợp lệ',
            ];
            // Validate the request
            $validator = Validator::make($request->all(), $rules, $messages);

            // If validation fails, return back with errors
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            $post = Post::find($id);

            if($request->hasFile('image')){
                $imageName = time().'.'.$request->image->extension();  
                $request->image->move(public_path($this->upload_path), $imageName);
                $url =$this->upload_path.'/'.$imageName;
            }else{
                $url = $post->image;
            }
            DB::table('post_types')->where('post_id', $id)->delete();
            foreach($request->type_id as $type_id){
                $post->types()->attach($type_id);
            }
            
            if($post->uploaded==0 && $request->uploaded==1){
                $public_date = new DateTime();
            }
            else if($post->uploaded==1 && $request->uploaded==0){
                $public_date = null;
            }
            else{
                $public_date = $post->public_date;
            }
            $post->update([
                'author'=>$request->author,
                'title'=>$request->title,
                'subtitle'=>$request->subtitle,
                'content'=>$request->content,
                'user_id'=>Auth::user()->id,
                'image'=>$url,
                'public_date'=>$public_date,
                'uploaded'=>$request->uploaded,
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
            $post = Post::find($id);
            unlink($post->image);
            $post->delete();
            return redirect()->back()->with('success','Đã xóa thành công');
        }catch (\Exception $e) {
            // Handle other exceptions
            return back()->with('danger','Đã xảy ra lỗi. Vui lòng thử lại.');
        }

    }
}