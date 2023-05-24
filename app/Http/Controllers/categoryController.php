<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $token=$req->user()->token();
        // return $token;
        return User::find(1)->getUserData;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req, $id)

    {
        $getuser = User::find($id)->id;
        $validation = Validator::make($req->all(), [
            'name' => 'required',
        ]);
        $isValid = Category::where('name', '=', $req->name)->first();
        if ($isValid !== null) {
            return response()->json(['error' => 'Category already exist'], 203);
        } else if ($validation->fails()) {
            return response()->json($validation->errors(), 202);
        } else {
            $category = Category::create([
                'name' => $req->name,
                'user_id' => $getuser
            ]);
            $category->save();
            return $category;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $allCategory = Category::all();
        if ($allCategory) {
            return $allCategory;
        } else {
            return response()->json(["Error" => 'No category is avilable'], 203);
        }
    }
public function show_category_name(){
    $allCategory = Category::all();
    if ($allCategory) {
        return $allCategory;
    } else {
        return response()->json(["Error" => 'No category is avilable'], 203);
    }
}
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $validation = Validator::make($req->all(), [
            'name' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 202);
        }
        $update_category = Category::find($id);
        $update_category->name = $req->input('name');

        $update_category->save();
        return $update_category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json(["error" => "you are not allowed to delete this category"], 203);
            }

            $category->post()->delete();
            $category->delete();
            return response()->json(["sucess" => "Category has been deleted Sucessfully"], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(["Error" => 'Category contains some post so you are not allowed to delete category'], 203);
        }
    }

    public function getpost($id)
    {
        // $allpost=Post::all();
        $ispost = DB::table('posts')->where('category_id', $id)->get()->count();
        if ($ispost >= 1) {
            return $ispost;
        } else {
            return "Nothing";
        }
    }

    public function show_category_details($id)
    {
        $category = Category::find($id);
        $user=User::find($category->user_id);
        $author=$user->name;
        return response()->json(["category"=>$category,"author"=>$author],200);
    }
}
