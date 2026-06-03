<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        // Apply Eager Loading to user relation and paginate the results
        $posts = Post::with('user')->paginate(10);
        return PostResource::collection($posts);
    }

    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return new PostResource($post);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => ['required', 'string', 'min:3', 'max:255', 'unique:posts,title'],
            'body'    => ['required', 'string', 'min:10'],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        $post = Post::create($validated);

        return new PostResource($post);
    }
}
