<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Article;

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
            'author' => auth::user()->name,
        ]);
        return $store;
	}

	public function getShow($id)
	{
		$show = Article::find($id);//判斷有無文章
	    return $show;
	}
	
	public function getUpdate(array $data,$id)
	{
	    $update = Article::find($id)->update([//布林
	        'title' => $data['title'],
	        'content' => $data['content'],
	    ]);
	    return $update;
	}

	public function getDestroy($id)
	{
        $destroy = Article::find($id)->delete();
        return $destroy;
	}
}