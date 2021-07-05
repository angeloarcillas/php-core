<?php

namespace App\Controllers;

use \Zeretei\PHPCore\Blueprint\Controller;

use \App\Models\Post;
use \App\Middlewares\AuthMiddleware;

class PostController extends Controller
{

    public function __construct()
    {
        $this->registerMiddleware(
            new AuthMiddleware(['create', 'store', 'show', 'edit', 'update', 'destroy'])
        );
    }

    /**
     * Show all post
     */
    public function index()
    {
        return view('posts.index', [
            'posts' => (new Post())->all()
        ]);
    }

    /**
     * Show a single post
     */
    public function show(int $id)
    {
        return view('posts.show', [
            'post' => (new Post())->select($id)
        ]);
    }

    /**
     * Show create post
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a post
     */
    public function store()
    {
        $attributes = app('request')->validate([
            'title' => ['required', 'min:5', 'max:255'],
            'body' => 'required'
        ]);
        $attributes['user_id'] = app('session')->get('auth');

        $post = new Post();

        if (!$post->insert($attributes)) {
            throw new \Exception("Something went wrong, please try again.");
        }

        return redirect('/setup/posts');
    }

    /**
     * Show edit post
     */
    public function edit($id)
    {
        return view('posts/edit', [
            'post' => (new Post())->select($id)
        ]);
    }

    /**
     * Update a post
     */
    public function update($id)
    {
        $attributes = app('request')->validate([
            'title' => ['required', 'min:5', 'max:255'],
            'body' => 'required'
        ]);

        $post = new Post();

        if (!$post->update($id, $attributes)) {
            throw new \Exception("Something went wrong, please try again.");
        }

        return redirect('/setup/posts');
    }

    /**
     * Delete a post
     */
    public function destroy($id)
    {
        $post = new Post();

        if (!$post->delete($id)) {
            throw new \Exception("Something went wrong, please try again.");
        }

        return redirect('/setup/posts');
    }
}
