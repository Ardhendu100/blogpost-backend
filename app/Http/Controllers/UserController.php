<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Registration;
use Validator;
class UserController extends Controller
{
public function registration(Request $req){
$validation=Validator::make($req->all(),[
    'name'=>'required',
    'email'=>'required',
    'password'=>'required',
    'avtar'=>'required',
    'role'=>'required',

]);


if($validation->fails()){
    return response()->json($validation->errors(),202);
}

// $user=new Registration;
// $user->name=$req->input('name');
// $user->email=$req->input('email');
// $user->password=bcrypt($req->input('password'));
// $user->role=$req->input('role');
// $user->avtar=$req->file('avtar')->store('allAvtar');

// $user->save();
// $resArr=[];   //response array
// $token=$user->createToken('Token')->acessToken;
// return $user;
// return $user;
// $allData=$req->all();
// $allData['password']=bcrypt($allData['password']);


// $user=User::create($allData);
// $resArr=[];   //response array
// $resArr['token']=$user->createToken('api-application')->acessToken;
// $resArr['name']=$user->name;
// return response()->json($resArr,200);

$user=User::create([
    'name'=>$req->name,
    'email' => $req->email,
    'password' => bcrypt($req->password),
    'role'=> $req->role,
    'avtar'=>$req->file('avtar')->store('allAvtar')

]);
$token=$user->createToken('Token')->acessToken;
return $user;
// return response()->json(['token'=>$token],200);

    }
    public function login(Request $req){
        if(Auth::attempt([
            'email'=>$req->email,
            'password'=>$req->password,
        ])){
            $user=Auth::user();
            $resArr=[];   //response array
            $resArr['token']=$user->createToken('api-application')->acessToken;
            $resArr['name']=$user->name;
            return response()->json($resArr,200);

        }
        else{
            return response()->json(['error'=>'Unauthorised Acess'],203);
        }
    }
}
