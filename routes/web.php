<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;

// Redirect homepage to bulletin posts.
Route::redirect('/', '/posts');

// Guest login routes.
Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

// Logout route for authenticated users.
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Public bulletin listing.
Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');

// Display an individual post.
Route::get('/posts/{id}', [PostController::class, 'show'])
    ->name('posts.show');

// Display an author's profile.
Route::get('/authors/{author}', [AuthorController::class, 'show'])
    ->name('authors.show');

