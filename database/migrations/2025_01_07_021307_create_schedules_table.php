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
        Schema::create('duration_lessons', function (Blueprint $table) {
            $table->id();
            $table->date('date_start');
            $table->time('time_start');
            $table->time('time_end');
            $table->integer('duration_minutes')->nullable();
            $table->timestamps();
        });

        Schema::create('pair_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('number');
            $table->timestamps();
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('duration_lesson_id')->references('id')->on('duration_lessons')->cascadeOnDelete();
            $table->foreignId('pair_number_id')->references('id')->on('pair_numbers')->nullOnDelete();
            $table->foreignId('student_group_id')->references('id')->on('student_groups')->nullOnDelete();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('duration_lessons');
        Schema::dropIfExists('pair_numbers');
    }
};
