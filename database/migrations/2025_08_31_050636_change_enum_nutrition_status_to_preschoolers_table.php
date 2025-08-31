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
        Schema::table('preschoolers', function (Blueprint $table) {
            $table->enum('nutrition_status', ['Gizi Baik', 'Beresiko', 'Gizi Buruk', 'Obesitas'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('preschoolers', function (Blueprint $table) {
            $table->enum('nutrition_status', ['Gizi Baik', 'Gizi Cukup', 'Gizi Kurang', 'Gizi Buruk', 'Obesitas'])->nullable()->change();
        });
    }
};
