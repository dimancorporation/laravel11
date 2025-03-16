<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemeSettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('theme_settings')->insert([
            ['id' => 1, 'theme_name' => 'blue', 'is_active' => true, 'created_at' => null, 'updated_at' => null, 'is_visible' => true, 'description' => 'Голубая тема'],
            ['id' => 2, 'theme_name' => 'green', 'is_active' => false, 'created_at' => null, 'updated_at' => null, 'is_visible' => true, 'description' => 'Зеленая тема'],
            ['id' => 3, 'theme_name' => 'red', 'is_active' => false, 'created_at' => null, 'updated_at' => null, 'is_visible' => true, 'description' => 'Красная тема'],
            ['id' => 4, 'theme_name' => 'turquoise', 'is_active' => false, 'created_at' => null, 'updated_at' => null, 'is_visible' => true, 'description' => 'Бирюзовая тема'],
            ['id' => 5, 'theme_name' => 'yellow', 'is_active' => false, 'created_at' => null, 'updated_at' => null, 'is_visible' => true, 'description' => 'Желтая тема'],
        ]);
    }
}
