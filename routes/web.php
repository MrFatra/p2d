<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return inertia('Home');
});

Route::get('/articles', [ArticleController::class, 'show'])->name('articles.show');
