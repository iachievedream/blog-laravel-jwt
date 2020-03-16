<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

class ArticleService
{
	protected $articleRepository;

	public function __construct(ArticleRepository $articleRepository)
	{
		$this->articleRepository = $articleRepository;
	}

	public function indexs()
	{
		return $this->articleRepository->getIndex();
	}

	public function stores(array $data)
	{
		return $this->articleRepository->getStore($data);
	}

	public function shows($id)
	{
		// $article = $this->articleRepository->getShow($id);
		// $articles = $article->only(['title', 'content','author']);
		// return $articles;
		return $this->articleRepository->getShow($id);
	}

	public function updates(array $data, $id)
	{
		return $this->articleRepository->getUpdate($data, $id);
	}

	public function deletes($id)
	{
		return $this->articleRepository->getDestroy($id);
	}
}