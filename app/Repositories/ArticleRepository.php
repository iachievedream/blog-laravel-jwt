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
	}
	
	public function getStore(array $data)
	{
        $article = Article::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'author' => auth::user()->name,
        ]);
        return $article;
	}

	public function getShow($id)
	{
        if (Article::find($id) == false) {
            return false;
        } else {
        	$article = Article::find($id)->only(['title', 'content','author']);
	        return $article;
        }
	}
	
	public function getUpdate(array $data,$id)
	{
        if (Article::find($id) == false) {
            return false;
        } else {		
	        $article = Article::find($id)->update([
	            'title' => $data['title'],
	            'content' => $data['content'],
	        ]);
	        return $article;
		}
	}

	public function getDestroy($id)
	{
		return Article::find($id)->delete();
	}
}