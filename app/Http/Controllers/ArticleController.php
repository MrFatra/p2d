<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function show(Request $article)
    {
        return Inertia::render('ListArticle', [
            'article' => $article,
        ]);
    }
}
