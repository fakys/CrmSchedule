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
        Schema::table('correction_schedule', function (Blueprint $table) {
            $table->foreignId('schedule_plan_id')->references('id')->on('plan_schedule')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('correction_schedule', function (Blueprint $table) {
            $table->dropColumn('schedule_plan_id');
        });
    }
};
