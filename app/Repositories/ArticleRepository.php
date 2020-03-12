<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Article;
use Illuminate\Http\Request;

class ArticleRepository
{
	public function getIndex()
	{
        $article = Article::all();
        // $article = Article::select()->get(['title', 'content','author']);
        return $article;
        // return response()->json([
        //     'success' => true,
        //     'message' => '成功取得文章列表',
        //     'data' => $article,
        // ]);

		// return Article::all();
	}
	
	public function getStore(array $data)
	{
        $article = Article::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'author' => auth::user()->name,
        ]);
        return $article;		

        // return auth()->user()->articles()->create($data);
		// return Article::create([
		// 	'title' => $data['title'],
		// 	'content' => $data['content'],
		// 	'author' => Auth::user(	)->name,
		// ]);
	}

	public function getShow($id)
	{
        if (Article::find($id) == false) {
            return false;
        }else{
        	$article = Article::find($id)->only(['title', 'content','author']);
	        return $article;
        }
	}
	
	public function getUpdate(array $data,$id)
	{
        if (Article::find($id) == false) {
            return false;
        }else{		
	        $article = Article::find($id)->update([
	            'title' => $data['title'],
	            'content' => $data['content'],
	        ]);
	        return $article;
		}
		// $article = Article::find($id);
		// return $article ? $article->update($data) :false;
		// return Article::find($id)->update([
		// 	'title' => $data['title'],
		// 	'content' => $data['content'],
		// ]);
	}

	public function getDestroy($id)
	{
		return Article::find($id)->delete();
	}
}