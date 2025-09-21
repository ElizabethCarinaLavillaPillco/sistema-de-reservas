/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.jsx",
        "./storage/framework/views/*.php",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    10: '#00f0ff',
                    50: '#e0f7f9',
                    100: '#b3e8ee',
                    200: '#86d9e3',
                    300: '#5ac9d8',
                    400: '#2dafd0',
                    500: '#14a5b5',
                    600: '#0f8a97',
                    700: '#0a6f79',
                    800: '#06545b',
                    900: '#03393d',
                },
                secondary: {
                    10: '#ffc800ff',  
                    50: '#fffbf0',
                    100: '#fff6d6',
                    200: '#ffebac',
                    300: '#ffdf83',
                    400: '#ffcf59',
                    500: '#ffc107e0',
                    600: '#f1b308ff',
                    700: '#cc9705',
                    800: '#b38104',
                    900: '#996c03',
                },
                accent: {
                    10: '#ff0800ff',
                    50: '#fef2f2',
                    100: '#fee2e2',
                    200: '#fecaca',
                    300: '#fca5a5',
                    400: '#f87171',
                    500: '#ef4444',
                    600: '#dc2626',
                    700: '#b91c1c',
                    800: '#991b1b',
                    900: '#7f1d1d',
                }
            },
            fontFamily: {
                sans: ['Poppins', 'ui-sans-serif', 'system-ui'],
            },
        },
    },
    safelist: [
        'bg-primary-500', 'text-white', 'py-20', 'text-4xl', 'container', 'mx-auto',
        'bg-gradient-to-r', 'from-primary-500', 'to-primary-700', 'rounded-full',
        'hover:bg-secondary-600', 'shadow-2xl', 'font-semibold', 'animate-fade-in'
    ],
    plugins: [],
}