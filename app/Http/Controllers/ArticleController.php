<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ArticleController extends Controller
{
    public function index()
    {
        $featured = Article::with('category')->latest()->first();

        $articles = Article::with('category')
            ->where('id', '!=', $featured->id)
            ->latest()
            ->paginate(4);

        return Inertia::render('ListArticle', [
            'featured' => $featured,
            'articles' => $articles
        ]);
    }

    public function show($slug)
    {
        $article = Article::with(['category', 'user'])->where('slug', $slug)->firstOrFail();

        $article->cover_image_url = $article->cover_image
            ? Storage::url($article->cover_image)
            : null;

        $suggestedArticles = Article::with('category')
            ->where('slug', '!=', $slug)
            ->inRandomOrder()
            ->limit(2)
            ->get()
            ->map(function ($article) {
                $article->cover_image_url = $article->cover_image
                    ? Storage::url($article->cover_image)
                    : null;
                return $article;
            });

        return Inertia::render('ViewArticle', [
            'article' => $article,
            'suggestedArticles' => $suggestedArticles,
        ]);
    }
}
