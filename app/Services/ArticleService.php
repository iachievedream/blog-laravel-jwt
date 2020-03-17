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
		return $index;
	}

	public function stores(array $data)
	{
		$store = $this->articleRepository->getStore($data);
		return $store;
	}

	public function shows($id)
	{
		$show = $this->articleRepository->getShow($id);
        if (empty($show)) {
            return false;
        } else {
			return $show;
        }
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