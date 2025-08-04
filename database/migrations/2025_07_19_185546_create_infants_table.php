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
        Schema::create('infants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->float('head_circumference')->nullable();
            $table->float('birth_weight')->nullable();
            $table->float('birth_height')->nullable();
            $table->date('checkup_date')->nullable();
            $table->enum('nutrition_status', ['Gizi Baik', 'Gizi Cukup', 'Gizi Kurang'])->nullable();
            $table->boolean('complete_immunization')->nullable();
            $table->boolean('vitamin_a')->nullable();
            $table->string('stunting_status')->nullable();
            $table->boolean('exclusive_breastfeeding')->nullable();
            $table->boolean('complementary_feeding')->nullable();
            $table->string('motor_development')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infants');
    }
};
