<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogUserController;
use App\Http\Controllers\categoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PublicCommentController;
use App\Http\Middleware\IsPost;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',[BlogUserController::class,'registration']);
Route::post('/login',[BlogUserController::class,'login']);
// Route::get('/login',[BlogUserController::class,'login']);  //for unauthorised user
Route::middleware('auth:api')->post('/logout',[BlogUserController::class,'logout']);
Route::put('/update/{id}',[BlogUserController::class,'update']);
Route::put('/update_profile/{id}',[BlogUserController::class,'update_profile']);
Route::get('/user_details/{id}',[BlogUserController::class,'show_user_details']);
Route::get('/check_user',[BlogUserController::class,'check_user']);
// Category 
Route::post('/create_category/{id}',[categoryController::class,'create']);
Route::get('/getpost/{id}',[categoryController::class,'getPost']);
Route::get('/show_category',[categoryController::class,'show']);
Route::get('/show_category_name',[categoryController::class,'show_category_name']);
Route::get('/show_category_details/{id}',[categoryController::class,'show_category_details']);
Route::delete('/delete_category/{id}',[categoryController::class,'destroy'])->middleware(['forcategory:id']);
Route::put('/update_category/{id}',[categoryController::class,'update'])->middleware(['forcategory:id']);



// Post
Route::post('/create_post/{id}',[PostController::class,'add_post']);
Route::get('/show_post/{id}',[PostController::class,'show_post']);
Route::get('/show_all_post',[PostController::class,'show_all_post']);
Route::get('/show_post_details/{id}',[PostController::class,'show_post_details']);
Route::delete('/delete_post/{id}',[PostController::class,'delete_post']);
Route::put('/update_post/{id}',[PostController::class,'update_post']);
//Comments
Route::post('/add_comment/{id}',[CommentsController::class,'add_comment']);
Route::get('/show_all_comment/{id}',[CommentsController::class,'show_all_comment']);
Route::get('/show_specific_comment/{id}',[CommentsController::class,'show_specific_comment']);
Route::delete('/delete_comment/{id}',[CommentsController::class,'delete_comment']);
Route::put('/update_comment/{id}',[CommentsController::class,'update_comment']);

//User Comment
Route::post('/add_user_comment/{id}',[PublicCommentController::class,'add_comment']);
Route::get('/show_all_user_comment/{id}',[PublicCommentController::class,'show_all_comment']);
Route::put('/update_user_comment/{id}',[PublicCommentController::class,'update_comment']);