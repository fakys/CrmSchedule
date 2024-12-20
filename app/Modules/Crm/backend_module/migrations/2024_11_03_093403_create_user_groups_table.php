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

        Schema::create('user_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('accesses');
            $table->boolean('active')->default(true);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('groups_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_group_id')->references('id')->on('user_groups')->onDelete('cascade');
            $table->foreignId('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups_users');
        Schema::dropIfExists('user_groups');
    }
};
