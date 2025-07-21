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
        Schema::create('elderly', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->float('blood_pressure')->nullable();
            $table->float('blood_glucose')->nullable();
            $table->float('cholesterol')->nullable();
            $table->string('nutrition_status')->nullable();
            $table->string('functional_ability')->nullable();
            $table->string('chronic_disease_history')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elderly');
    }
};
