@props(['active', 'theme' => 'blue']) <!-- По умолчанию тема 'blue' -->

@php
    $themeColors = match ($theme) {
        'blue' => [
            'text' => [
                'active' => 'text-white',
                'inactive' => 'text-white',
                'hover' => 'text-white',
            ],
            'border' => 'border-white',
        ],
        'green','yellow' => [
            'text' => [
                'active' => 'text-black',
                'inactive' => 'text-black',
                'hover' => 'text-black',
            ],
            'border' => 'border-black',
        ],
        'red' => [
            'text' => [
                'active' => 'text-white',
                'inactive' => 'text-white',
                'hover' => 'text-white',
            ],
            'border' => 'border-red-600',
        ],
        'turquoise' => [
            'text' => [
                'active' => 'text-turquoise',
                'inactive' => 'text-turquoise',
                'hover' => 'text-turquoise',
            ],
            'border' => 'border-turquoise',
        ],
        default => [
            'text' => [
                'active' => 'text-black',
                'inactive' => 'text-gray-400',
                'hover' => 'text-gray-600',
            ],
            'border' => 'border-gray-300',
        ],
    };

    $classes = ($active ?? false)
        ? 'nav-link uppercase inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out ' . $themeColors['text']['active'] . ' ' . $themeColors['border']
        : 'nav-link uppercase inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 ' . $themeColors['text']['inactive'] . ' hover:' . $themeColors['text']['hover'] . ' hover:border-gray-300 focus:outline-none focus:' . $themeColors['text']['hover'] . ' focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => 'group ' . $classes]) }}>
    {{ $slot }}
</a>
