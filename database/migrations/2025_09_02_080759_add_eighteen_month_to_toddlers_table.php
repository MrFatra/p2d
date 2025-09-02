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
        Schema::table('toddlers', function (Blueprint $table) {
            $table->enum('eighteen_month', ['DPT-HB-Hib 4', 'Campak Rubella 2'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('toddlers', function (Blueprint $table) {
            $table->dropColumn('eighteen_month');
        });
    }
};
