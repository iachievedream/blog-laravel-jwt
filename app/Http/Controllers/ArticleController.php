<?php

namespace App\Http\Controllers;

use App\http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Article;
// use App\User;
use Illuminate\Support\Facades\Auth;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
    	// $index = $this->articleService->indexService()->get(['title', 'content'])
    	// return response()->json(auth()->index());
    	return $this->ArticleService
            ->storeService()
            ->get(['title', 'content','author'])
            ->toArray();
    }

    public function store(Request $request)
    {

        return Redirect('/');
    }

    public function show($id)
    {
        // $article = $this->articleService->showservice($id);
        // return ;

        $task = $this->articleService->showService();

    }

    public function update(Request $request,$id)
    {
    	
        return redirect('/');
    }

    public function destroy($id)
    {
        $this->articleService->deleteService($id);
        return redirect('/');
    }
    
    // public function test(Request $request)
    // {
    //     // return "Me is here";
    //     $article = new Article();
    //     $article->title = $request->'title';
    //     $article->content = $request->'content';
    //     $$article->save();

    // }
}