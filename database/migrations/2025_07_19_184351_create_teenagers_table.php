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
        Schema::create('teenagers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->float('bmi')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->boolean('anemia')->nullable();
            $table->integer('iron_tablets')->nullable();
            // must ask
            $table->enum('reproductive_health', ['baik', 'cukup', 'kurang'])->nullable();
            $table->enum('mental_health', ['baik', 'cukup', 'kurang'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teenagers');
    }
};
