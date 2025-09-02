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
        Schema::table('infants', function (Blueprint $table) {
            $table->enum('one_month', ['Polio Tetes 1', 'BCG'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('infants', function (Blueprint $table) {
            $table->dropColumn('one_month');
        });
    }
};
