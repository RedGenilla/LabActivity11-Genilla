<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CommentController;

// Redirect homepage to bulletin posts.
Route::redirect('/', '/posts');

// Guest login routes.
Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

// Logout for authenticated users.
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Public bulletin listing.
Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');

// New post form for authenticated users.
Route::get('/posts/create', [PostController::class, 'create'])
    ->middleware('auth')
    ->name('posts.create');

// Save a new post.
Route::post('/posts', [PostController::class, 'store'])
    ->middleware('auth')
    ->name('posts.store');

// Save a comment on an existing post.
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');

// Display an individual post.
Route::get('/posts/{id}', [PostController::class, 'show'])
    ->name('posts.show');

// Display an author's profile.
Route::get('/authors/{author}', [AuthorController::class, 'show'])
    ->name('authors.show');


