<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request){
        if($request->commentable_type==1){
            $product = Product::find($request->commentable_id);
            $comment = new Comment(['body' => $request->body, 'user_id' => $request->user_id]);
            $product->comments()->save($comment);
            $comments = $product->comments;
        } 
        else{
            $post = Post::find($request->commentable_id);
            $comment = new Comment(['body' => $request->body, 'user_id' => $request->user_id]);
            $post->comments()->save($comment);
            $comments = $post->comments;
        } 
        return view('client.comment.index',compact('comments'));
    }
    public function update($id,Request $request){
        $comment= Comment::find($id);
        $comment->update([
            'body'=>$request->body
        ]);
        if($request->commentable_type==1){
            $product = Product::find($request->commentable_id);
            $comments = $product->comments;
        }else{
            $post = Post::find($request->commentable_id);
            $comments = $post->comments;
        } 
        return view('client.comment.index',compact('comments'));
    }
    public function delete($id){
        $comment= Comment::find($id);
        if($comment->commentable_type=='App\Models\Product'){
            $product = Product::find($comment->commentable_id);
            $comment->delete();
            $comments = $product->comments;
        }else{
            $post = Post::find($comment->commentable_id);
            $comment->delete();
            $comments = $post->comments;
        }
        return view('client.comment.index',compact('comments'));
    }
    
}
