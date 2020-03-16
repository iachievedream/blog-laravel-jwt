<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Auth;
use App\Article;

class ArticleRepository
{
	public function getIndex()
	{
		// $article = Article::all();
		// if (is_null($article)){
        //     return false;
        // } else {
	    //     return $article;
        // }
        $index = Article::all();
        return $index;
	}
	
	public function getStore(array $data)
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
		$show = Article::find($id);
		// if (is_null($article)){
        //     return false;
        // } else {
        // 	$article = Article::find($id)->only(['title', 'content','author']);
        // 	// $article = Article::find($id);
	    return $show;
        // }
	}
	
	public function getUpdate(array $data,$id)
	{
	    $update = Article::find($id)->update([
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