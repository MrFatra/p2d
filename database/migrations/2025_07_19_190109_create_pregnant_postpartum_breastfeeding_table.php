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
        Schema::create('pregnant_postpartum_breastfeeding', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum('pregnancy_status', ['trimester 1', 'trimester 2', 'trimester 3', 'postpartum', 'pregnant', 'abortus', 'none'])->default('none');
            // MUAC = LILA = Lingkar Lengan Atas
            $table->float('muac')->nullable();
            $table->string('blood_pressure')->nullable();
            // this string type is confusing
            $table->string('tetanus_immunization')->nullable();
            $table->integer('iron_tablets')->nullable();
            $table->date('anc_schedule')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregnant_postpartum_breastfeeding');
    }
};
