<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    protected $PostRepository;

    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }

    public function index()
    {
        $post = $this->postRepo->index();
        return response()->json([
            'success' => true,
            'message' => '取得文章列表成功',
            'data' => $post,
        ],200);
    }

    public function store()
    {
        $post = $this->postRepo->create(request()->only('title', 'content'));
        if (!$post) {
            return response()->json([
                    'success' => false,
                    'message' => '新增文章失敗',
                    'data' => '',
            ],400);
        }

        return response()->json([
            'success' => true,
            'message' => '新增文章成功',
            'data' => $post,
        ],200);
    }

    public function show($id)
    {
        $post = $this->postRepo->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => '無此文章',
                'data' => '',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => '顯示文章成功',
            'data' => $post,
        ],200);
    }

    public function update($id)
    {
        $result = $this->postRepo->update($id, request()->only('title', 'content'));

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => '更新文章失敗',
                'data' => '',
                ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => '更新文章成功',
            'data' => '',
        ],200);
    }

    public function destroy($id)
    {
        $result = $this->postRepo->delete($id);

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => '刪除文章失敗',
                'data' => '',
                ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => '刪除文章成功',
            'data' => '',
        ],200);
    }
}