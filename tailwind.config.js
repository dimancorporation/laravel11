import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'custom-blue': {
                    500: '#4b81bf', // Основной цвет
                    700: '#044187', // Тёмный оттенок
                },
                'custom-turquoise': {
                    500: '#cce8e8', // Основной цвет
                    700: '#629998', // Тёмный оттенок
                },
                'custom-yellow': {
                    500: '#fff5cc', // Основной цвет
                    700: '#e0b507', // Тёмный оттенок
                },
                'custom-green': {
                    500: '#a1d9b3', // Основной цвет
                    700: '#1c7538', // Тёмный оттенок
                },
                'custom-red': {
                    500: '#ffc8c4', // Основной цвет
                    700: '#a8241b', // Тёмный оттенок
                },
            },
        },
    },

    plugins: [
        forms,
        require('flowbite/plugin')({
            wysiwyg: true,
        }),
        require('flowbite-typography'),
    ],
};
