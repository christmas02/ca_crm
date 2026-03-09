const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    
    safelist: [
        // Classes dynamiques pour les boutons de discours
        'border-emerald-500',
        'bg-emerald-50',
        'text-emerald-700',
        'border-rose-500',
        'bg-rose-50',
        'text-rose-700',
        'border-gray-300',
        'bg-gray-100',
        'text-gray-600',
        'hover:border-gray-400',
        'font-semibold',
        'shadow-sm',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
            },
            colors: {
                primary: {
                    50: '#FFF8EE',
                    100: '#FFEFD6',
                    200: '#FFDCA8',
                    300: '#FFC56E',
                    400: '#F5A623',
                    500: '#E89B1E',
                    600: '#D4891A',
                    700: '#B06E10',
                    800: '#8C5608',
                    900: '#6B4006',
                },
                accent: {
                    50: '#ECFDF5',
                    100: '#D1FAE5',
                    200: '#A7F3D0',
                    300: '#6EE7B7',
                    400: '#34D399',
                    500: '#10B981',
                    600: '#059669',
                    700: '#047857',
                    800: '#065F46',
                    900: '#064E3B',
                },
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
