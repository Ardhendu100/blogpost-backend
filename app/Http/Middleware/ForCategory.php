<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
class ForCategory
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $id)
    {
        $ispost = DB::table('posts')->where('category_id', $id)->get()->count();
        if($ispost>=1){
            return response()->json(["Error"=>"Category contains some posts so you can't delete this category"],202);
            
        }
        else{
            return $next($request);
        }
    }
}
