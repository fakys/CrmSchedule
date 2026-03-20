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
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
        });

        Schema::table('users_documents', function (Blueprint $table) {
            $table->string('inn', 12)->change()->unique()->nullable();
            $table->string('snils', 11)->change()->unique()->nullable();
            $table->string('passport_series', 4)->change()->nullable();
            $table->string('passport_number', 6)->change()->nullable();
        });

        Schema::table('users_info', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password', 255)->change();
        });

        Schema::table('users_documents', function (Blueprint $table) {
            $table->string('inn', 255)->change()->nullable();
            $table->dropUnique('users_documents_inn_unique');
            $table->string('snils', 255)->change()->nullable();
            $table->dropUnique('users_documents_snils_unique');
            $table->string('passport_series', 255)->change()->nullable();
            $table->string('passport_number', 255)->change()->nullable();
        });

        Schema::table('users_info', function (Blueprint $table) {
            $table->text('photo')->nullable();
        });
    }
};
