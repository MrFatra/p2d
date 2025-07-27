<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'source_type',
        'content',
        'embed_url',
        'cover_image',
        'user_id',
        'article_categories_id',
        'status',
    ];

    /**
     * Relasi: Artikel milik satu kategori.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class, 'article_categories_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($article) {
            if (
                $article->status === 'published' &&
                empty($article->published_at)
            ) {
                $article->published_at = Carbon::now();
            }

            if (empty($article->slug)) {
                $article->slug = Str::slug($article->name);
            }
        });
    }
}
