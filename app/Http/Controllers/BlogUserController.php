<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\WelcomeMail;
use App\Models\User;


class BlogUserController extends Controller
{
    function registration(Request $req){
        $validation=Validator::make($req->all(),[
            'name'=>'required',
            'email'=>'required|email|',
            'password'=>'required',
            'avatar'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        
        ]);
        $isValid = User::where('email', '=',$req->email)->first();
        if($validation->fails()){
            return response()->json($validation->errors(),202);
        }
       else if($isValid!==null){
           return response("That email address is already registered. Are you sure you don't have an account?");
       }
        else{
            $user=User::create([
                'name'=>$req->name,  
                'email' => $req->email,
                'password' => bcrypt($req->password),
                'avatar'=>$req->file('avatar')->store('allAvtar'),
                'role'=>0,
            ]);
            // Mail::to($req['email'])->send(new WelcomeMail($user));
        
            
    

return response()->json(["user"=>$user,"message"=>"Account Created Sucessfully"],200);
        }
    }

    public function login(Request $req){
        if(Auth::attempt([
            'email'=>$req->email,
            'password'=>$req->password,
        ])){
            $user=Auth::user();
           
            $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken,"message"=>"Sucesfully Logged in ","status"=>200]);

        }
        else{
            return response()->json(['error'=>'Unauthorised Acess'],203);
        }
    }
   public function logout(Request $req){
       $token=$req->user()->token();
       $token->revoke();
       $response=["message"=>"Sucesfully Logged out"];
       return response($response,200);
   }

public function update_password(Request $req,$id){
  
    $update_user=User::find($id);
    // $update_user->name=$req->input('name');
  
    $update_user->password=bcrypt($req->input('password'));
    
           $update_user->save();
    return $update_user;

}


public function update(Request $req,$id){
  
    $update_user=User::find($id);
    // $update_user->name=$req->input('name');
  
    $update_user->password=bcrypt($req->input('password'));
    if($req->file('avatar')){
        $update_user->avatar=$req->file('avatar')->store('allAvtar');
           }
           $update_user->save();
    return $update_user;

}

public function update_profile(Request $req,$id){
    $update_profile=User::find($id);
    if($req->file('avatar')){
        $update_profile->avatar=$req->file('avatar')->store('allAvtar');
           }
           $update_profile->save();
    return $update_profile;
}


public function getCategory($id){
return User::with('category')->find($id);
}
  public function show_user_details($id){
      return User::find($id);
  }
  public function check_user(){
      
    if (Auth::check()) {
        return "ok";
    }
    else{
        return "No";
    }
}
}
