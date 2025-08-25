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
        Schema::table('adults', function (Blueprint $table) {
            $table->float('weight')->nullable();
            $table->float('height')->nullable();
            $table->boolean('smoking_status')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adults', function (Blueprint $table) {
            $table->dropColumn('weight');
            $table->dropColumn('height');
            $table->dropColumn('smoking_status');
            $table->dropColumn('notes');
        });
    }
};
