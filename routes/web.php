<?php

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

