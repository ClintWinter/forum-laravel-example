<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }

    public function index()
    {
        $posts = Post::withCount('comments')
            ->orderByDesc('created_at')
            ->get();

        $views = Redis::hGetAll('posts:views');

        return view('posts.index', compact('posts', 'views'));
    }

    public function create()
    {
        return view('posts.new');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:5',
            'body' => 'required|min:10',
        ]);

        $post = Auth::user()->posts()->create($validatedData);

        return redirect('/posts/' . $post->id);
    }

    public function show(Post $post)
    {
        Redis::hIncrBy("posts:views", $post->id, 1);

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'body' => 'required|min:10',
        ]);

        $post->body = $validatedData['body'];

        $post->save();

        return redirect('/posts/' . $post->id);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return back();
    }
}
