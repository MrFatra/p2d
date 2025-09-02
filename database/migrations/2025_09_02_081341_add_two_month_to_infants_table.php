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
            $table->enum('two_month', ['DPT-HB-Hib 1', 'Polio Tetes 2', 'PCV 1', 'RV 1'])->nullable()->after('one_month');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('infants', function (Blueprint $table) {
            $table->dropColumn('two_month');
        });
    }
};
