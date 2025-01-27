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
        Schema::create('growths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->boolean('smoking')->nullable()->default(false);
            $table->float('abdominal_circumference')->nullable();
            $table->float('blood_sugar_levels')->nullable();
            $table->boolean('taking_blood_supplement')->nullable()->default(false);
            $table->float('blood_pressure')->nullable();
            $table->integer('gestational_age')->nullable();
            $table->enum('gestational_category', ['Hamil', 'Lahir', 'Abortus'])->nullable();
            $table->float('head_circumference')->nullable();
            $table->float('arm_circumference')->nullable();
            $table->boolean('exclusive_breastfeeding')->nullable()->default(false);
            $table->float('imt')->nullable();
            $table->enum('stunting_status', ['Normal', 'Stunting'])->nullable();
            $table->enum('imt_status', ['Berat Badan Kurang', 'Normal', 'Berat Badan Berlebih', 'Obesitas Kelas 1', 'Obesitas Kelas 2', 'Obesitas Kelas 3',])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('growths');
    }
};
