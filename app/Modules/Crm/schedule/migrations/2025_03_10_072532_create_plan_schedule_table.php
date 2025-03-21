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
        Schema::create('plan_duration_lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('week_day')->default(1);
            $table->integer('week_number')->default(1);
            $table->time('time_start');
            $table->time('time_end');
            $table->integer('duration_minutes')->nullable();
            $table->timestamps();
        });

        Schema::create('schedule_plan_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('plan_type_data');
            $table->timestamps();
        });

        Schema::create('plan_schedule', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_duration_lesson_id')->references('id')->on('plan_duration_lessons')->cascadeOnDelete();
            $table->foreignId('pair_number_id')->references('id')->on('pair_numbers')->nullOnDelete();
            $table->foreignId('student_group_id')->references('id')->on('student_groups')->nullOnDelete();
            $table->foreignId('semester_id')->references('id')->on('semesters')->nullOnDelete();
            $table->foreignId('plan_type_id')->references('id')->on('schedule_plan_type')->nullOnDelete();
            $table->foreignId('lessons_id')->nullable()->references('id')->on('lessons')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_schedule');
        Schema::dropIfExists('plan_duration_lessons');
        Schema::dropIfExists('schedule_plan_type');
    }
};
