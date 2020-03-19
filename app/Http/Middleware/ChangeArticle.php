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
        $id = $request->route('id');
        if (empty(Article::find($id))) {
            return response()->json([
                'success' => false,
                'message' => '無此文章',
                'data' => '',
            ],400);
        } else {
            //文章作者
            $article = Article::find($id);
            $author = $article->author;
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
                ],401);                
            }
        }
    }
}
