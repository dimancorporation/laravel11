<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/icons/favicon_bank.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Get active css theme -->
        @php
            $activeTheme = session('active_theme', 'blue');
            $themePath = public_path('css/themes/' . $activeTheme . '.css');
            $themeUrl = asset('css/themes/' . (file_exists($themePath) ? $activeTheme : 'blue') . '.css');
        @endphp
        <link href="{{ $themeUrl }}" rel="stylesheet">
    </head>
    <body class="font-sans antialiased {{ $activeTheme }}-theme">
        <div class="min-h-screen bg-gray-100 bg-transparent">
            @include('layouts.navigation', ['theme' => $activeTheme])

            <!-- Page Heading -->
            @isset($header)
{{--                <header class="bg-white shadow">--}}
{{--                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">--}}
{{--                        {{ $header }}--}}
{{--                    </div>--}}
{{--                </header>--}}
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
