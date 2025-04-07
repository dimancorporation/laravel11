<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Models\ThemeSetting;
use App\Models\Setting;

class SetActiveTheme
{
    public function handle($request, Closure $next)
    {
        // Проверяем кэш на наличие активной темы
        $activeTheme = Cache::get('active_theme');
        $themeCacheDuration = Setting::getValueByCode('THEME_CACHE_DURATION') ?? 3600; // время кеширования в секундах (по умолчанию 3600 секунд = 1 час)

        if (!$activeTheme) {
            // Если нет, получаем из базы данных
            $activeTheme = ThemeSetting::where('is_active', true)->first();
            $activeThemeName = $activeTheme ? $activeTheme->theme_name : 'default';
            Cache::put('active_theme', $activeThemeName, $themeCacheDuration);
        } else {
            $activeThemeName = $activeTheme;
        }

        // Обновляем сессию только при необходимости
        if (Session::get('active_theme') !== $activeThemeName) {
            Session::put('active_theme', $activeThemeName);
        }

        // Делаем переменную доступной во всех Blade-шаблонах
        //view()->share('activeTheme', $activeThemeName);

        return $next($request);
    }
}
