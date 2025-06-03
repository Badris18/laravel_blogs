<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\PostController;

Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('/post/{post}', [PostController::class, 'show'])->name('posts.show');
Route::post('/post/{post}/comment', [PostController::class, 'addComment'])->name('posts.comment');
