<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Contracts\Auth\StatefulGuard;

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

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);



Route::post('/switch-user', function(StatefulGuard $guard) {
    $guard->logout();
    session()->invalidate();
    session()->regenerateToken();

    $guard->attempt([
        'email' => request()->input('email'),
        'password' => 'password'
    ]);
    session()->regenerate();

    return back();
});
