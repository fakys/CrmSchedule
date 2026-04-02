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
        Schema::table('pair_numbers', function (Blueprint $table) {
            $table->string('time_start')->nullable();
            $table->string('time_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pair_numbers', function (Blueprint $table) {
            $table->dropColumn('time_start');
            $table->dropColumn('time_end');
        });
    }
};
