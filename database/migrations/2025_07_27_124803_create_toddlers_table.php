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
            $table->string('nutrition_status')->nullable();
            $table->boolean('vitamin_a')->nullable();
            $table->boolean('immunization_followup')->nullable(); // booster
            $table->boolean('food_supplement')->nullable(); // PMT
            $table->boolean('parenting_education')->nullable(); // penyuluhan
            $table->string('motor_development')->nullable();
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
