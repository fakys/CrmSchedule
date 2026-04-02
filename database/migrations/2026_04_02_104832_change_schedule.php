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
        Schema::table('plan_schedule', function (Blueprint $table) {
            $table->dropColumn('plan_duration_lesson_id');
            $table->dropColumn('pair_number_id');
            $table->dropColumn('student_group_id');
            $table->dropColumn('lessons_id');
            $table->dropColumn('description');
            $table->dropColumn('format_lesson_id');
            $table->integer('week_day');
            $table->integer('week_number');
            $table->foreignId('schedule_id')->references('id')->on('schedules')->cascadeOnDelete();
        });

        Schema::drop('plan_duration_lessons');

        Schema::table('duration_lessons', function (Blueprint $table) {
            $table->dropColumn('date_start');
        });

        //Создаем таблицу корректировки расписания
        Schema::create('correction_schedule', function (Blueprint $table) {
            $table->date('date_start')->nullable();
            $table->foreignId('schedule_id')->references('id')->on('schedules')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('plan_duration_lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('week_day')->default(1);
            $table->integer('week_number')->default(1);
            $table->time('time_start');
            $table->time('time_end');
            $table->integer('duration_minutes')->nullable();
            $table->timestamps();
        });

        Schema::table('plan_schedule', function (Blueprint $table) {
            $table->foreignId('plan_duration_lesson_id')->references('id')->on('plan_duration_lessons')->cascadeOnDelete();
            $table->foreignId('pair_number_id')->references('id')->on('pair_numbers')->nullOnDelete();
            $table->foreignId('student_group_id')->references('id')->on('student_groups')->nullOnDelete();
            $table->foreignId('lessons_id')->nullable()->references('id')->on('lessons')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->foreignId('format_lesson_id')->nullable()->references('id')->on('format_lessons')->nullOnDelete();
            $table->dropColumn('schedule_id');
            $table->dropColumn('week_number');
            $table->dropColumn('week_day');
        });

        Schema::table('duration_lessons', function (Blueprint $table) {
            $table->date('date_start')->nullable();
        });

        Schema::dropIfExists('correction_schedule');

    }
};
