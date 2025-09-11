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
            $table->json('one_day')->nullable();
            $table->boolean('hb_immunization')->nullable();
            $table->date('hb_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('infants', function (Blueprint $table) {
            $table->dropColumn('one_year');
        });
    }
};
