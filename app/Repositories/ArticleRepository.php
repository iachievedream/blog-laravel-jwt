<?php

namespace App\Repositories;

use App\Article;
use JWTAuth;

class ArticleRepository
{
	public function getIndex()
	{
        $index = Article::all();
        return $index;
	}
	
	public function getStore(array $data)
	{
        $store = Article::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'author' => auth()->user()->name,
        ]);
        return $store;//object
	}

	public function getShow($id)
	{
		$show = Article::find($id);
	    return $show;//object or null
	}
	
	public function getUpdate(array $data,$id)
	{
	    $update = Article::find($id)->update([
	        'title' => $data['title'],
	        'content' => $data['content'],
	    ]);
	    return $update;//boolean
	}

	public function getDestroy($id)
	{
        $destroy = Article::find($id)->delete();
        return $destroy;//boolean
	}
}