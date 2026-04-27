<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('posts', [
            'posts' => Post::all()
        ]);
    }
    public function create()
    {
        return view('create-post');
    }
    public function show($id)
    {
        return view('posts', [
            'posts' => collect([Post::find($id)])
        ]);
    }
    public function edit($id)
    {
        return view('create-post', [
            'post' => Post::find($id)
        ]);
    }
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect('/posts');
    }
    public function store()
    {
        if (request('id')) {
            $post = Post::find(request('id'));
            $post->title = request('title');
            $post->body = request('body');
            $post->save();
        } else {
            Post::create([
                'title' => request('title'),
                'body' => request('body'),
                'user_id' => auth()->id(),
            ]);
        }
        return redirect('/posts');
    }
}
