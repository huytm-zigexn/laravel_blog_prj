<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/register', [UserController::class, 'getRegister'])->name('getRegister');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/login', [UserController::class, 'getLogin'])->name('getLogin');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/', [PostController::class, 'mostViewsPosts'])->name('app');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::post('/posts/{slug}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::middleware('auth')->group(function() {
    Route::post('/posts/{slug}/likes', [LikeController::class, 'store'])->name('likes.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/users/{id}/edit-password', [UserController::class, 'editPassword'])->name('user.editPassword');
    Route::put('/users/{id}/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    Route::post('/users/{id}/follow', [UserController::class, 'follow'])->name('user.follow');
    Route::get('users/{id}/liked-posts-list', [UserController::class, 'likedPostsList'])->name('user.like');

    Route::get('/notifications', [UserController::class, 'notifications'])->name('follow.noti');
});