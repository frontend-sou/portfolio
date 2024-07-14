<?php

use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Top', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::get('/posts', function () {
    return Inertia::render('Posts/Index');
})->middleware(['auth', 'verified'])->name('posts.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // PostControllerのメソッドとルーティングをRoute::resource一つで紐づけ
    Route::resource('posts', PostController::class);
    // マイ投稿のルーティング
    Route::get('/myPost', [PostController::class, 'myPostIndex'])->name('myPost');

    // お気に入りのルーティング
    Route::get('/like', [LikeController::class, 'index'])->name('like');
    Route::post('/posts/{post}/like', [LikeController::class, 'store'])->name('like.store');
    Route::delete('/posts/{post}/like', [LikeController::class, 'destroy'])->name('like.destroy');
});

Route::get('/health', [HealthCheckController::class, 'check']);

require __DIR__ . '/auth.php';
