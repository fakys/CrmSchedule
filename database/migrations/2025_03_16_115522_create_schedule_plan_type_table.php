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
        Schema::create('schedule_plan_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('plan_type_data');
            $table->timestamps();
        });

        Schema::create('schedule_plan_all_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_plan_type_id')->references('id')->on('schedule_plan_type')->cascadeOnDelete();
            $table->foreignId('schedule_plan_id')->references('id')->on('plan_schedule')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_plan_type');
        Schema::dropIfExists('schedule_plan_all_types');
    }
};
