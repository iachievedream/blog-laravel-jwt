<?php

namespace App\Http\Controllers;

use App\http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Article;
// use App\User;
use Illuminate\Support\Facades\Auth;
use App\Services\ArticleService;
use JWTAuth;


class ArticleController extends Controller
{
    // protected $articleService;

    // public function __construct(ArticleService $articleService)
    // {
    //     // $this->articleService = $articleService;
    // }

    public function index()
    {
        $article = Article::all();
        // $article = Article::select()->get(['title', 'content','author']);
        return response()->json([
            'success' => true,
            'message' => '成功取得文章列表',
            'data' => $article,
        ]);
    }

    public function store(Request $request)
    {
        $article = Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'author' => auth::user()->name,
        ]);
        return response()->json([
            'success' => true,
            'message' => '新增文章成功',
            'data' => '',
        ]);
    }

    public function show($id)
    {
        $article = Article::find($id)->only(['title', 'content','author']);
        return response()->json([
            'success' => true,
            'message' => '顯示文章成功',
            'data' => $article,
        ]);
    }

    public function update(Request $request,$id)
    {
    	
        return redirect('/');
    }

    public function destroy($id)
    {
        $this->articleService->deleteService($id);
        return redirect('/');
    }
}