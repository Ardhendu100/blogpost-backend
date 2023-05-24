<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Comments;
use App\Models\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Token;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Json;

class CommentsController extends Controller
{
  public function add_comment(Request $req,$id){

$post=Post::find($id);


$validation=Validator::make($req->all(),[
  'text'=>'required',
  'user_id'=>'required',

]);
if($validation->fails()){
  return response()->json($validation->errors(),202);
}
else{
  $comment=Comments::create([
    'text'=>$req->text,
    'user_id'=>$req->user_id,  
    'post_id'=>$post->id,
]);

$comment->save();
}
return $comment;

  }

 public function show_all_comment($id){
   $comment=Post::find($id)->comment;
   
//    if(count($comment)>=1){
//      return $comment;
//    }
//    else{
//     return response()->json(["error"=>"No Comment is posted yet"],203);
//    }
return $comment;
 } 

 public function show_specific_comment($id)
 {
   $comment=Comments::find($id);
   $user=User::find($comment->user_id);
   return response()->json(["comment"=>$comment,"user"=>$user]);
 }
 public function delete_comment($id){
   $comment=Comments::find($id);
   if(!$comment){
    return response()->json(["error"=>"you are not allowed to delete this comment"],203);
   }

    $result=Comments::where('id',$id)->delete();
    if($result){
      return ["result"=>"Comment has been deleted"];
  }

   
  
 }
 public function update_comment(Request $req,$id){
  $update_comment=Comments::find($id);
  $update_comment->text=$req->input('text');
  // if($req->file('image')){
  //  $update_comment->image=$req->file('image')->store('Comment/Images');
  // }
  $update_comment->save();
  return $update_comment;
 }
}
