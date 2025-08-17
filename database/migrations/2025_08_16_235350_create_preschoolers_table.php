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
        Schema::create('preschoolers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete(); // anak yang bersangkutan

            $table->float('weight')->nullable(); // berat badan (kg)
            $table->float('height')->nullable(); // tinggi badan (cm)
            $table->float('head_circumference')->nullable(); // lingkar kepala
            $table->float('upper_arm_circumference')->nullable(); // LILA

            $table->enum('nutrition_status', ['Gizi Baik', 'Gizi Cukup', 'Gizi Kurang', 'Gizi Buruk', 'Obesitas'])->nullable();
            $table->enum('motor_development', ['Normal', 'Perlu Pemantauan', 'Terlambat'])->nullable();
            $table->enum('language_development', ['Normal', 'Perlu Pemantauan', 'Terlambat'])->nullable();
            $table->enum('social_development', ['Normal', 'Perlu Pemantauan', 'Terlambat'])->nullable();

            $table->boolean('vitamin_a')->nullable();
            $table->boolean('complete_immunization')->nullable();
            $table->boolean('exclusive_breastfeeding')->nullable();
            $table->boolean('complementary_feeding')->nullable();
            $table->boolean('parenting_education')->nullable();

            // $table->string('stunting_status')->nullable();
            $table->date('checkup_date')->nullable(); // tanggal pemeriksaan

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preschoolers');
    }
};
