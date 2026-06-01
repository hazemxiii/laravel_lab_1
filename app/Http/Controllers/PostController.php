<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::all();
        $deletedPost = Post::onlyTrashed()->get();

        return view('posts', [
            'posts' => $posts,
            'deletedPost' => $deletedPost,
        ]);
    }

    public function create()
    {
        return view('create-post');
    }

    public function show($id)
    {
        return view('posts', [
            'posts' => collect([Post::findOrFail($id)])
        ]);
    }

    public function edit($id)
    {
        return view('edit-post', [
            'post' => Post::findOrFail($id)
        ]);
    }

    public function store(StorePostRequest $request)
    {
        Post::create([
            'title'   => $request->validated()['title'],
            'body'    => $request->validated()['body'],
            'user_id' => auth()->id(),
        ]);

        return redirect('/posts');
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->title = $request->validated()['title'];
        $post->body  = $request->validated()['body'];
        $post->save();

        return redirect('/posts');
    }

    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return redirect('/posts');
    }

    public function restore($id)
    {
        Post::withTrashed()->findOrFail($id)->restore();

        return redirect('/posts');
    }

    public function forceDelete($id)
    {
        Post::withTrashed()->findOrFail($id)->forceDelete();

        return redirect('/posts');
    }
}
