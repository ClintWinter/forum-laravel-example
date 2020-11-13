<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::redirect('/', '/posts');
Route::get('/posts', [PostController::class, 'index']);
Route::middleware('auth')->group(function() {
    Route::get('/posts/new', [PostController::class, 'create']);
    Route::post('/posts', [PostController::class, 'store'])->middleware('throttle:actions');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit']);
    Route::patch('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
});
Route::get('/posts/{post}', [PostController::class, 'show']);
