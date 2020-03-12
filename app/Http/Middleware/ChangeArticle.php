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
        if (Article::find($id) == false) {
            return response()->json([
                'success' => false,
                'message' => '無此文章',
                'data' => '',
            ]);
        } else {
            $article = Article::find($id);
            $author = $article->author;
            //登入使用者
            $user = Auth::user()->name;
            //管理員判斷
            $role = Auth::user()->role;
            if ($author == $user || $role == "admin") {
                return $next($request);
            }
            return response()->json([
                'success' => false,
                'message' => '無此權限',
                'data' => '',
            ]);
        }
    }
}
