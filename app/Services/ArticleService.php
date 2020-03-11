<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ArticleService
{
	protected $articleRepository;

	public function __construct(ArticleRepository $articleRepository)
	{
		$this->articleRepository = $articleRepository;
	}

	public function indexService()
	{
		return $this->articleRepository->getIndex();
	}

	public function storeService(array $data)
	{
		$article = Validator::make($data, [
			'title' => 'required|max:25',
            'content' => 'required|max:255',
		]);
		if ($article->fails())
		{
			return false;
		}
		return $this->articleRepository->getStore($data);
	}

	public function showService($id)
	{
		return $this->articleRepository->getShow($id);
	}

	public function updateService(array $data,$id)
	{
		$article = Validator::make($data, [
			'title' => 'required|max:25',
            'content' => 'required|max:255',
		]);
		if ($article->fails())
		{
			return false;
		}
		return $this->articleRepository->getUpdate($data,$id);
	}
	public function deleteService($id)
	{
		return $this->articleRepository->getDestroy($id);
	}
}