<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

// Redirect the homepage to the bulletin.
Route::redirect('/', '/posts');

// Guest-only login routes.
Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

// Logged-in users can log out.
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Public bulletin pages.
Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');

Route::get('/posts/{id}', [PostController::class, 'show'])
    ->name('posts.show');
