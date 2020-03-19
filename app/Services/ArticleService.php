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
		$index = $this->articleRepository->getIndex();
        $article = $index->all();
		return $article;
	}

	public function stores(array $data)
	{
		$store = $this->articleRepository->getStore($data);
		return $store;
	}

	public function shows($id)
	{
		$show = $this->articleRepository->getShow($id);
		return $show;
	}

	public function updates(array $data, $id)
	{
		$update = $this->articleRepository->getUpdate($data, $id);
		return $update;
	}

	public function destroys($id)
	{
		$destroy = $this->articleRepository->getDestroy($id);
		return $destroy;
	}
}