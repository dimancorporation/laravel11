<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*'], // Маршрут, на котором действует CORS

    //'allowed_methods' => ['POST'], // Разрешаем только POST-запросы
    'allowed_methods' => ['*'], // Разрешённые методы

//    'allowed_origins' => ['*'], // Разрешённые источники (временно разрешаем всё)

//    'allowed_origins_patterns' => [], // Шаблон для разрешений

    //'allowed_origins' => ['*'], // Разрешённые источники (временно разрешаем всё)
    'allowed_origins' => [
        'https://bankrotof.bitrix24.ru', // Разрешенный домен Bitrix24
    ],

    //'allowed_origins_patterns' => [], // Шаблон для разрешений
    'allowed_origins_patterns' => [
        'https://.*\.tinkoff\.ru', // Регулярное выражение для tinkoff.ru и всех его поддоменов
    ],

    /*
    // Явно разрешенные домены (без поддоменов)
    'allowed_origins' => [
        // Здесь можно указать конкретные домены, если нужно
    ],

    // Разрешенные домены и поддомены через регулярные выражения
    'allowed_origins_patterns' => [
        'https://.*\.tinkoff\.ru', // Разрешаем tinkoff.ru и все его поддомены
        'https://.*\.bitrix24\.ru', // Разрешаем bitrix24.ru и все его поддомены
    ],
    */
    'allowed_headers' => ['*'], // Разрешённые заголовки

    'exposed_headers' => [], // Экспонируемые заголовки

    'max_age' => 3600, // Время жизни политики в секундах

    'supports_credentials' => false, // Поддержка куков и аутентификации
];
