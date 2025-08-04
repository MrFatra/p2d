<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            // Informasi utama
            $table->string('title');
            $table->string('slug')->unique(); // URL-friendly title
            $table->text('excerpt')->nullable(); // Ringkasan singkat

            // Jenis konten
            $table->enum('source_type', ['manual', 'embed'])->default('manual');

            // Konten internal (manual)
            $table->longText('content')->nullable();

            // Konten eksternal (embed)
            $table->string('embed_url')->nullable();

            // Media dan thumbnail
            $table->string('cover_image')->nullable();

            // Penulis
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();

            // kategori
            $table->foreignId('article_categories_id')->nullable()->constrained()->cascadeOnDelete();

            // Status dan visibilitas
            $table->enum('status', ['published', 'archived'])->default('published');
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
