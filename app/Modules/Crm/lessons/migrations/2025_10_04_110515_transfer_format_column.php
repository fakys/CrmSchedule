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
        Schema::dropColumns('lessons', 'format_lesson_id');
        Schema::table('schedules', function($table) {
            $table->foreignId('format_lesson_id')->nullable()->references('id')->on('format_lessons')->nullOnDelete();
        });
        Schema::table('plan_schedule', function($table) {
            $table->foreignId('format_lesson_id')->nullable()->references('id')->on('format_lessons')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('schedules', 'format_lesson_id');
        Schema::dropColumns('plan_schedule', 'format_lesson_id');
        Schema::table('lessons', function($table) {
            $table->foreignId('format_lesson_id')->nullable()->references('id')->on('format_lessons')->nullOnDelete();
        });
    }
};
