<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', [PostController::class, 'index']);

Route::get('/posts/create', [PostController::class, 'create']);

Route::get('/posts/{id}', [PostController::class, 'show']);

Route::get('/posts/edit/{id}', [PostController::class, 'edit']);

Route::delete('/posts/{id}', [PostController::class, 'destroy']);

Route::post('/posts', [PostController::class, 'store']);

Route::get('/signup', [UserController::class, 'signup']);

Route::post('/signup', [UserController::class, 'signup_post']);

Route::get('/login', [UserController::class, 'login']);

Route::post('/login', [UserController::class, 'login_post']);

Route::post('/logout', [UserController::class, 'logout_post']);
?>