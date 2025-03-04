<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\ThemeSetting;

class SetActiveTheme
{
    public function handle($request, Closure $next)
    {
        // Получаем активную тему из базы данных
        $activeTheme = ThemeSetting::where('is_active', true)->first();

        // Если тема не найдена, используем тему по умолчанию
        if (!$activeTheme) {
            Session::put('active_theme', 'default');
            return $next($request);
        }

        // Проверяем, есть ли тема в сессии и совпадает ли она с активной темой в БД
        if (!Session::has('active_theme') || Session::get('active_theme') !== $activeTheme->theme_name) {
            // Обновляем тему в сессии
            Session::put('active_theme', $activeTheme->theme_name);
        }

        return $next($request);
    }
}
