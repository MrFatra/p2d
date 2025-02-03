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
        Schema::table('growths', function (Blueprint $table) {
            $table->enum('stunting_status', ['Normal', 'Stunting', 'Kemungkinan Stunting'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('growths', function (Blueprint $table) {
            //
        });
    }
};
