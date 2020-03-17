<?php

namespace App\Http\Controllers;

use App\http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ArticleService;
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
        $article = $this->articleService->indexs();//物件內有空陣列
        if (empty($article->all())) {
        // if (! ($article->all())) {
            return response()->json([
                'success' => false,
                'message' => '未有文章',
                'data' => '',
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => '取得文章列表成功',
                'data' => $article,
            ]);
        }
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
            $article = $this->articleService->stores($request->all());
            if (empty($article)) {
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
        $article = $this->articleService->shows($id);
        if (empty($article)) {
        // if (! $article) {//true之外都為顯示為true
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
            $article = $this->articleService->updates($request->all(), $id);//boolean
            if (empty($article)) {
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
        $article = $this->articleService->destroys($id);//boolean
        if (empty($article)) {
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