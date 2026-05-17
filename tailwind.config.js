import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                serif: ['Playfair Display', 'serif'],
                sans: ['Inter', 'sans-serif'],
            },
            colors: {
                primary: {
                    50: '#fef2f2',
                    100: '#fee2e2',
                    500: '#ef4444',
                    600: '#dc2626',
                    700: '#b91c1c',
                    800: '#991b1b',
                    900: '#7f1d1d',
                },
                amber: {
                    50: '#fffbeb',
                    100: '#fef3c7',
                    200: '#fde68a',
                    300: '#fcd34d',
                    400: '#fbbf24',
                    500: '#f59e0b',
                    600: '#d97706',
                    700: '#b45309',
                    800: '#92400e',
                    900: '#78350f',
                    950: '#451a03',
                }
            },
            animation: {
                'fade-in': 'fadeIn 0.6s ease-out',
                'fade-in-up': 'fadeInUp 0.8s ease-out',
                'slide-in-right': 'slideInRight 0.5s ease-out',
                'bounce-slow': 'bounce 3s infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideInRight: {
                    '0%': { opacity: '0', transform: 'translateX(100%)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                }
            },
            pagination: {
                active: 'bg-red-900 text-white',
                hover: 'hover:bg-red-50',
            }
        },
    },
    safelist: [
        // Status badges - guest status colors
        'bg-stone-100', 'text-stone-600',
        'bg-green-100', 'text-green-800',
        'bg-red-100', 'text-red-800',
        'bg-amber-100', 'text-amber-800',
        // File upload button states
        'file:bg-amber-50', 'file:text-amber-700', 'hover:file:bg-amber-100',
        // Focus rings
        'focus:ring-amber-200', 'focus:border-amber-600',
        // Hover states
        'hover:bg-amber-800', 'hover:text-amber-900',
    ],
    plugins: [forms],
};
