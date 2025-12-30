import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // 60% - Primary Green Pastel
                primary: {
                    50: '#F0F9F4',
                    100: '#E0F2E9',
                    200: '#C5E8D2',
                    300: '#A8D8B9',
                    400: '#8BC9A4',
                    500: '#6EBA8F',
                    600: '#52A87A',
                    700: '#3D8A60',
                    800: '#2D5A3D',
                    900: '#1F4029',
                    DEFAULT: '#A8D8B9',
                },
                // 30% - Secondary Neutral
                secondary: {
                    50: '#FFFFFF',
                    100: '#F8FAF9',
                    200: '#F1F5F3',
                    300: '#E2E8E5',
                    400: '#C4CFC8',
                    500: '#9BA8A0',
                    DEFAULT: '#F8FAF9',
                },
                // 10% - Accent Dark Green
                accent: {
                    50: '#E8F5EC',
                    100: '#C5E8D2',
                    200: '#8BC9A4',
                    300: '#52A87A',
                    400: '#3D7A52',
                    500: '#2D5A3D',
                    600: '#1F4029',
                    700: '#152D1C',
                    DEFAULT: '#2D5A3D',
                },
                // Status Colors
                success: {
                    light: '#D1FAE5',
                    DEFAULT: '#10B981',
                    dark: '#047857',
                },
                warning: {
                    light: '#FEF3C7',
                    DEFAULT: '#F59E0B',
                    dark: '#D97706',
                },
                danger: {
                    light: '#FEE2E2',
                    DEFAULT: '#EF4444',
                    dark: '#DC2626',
                },
                info: {
                    light: '#DBEAFE',
                    DEFAULT: '#3B82F6',
                    dark: '#2563EB',
                },
            },
            boxShadow: {
                'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                'card': '0 4px 6px -1px rgba(45, 90, 61, 0.1), 0 2px 4px -1px rgba(45, 90, 61, 0.06)',
            },
            borderRadius: {
                'xl': '1rem',
                '2xl': '1.5rem',
                '3xl': '2rem',
            },
        },
    },

    plugins: [forms],
};
