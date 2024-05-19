<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/top', function () {
    return view('top');
});

// ルーティングにmiddlewareを先に記述してグループ以下に処理を書くことで毎度middleware記述するのを省略
Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard',function(){
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/index',[PostController::class,'index'])->name('post.index');

    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
