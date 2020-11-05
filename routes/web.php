<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReactablePostController;
use App\Models\Post;

Route::get('/', function() {
    return redirect('/posts');
});

Route::get('/posts', [PostController::class, 'index']);
Route::middleware('auth')->group(function() {
    Route::get('/posts/new', [PostController::class, 'create']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/posts/{post}/edit', [PostController::class, 'edit']);
    Route::patch('/posts/{post}', [PostController::class, 'update']);
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);
});
Route::get('/posts/{post}', [PostController::class, 'show']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
