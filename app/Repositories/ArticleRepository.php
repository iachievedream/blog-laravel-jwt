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
	
	public function getStore(array $data)//物件
	{
        $store = Article::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'author' => auth()->user()->name,
            // 'author' => auth::user()->name,
        ]);
        return $store;
	}

	public function getShow($id)
	{
		$show = Article::find($id);//object or null
	    return $show;
	}
	
	public function getUpdate(array $data,$id)
	{
	    $update = Article::find($id)->update([//boolean
	        'title' => $data['title'],
	        'content' => $data['content'],
	    ]);
	    return $update;
	}

	public function getDestroy($id)
	{
        $destroy = Article::find($id)->delete();//boolean
        return $destroy;
	}
}