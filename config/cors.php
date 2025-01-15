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

    'allowed_methods' => ['*'], // Разрешённые методы

    'allowed_origins' => ['*'], // Разрешённые источники (временно разрешаем всё)

//    'allowed_origins' => [
//        'https://ee5c-94-180-116-162.ngrok-free.app',
//        'https://ee5c-94-180-116-162.ngrok-free123.app',
//        'https://d1a2-155-94-251-73.ngrok-free.app',
//        'https://6gxnnx-94-180-116-162.ru.tuna.am',
//    ], // Разрешённые источники (временно разрешаем всё)

    'allowed_origins_patterns' => [], // Шаблон для разрешений

    'allowed_headers' => ['*'], // Разрешённые заголовки

    'exposed_headers' => [], // Экспонируемые заголовки

    'max_age' => 3600, // Время жизни политики в секундах

    'supports_credentials' => false, // Поддержка куков и аутентификации
];
