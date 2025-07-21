<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Donor', 'Infant Posyandu', 'Toddler Posyandu', 'Pregnant Women Posyandu', 'Teenager Posyandu', 'Elderly Posyandu']);
            $table->date('date_open');
            $table->date('date_closed');
            $table->time('time_opened');
            $table->time('time_closed');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
