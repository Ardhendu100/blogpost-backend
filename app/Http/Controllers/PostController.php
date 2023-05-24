<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
class PostController extends Controller
{
    public function add_post(Request $req,$id){
        $category_id=Category::find($id)->id;
      
        $validation=Validator::make($req->all(),[
            'title'=>'required',
            'description'=>'required',
            'user_id'=>'required',
            'image'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        
        ]);
        if($validation->fails()){
            return response()->json($validation->errors(),202);
        }
        else{
            $post=Post::create([ 
                'title'=>$req->title,  
                'description' => $req->description,
                'image'=>$req->file('image')->store('postImages'),
                'user_id'=>$req->user_id, 
                'category_id'=>$category_id,

            ]);
            $post->save();
            return $post;
          
        }
    }
// show post
    public function show_post($id){
       
            $post=Category::find($id)->post;
           
            if(count($post)>=1){
            return $post;
        }
        else{
            return response()->json(["error"=>"Nothing is posted yet"],203);
        }
        
    }
    public function show_all_post(){
       
        $post=Post::all();
        if(count($post)>=1){
        return $post;
    }
    else{
        return response()->json(["error"=>"Nothing is posted yet"],203);
    }
    
}


public function show_post_details($id){
    // $post_details=Post::with('user')->find($id);
    // $post_details=Post::with('user','comment.user')->find($id);
    $post_details=Post::with('user')->find($id);
    $post_comment=Post::with('comment.user')->find($id);
    // $user=Post::find($id)->user;
    // $comment=Post::find($id)->comment;
    
    // $user_id=$post_details->user_id;
    // $user_name=User::find($user_id)->name;
    // $user_id=User::find($user_id)->id;
    // return response()->json(["post_details"=>$post_details,"userName"=>$user_name,"user_id"=>$user_id],200);
    // return response()->json(["post_details"=>$post_details,"user"=>$user,"comment"=>$comment],200);
    return response()->json(["post_details"=>$post_details,"comment_details"=>$post_comment]);
}



   // Delete
   public function delete_post($id){
    $result=Post::find($id);
    $result->comment()->delete();
    $result->delete();
    return response()->json(["sucess"=>"post has been deleted Sucessfully"],200);

   } 

   // update Post
   public function update_post(Request $req,$id){
       $update_post=Post::find($id);
      
        $update_post->title=$req->input('title');
    
       
       $update_post->user_id=$req->input('user_id');
       $update_post->description=$req->input('description');
       if($req->file('image')){
        $update_post->image=$req->file('image')->store('Post/Images');
       }
       $update_post->save();
       return $update_post;
   }

}
