<?php

namespace App\Http\Controllers;

use App\http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Article;
// use App\User;
use Illuminate\Support\Facades\Auth;
use App\Services\ArticleService;
// use JWTAuth;
use Illuminate\Support\Facades\Validator;

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
        return response()->json([
            'success' => true,
            'message' => '成功取得文章列表',
            'data' => $article,
        ]);
    }

    public function store(Request $request)
    {
        $article = Validator::make($request->all(), [
            'title' => 'required|max:25',
            'content' => 'required|max:255',
        ]);
        if ($article->fails()) {
            return response()->json([
                'success' => false,
                'message' => '新增文章不合格式',
                'data' => '',
            ]);
        } else {
            $article = $this->articleService->storeService($request->all());
            if ($article == false) {
                return response()->json([
                    'success' => false,
                    'message' => '新增文章失敗',
                    'data' => '',
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => '新增文章成功',
                    'data' => $article,
                ]);
            }
        }
    }

    public function show($id)
    {
        $article = $this->articleService->showservice($id);
        if ($article == false) {
            return response()->json([
                'success' => false,
                'message' => '無此文章',
                'data' => '',
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => '顯示文章成功',
                'data' => $article,
            ]);
        }
    }

    public function update(Request $request,$id)
    {
        $article = Validator::make($request->all(), [
            'title' => 'required|max:25',
            'content' => 'required|max:255',
        ]);
        if ($article->fails()) {
            return response()->json([
                'success' => false,
                'message' => '更新文章不合格式',
                'data' => '',
            ]);
        } else {
            $article = $this->articleService->updateService($request->all(), $id);
            if ($article == false) {
                return response()->json([
                    'success' => false,
                    'message' => '更新文章失敗',
                    'data' => '',
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => '更新文章成功',
                    'data' => $request->all(),
                ]);
            }
        }        
    }

    public function destroy($id)
    {
        $article = $this->articleService->deleteService($id);
        if ($article == false) {
            return response()->json([
                'success' => false,
                'message' => '刪除文章失敗',
                'data' => '',
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => '刪除文章成功',
                'data' => '',
            ]);
        }
    }
}