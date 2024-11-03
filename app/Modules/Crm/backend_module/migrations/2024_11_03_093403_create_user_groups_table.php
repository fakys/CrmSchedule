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
            $table->boolean('active')->default(true);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status_name')->unique();
            $table->string('url')->nullable();
            $table->string('description')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('groups_statuses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_group_id')->unsigned();
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('user_group_id')->references('id')->on('user_groups')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('groups_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_group_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_group_id')->references('id')->on('user_groups')->onDelete('cascade');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups_users');
        Schema::dropIfExists('groups_statuses');
        Schema::dropIfExists('user_groups');
        Schema::dropIfExists('statuses');
    }
};
