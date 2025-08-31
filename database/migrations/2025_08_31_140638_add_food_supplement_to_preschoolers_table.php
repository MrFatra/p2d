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
            $table->boolean('food_supplement')->nullable();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('preschoolers', function (Blueprint $table) {
            $table->dropColumn('food_supplement');
        });
    }
};
