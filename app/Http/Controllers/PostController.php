<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $posts       = $user->posts()->with('user')->paginate(3);
        $deletedPost = Post::onlyTrashed()->where('user_id', $user->id)->get();

        return view('posts', [
            'posts'       => $posts,
            'deletedPost' => $deletedPost,
        ]);
    }

    public function create()
    {
        return view('create-post');
    }

    public function show(Request $request, $id)
    {
        $post = $request->user()->posts()->findOrFail($id);

        return view('posts', [
            'posts'       => collect([$post]),
            'deletedPost' => collect(),
        ]);
    }

    public function edit(Request $request, $id)
    {
        $post = $request->user()->posts()->findOrFail($id);

        return view('edit-post', ['post' => $post]);
    }

    public function store(StorePostRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $validatedData['image'] = $imagePath;

        }

        $request->user()->posts()->create($validatedData);

        return redirect('/posts');
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $validatedData = $request->validated();
        $post = $request->user()->posts()->findOrFail($id);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $validatedData['image'] = $imagePath;
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
        }

        $post->update($validatedData);

        return redirect('/posts');
    }

    public function destroy(Request $request, $id)
    {
        $request->user()->posts()->findOrFail($id)->delete();

        return redirect('/posts');
    }

    public function restore(Request $request, $id)
    {
        Post::onlyTrashed()
            ->where('user_id', $request->user()->id)
            ->findOrFail($id)
            ->restore();

        return redirect('/posts');
    }

    public function forceDelete(Request $request, $id)
    {
        $post = $request->user()->posts()->onlyTrashed()->findOrFail($id);
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->forceDelete();

        return redirect('/posts');
    }
}

