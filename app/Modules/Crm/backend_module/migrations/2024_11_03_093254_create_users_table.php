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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('deleted')->default(false);
            $table->boolean('blocked')->default(false);
            $table->boolean('afk')->default(false);
            $table->timestamps();
        });
        Schema::create('users_info', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('patronymic')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('number_phone')->nullable()->unique();
            $table->text('photo')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('users_documents', function (Blueprint $table) {
            $table->id();
            $table->string('inn')->nullable();
            $table->string('passport_series')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('snils')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_info');
        Schema::dropIfExists('users_documents');
        Schema::dropIfExists('users');
    }
};
