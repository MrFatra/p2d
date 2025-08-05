<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\LandingPageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [LandingPageController::class, 'index'])->name('landing.page');

Route::get('/articles', [ArticleController::class, 'show'])->name('articles.show');
