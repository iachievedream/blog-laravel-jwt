<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Article;
use Illuminate\Http\Request;

class ArticleRepository
{
	public function getIndex()
	{
		return Article::all();
	}
	
	public function getStore(array $data)
	{
        return auth()->user()->articles()->create($data);
		// return Article::create([
		// 	'title' => $data['title'],
		// 	'content' => $data['content'],
		// 	'author' => Auth::user(	)->name,
		// ]);
	}

	public function getShow($id)
	{
		return Article::find($id);
	}
	
	public function getUpdate(array $data,$id)
	{
		$article = Article::find($id);
		return $article ? $article->update($data) :false;
		// return Article::find($id)->update([
		// 	'title' => $data['title'],
		// 	'content' => $data['content'],
		// ]);
	}

	public function getDestroy($id)
	{
		return Article::destroy($id);
		// return Article::find($id)->delete();
	}
}