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
        Schema::create('toddlers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->float('upper_arm_circumference')->nullable();
            $table->enum('nutrition_status', ['Gizi Baik', 'Gizi Cukup', 'Gizi Kurang', 'Gizi Buruk', 'Obesitas'])->nullable();
            $table->boolean('vitamin_a')->nullable();
            $table->boolean('immunization_followup')->nullable();
            $table->boolean('food_supplement')->nullable();
            $table->boolean('parenting_education')->nullable();
            $table->string('stunting_status')->nullable();
            $table->enum('motor_development', ['Normal', 'Perlu Pemantauan', 'Terlambat'])->nullable();
            $table->date('checkup_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toddlers');
    }
};
