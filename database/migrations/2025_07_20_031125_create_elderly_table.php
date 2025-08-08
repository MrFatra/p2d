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
            $table->enum('nutrition_status', ['Gizi Baik', 'Gizi Cukup', 'Gizi Kurang', 'Gizi Buruk', 'Obesitas'])->nullable();
            $table->enum('functional_ability', ['Mandiri', 'Butuh Bantuan', 'Tidak Mandiri'])->nullable();
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
