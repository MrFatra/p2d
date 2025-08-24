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
        Schema::dropIfExists('reports');

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->integer('babies');       // 0-12 bulan
            $table->integer('toddlers');     // 1-5 tahun
            $table->integer('children');     // 6-12 tahun
            $table->integer('teenagers');    // 13-17 tahun
            $table->integer('adults');       // 18-59 tahun
            $table->integer('elderlies');    // 60+ tahun
            $table->integer('pregnants');    // ibu hamil (khusus)
            $table->string('hamlet');
            $table->integer('month');
            $table->integer('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
