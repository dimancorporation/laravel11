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
            $table->string('phone')->nullable();
            $table->enum('role', ['admin', 'user', 'blocked'])->default('user');
            $table->unsignedBigInteger('id_b24')->nullable();
            $table->boolean('is_first_auth')->default(true); // Первая авторизация пользователя в личный кабинет
            $table->boolean('is_registered_myself')->default(false); // Самостоятельная регистрация пользователя через форму регистрации
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role', 'id_b24', 'is_first_auth', 'is_registered_myself']);
        });
    }
};
