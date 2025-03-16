<?php

namespace Database\Seeders;

use App\Models\B24Status;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class B24StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Не активно',
                "created_at" => Carbon::now(),
            ],
            [
                'name' => 'Знакомство',
                "created_at" => Carbon::now(),
            ],
            [
                'name' => 'Правовой анализ',
                "created_at" => Carbon::now(),
            ],
            [
                'name' => 'Запросы БКИ',
                "created_at" => Carbon::now(),
            ],
            [
                'name' => 'Поиск имущества и сделок',
                "created_at" => Carbon::now(),
            ],
            [
                'name' => 'Реестр документов',
                "created_at" => Carbon::now(),
            ],
            [
                'name' => 'Сбор документов',
                "created_at" => Carbon::now(),
            ],
            [
                'name' => 'Готов на подачу в АС',
                "created_at" => Carbon::now(),
            ],
            [
                'name' => 'Введение процедуры БФЛ',
                "created_at" => Carbon::now(),
            ],
            [
                'name' => 'Судебный процесс',
                "created_at" => Carbon::now(),
            ],
            [
                'name' => 'Завершение суда',
                "created_at" => Carbon::now(),
            ],
            [
                'name' => 'Списание долга',
                "created_at" => Carbon::now(),
            ],
            [
                'name' => 'Должник',
                "created_at" => Carbon::now(),
            ],
        ];
        B24Status::query()->insert($data);
    }
}
