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
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        $article = $this->articleService->indexService();
        // $article = Article::all();
        // // $article = Article::select()->get(['title', 'content','author']);
        return response()->json([
            'success' => true,
            'message' => '成功取得文章列表',
            'data' => $article,
        ]);
    }

    public function store(Request $request)
    {
        $message = $this->articleService->storeService($request->all());
        // if ($message == false) {
        //     return Redirect()->back();
        // }
        return response()->json([
            'success' => true,
            'message' => '新增文章成功',
            'data' => $message,
        ]);

        // $article = Article::create([
        //     'title' => $request->title,
        //     'content' => $request->content,
        //     'author' => auth::user()->name,
        // ]);
        // return response()->json([
        //     'success' => true,
        //     'message' => '新增文章成功',
        //     'data' => '',
        // ]);
    }

    public function show($id)
    {
        $article = $this->articleService->showservice($id);
        // dd($article);

        if ($article == false) {
            return response()->json([
                'success' => false,
                'message' => '顯示文章失敗',
                'data' => $article,
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => '顯示文章成功',
            'data' => $article,
        ]);
        // $article = Article::find($id)->only(['title', 'content','author']);
        // return response()->json([
        //     'success' => true,
        //     'message' => '顯示文章成功',
        //     'data' => $article,
        // ]);
    }

    public function update(Request $request,$id)
    {

        $article = $this->articleService->updateService($request->all(),$id);
        if ($article == false) {
            return response()->json([
                'success' => false,
                'message' => '更新文章失敗',
                'data' => '',
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => '更新文章成功',
            'data' => "",
        ]);


        // $article = Article::find($id)->update([
        //     'title' => $request->title,
        //     'content' => $request->content,
        // ]);
        // return response()->json([
        //     'success' => true,
        //     'message' => '更新文章成功',
        //     'data' => '',
        // ]);
    }

    public function destroy($id)
    {
        $this->articleService->deleteService($id);
        return response()->json([
            'success' => true,
            'message' => '刪除文章成功',
            'data' => '',
        ]);

        // $article =  Article::find($id)->delete();
        // return response()->json([
        //     'success' => true,
        //     'message' => '刪除文章成功',
        //     'data' => '',
        // ]);
    }
}