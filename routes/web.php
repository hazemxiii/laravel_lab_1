<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', function () {
    return view('posts', [
        'posts' => Post::all()
    ]);
});

Route::get('/posts/create', function () {
    return view('create-post');
});
Route::get('/posts/{id}', function ($id) {
    return view('posts', [
        'posts' => collect([Post::find($id)])
    ]);
});

Route::get('/posts/edit/{id}', function ($id) {
    return view('create-post', [
        'post' => Post::find($id)
    ]);
});

Route::get('/posts/delete/{id}', function ($id) {
    Post::delete($id);
    return redirect('/posts');
});

Route::post('/posts', function () {
    if (request('id')) {
        Post::update([
            'id' => request('id'),
            'title' => request('title'),
            'body' => request('body'),
        ]);
    } else {
        Post::create([
            'title' => request('title'),
            'body' => request('body'),
        ]);
    }
    return redirect('/posts');
});

?>