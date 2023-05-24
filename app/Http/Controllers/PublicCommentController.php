<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\PublicComment;
use Illuminate\Http\Request;

class PublicCommentController extends Controller
{
    public function add_comment(Request $req,$id){

        $post=Post::find($id);
        
        
        $validation=Validator::make($req->all(),[
          'text'=>'required',
        
        ]);
        if($validation->fails()){
          return response()->json($validation->errors(),202);
        }
        else{
          $comment=PublicComment::create([
            'text'=>$req->text,
            'user_id'=>$req->user_id,  
            'name'=>$req->name,
            'email'=>$req->email,
            'avatar'=>$req->file('avatar')->store('allAvtar'),
            'post_id'=>$post->id,
        ]);
        
        $comment->save();
        }
       
        return response()->json(["comment"=>$comment,"message"=>"Comment posted sucessfully"],200);
}
public function show_all_comment($id){
    $comment=Post::find($id)->comment;
    
    if(count($comment)>=1){
      return $comment;
    }
    else{
     return response()->json(["error"=>"No Comment is posted yet"],203);
    }
  } 

  public function update_comment(Request $req,$id){
    $update_comment=PublicComment::find($id);
    $update_comment->text=$req->input('text');

    $update_comment->save();
    return $update_comment;
   }
  
}
