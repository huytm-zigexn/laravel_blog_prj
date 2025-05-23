<?php

use App\Http\Controllers\admin\UserController as AdminUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureHasRole;
use Illuminate\Support\Facades\Route;


Route::get('/register', [UserController::class, 'getRegister'])->name('getRegister');
Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/login', [UserController::class, 'getLogin'])->name('getLogin');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/', [PostController::class, 'mostViewsPosts'])->name('app');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');


Route::post('/posts/{slug}/comments', [CommentController::class, 'store'])->name('comments.store');

Route::middleware('auth')->group(function() {
    Route::get('/users/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/users/{id}/edit-password', [UserController::class, 'editPassword'])->name('user.editPassword');
    Route::put('/users/{id}/update-password', [UserController::class, 'updatePassword'])->name('user.updatePassword');
    Route::post('/users/{id}/follow', [UserController::class, 'follow'])->name('user.follow');
    Route::get('users/{id}/liked-posts-list', [UserController::class, 'likedPostsList'])->name('user.like');
    
    Route::get('/notifications', [UserController::class, 'notifications'])->name('follow.noti');
    
    Route::prefix('admin')->middleware(EnsureHasRole::class.':admin')->group(function() {
        Route::get('/dashboard', function() {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        Route::resource('users', AdminUserController::class)->except(['create', 'store', 'update']);
        Route::put('users/{id}', [AdminUserController::class, 'update'])->name('users.update');
        Route::post('/img-upload', [PostController::class, 'imgUpload'])->name('admin.img.upload');
        Route::get('/posts/create', [PostController::class, 'getCreate'])->name('admin.posts.create');
        Route::post('/posts/store', [PostController::class, 'store'])->name('admin.posts.store');
        Route::put('/posts/{slug}/publish', [PostController::class, 'publish'])->name('admin.posts.publish');
        Route::get('/posts/{slug}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');
        Route::put('/posts/{slug}/update', [PostController::class, 'update'])->name('admin.posts.update');
        Route::delete('/posts/{slug}/delete', [PostController::class, 'delete'])->name('admin.posts.delete');
    });
    
    Route::prefix('author')->middleware(EnsureHasRole::class.':author')->group(function() {
        Route::post('/img-upload', [PostController::class, 'imgUpload'])->name('author.img.upload');
        Route::get('/posts/create', [PostController::class, 'getCreate'])->name('author.posts.create');
        Route::post('/posts/store', [PostController::class, 'store'])->name('author.posts.store');
        Route::put('/posts/{slug}/publish', [PostController::class, 'publish'])->name('author.posts.publish');
        Route::get('/posts/{slug}/edit', [PostController::class, 'edit'])->name('author.posts.edit');
        Route::put('/posts/{slug}/update', [PostController::class, 'update'])->name('author.posts.update');
        Route::delete('/posts/{slug}/delete', [PostController::class, 'delete'])->name('author.posts.delete');
    });
    Route::post('/posts/{slug}/likes', [LikeController::class, 'store'])->name('likes.store');
});

Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');