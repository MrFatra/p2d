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
        Schema::table('schedules', function (Blueprint $table) {
            $table->enum('type', ['Donor', 'Posyandu Umum', 'Posyandu Bayi', 'Posyandu Balita', 'Posyandu Ibu Hamil', 'Posyandu Remaja', 'Posyandu Lansia'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->enum('type', ['Donor', 'Infant Posyandu', 'Toddler Posyandu', 'Pregnant Women Posyandu', 'Teenager Posyandu', 'Elderly Posyandu'])->change();
        });
    }
};
