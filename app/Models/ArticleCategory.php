<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ArticleCategory extends Model
{
    // Nama tabel (opsional jika nama tabel sesuai konvensi)
    protected $table = 'article_categories';

    // Kolom-kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Relasi: Satu kategori memiliki banyak artikel.
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'article_categories_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

}
