<?php

namespace App\Http\Middleware;

use Closure;
use App\Article;
use Illuminate\Support\Facades\Auth;

class ChangeArticle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //網址回傳ID
        $id = $request->route('id');
        //文章作者
        // dd(Article::find($id));//空物件，陣列(要統一 物件或是陣列，取方法的問題)
        if (empty(Article::find($id))) {


            return response()->json([
                'success' => false,
                'message' => '無此文章',
                'data' => '',
            ]);
        } else {
            $article = Article::find($id);
            $author = $article->author;//欄位
            //登入使用者
            $user = Auth::user()->name;
            //管理員判斷
            $role = Auth::user()->role;
            if ($author == $user || $role == "admin") {
                return $next($request);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '無此權限',
                    'data' => '',
                ]);                
            }
        }
    }
}
