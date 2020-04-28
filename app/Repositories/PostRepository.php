<?php

namespace App\Repositories;

use App\Post;

class PostRepository
{
    public function index()
    {
        return Post::get();
    }

    public function find($id)
    {
        return Post::find($id);
    }

    public function create(array $data)
    {
        return auth()->user()->posts()->create($data);
    }

    public function update($id, array $data)
    {
        $post = Post::find($id);
        return $post ? $post->update($data) : false;
    }

    public function delete($id)
    {
        return Post::destroy($id);
    }
}