<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('b24_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table('b24_statuses')->insert([
            [
                'name' => 'Знакомство',
            ],
            [
                'name' => 'Правовой анализ',
            ],
            [
                'name' => 'Запросы БКИ',
            ],
            [
                'name' => 'Поиск имущества и сделок',
            ],
            [
                'name' => 'Реестр документов',
            ],
            [
                'name' => 'Сбор документов',
            ],
            [
                'name' => 'Готов на подачу в АС',
            ],
            [
                'name' => 'Введение процедуры БФЛ',
            ],
            [
                'name' => 'Судебный процесс',
            ],
            [
                'name' => 'Завершение суда',
            ],
            [
                'name' => 'Списание долга',
            ],
            [
                'name' => 'Должник',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b24_statuses');
    }
};
