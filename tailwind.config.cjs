/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.jsx",
        "./resources/**/*.tsx",
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
                    10: '#ffc800',  
                    50: '#fffbf0',
                    100: '#fff6d6',
                    200: '#ffebac',
                    300: '#ffdf83',
                    400: '#ffcf59',
                    500: '#ffc107',
                    600: '#f1b308',
                    700: '#cc9705',
                    800: '#b38104',
                    900: '#996c03',
                },
                accent: {
                    10: '#ff0800',
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
                },
                ocean: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                }
            },
            fontFamily: {
                sans: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                display: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            },
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
                'gradient-primary': 'linear-gradient(135deg, #14a5b5 0%, #0a6f79 100%)',
                'gradient-secondary': 'linear-gradient(135deg, #ffc107 0%, #cc9705 100%)',
                'gradient-ocean': 'linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%)',
                'gradient-neon': 'linear-gradient(90deg, #00f0ff, #14a5b5, #00f0ff)',
            },
            animation: {
                'fade-in': 'fadeIn 0.8s ease-out forwards',
                'fade-in-up': 'fadeInUp 0.6s ease-out forwards',
                'fade-in-down': 'fadeInDown 0.6s ease-out forwards',
                'slide-in-left': 'slideInLeft 0.6s ease-out forwards',
                'slide-in-right': 'slideInRight 0.6s ease-out forwards',
                'float': 'float 3s ease-in-out infinite',
                'blob': 'blob 7s infinite',
                'glow': 'glow 4s infinite alternate',
                'pulse-glow': 'pulseGlow 2s ease-in-out infinite',
                'shimmer': 'shimmer 2s linear infinite',
                'bounce-slow': 'bounce 3s infinite',
                'spin-slow': 'spin 3s linear infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(30px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeInDown: {
                    '0%': { opacity: '0', transform: 'translateY(-30px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideInLeft: {
                    '0%': { opacity: '0', transform: 'translateX(-50px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                slideInRight: {
                    '0%': { opacity: '0', transform: 'translateX(50px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-10px)' },
                },
                blob: {
                    '0%': { transform: 'translate(0px, 0px) scale(1)' },
                    '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                    '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                    '100%': { transform: 'translate(0px, 0px) scale(1)' },
                },
                glow: {
                    '0%': { boxShadow: '0 0 5px rgba(0, 240, 255, 0.5)' },
                    '50%': { boxShadow: '0 0 20px rgba(0, 240, 255, 0.8), 0 0 30px rgba(0, 240, 255, 0.6)' },
                    '100%': { boxShadow: '0 0 5px rgba(0, 240, 255, 0.5)' },
                },
                pulseGlow: {
                    '0%, 100%': { boxShadow: '0 0 10px rgba(20, 165, 181, 0.5)' },
                    '50%': { boxShadow: '0 0 25px rgba(20, 165, 181, 0.8), 0 0 40px rgba(20, 165, 181, 0.4)' },
                },
                shimmer: {
                    '0%': { backgroundPosition: '-1000px 0' },
                    '100%': { backgroundPosition: '1000px 0' },
                },
            },
            boxShadow: {
                'neon': '0 0 5px theme("colors.primary.10"), 0 0 20px theme("colors.primary.500")',
                'neon-secondary': '0 0 5px theme("colors.secondary.10"), 0 0 20px theme("colors.secondary.500")',
                'glow-sm': '0 0 15px rgba(20, 165, 181, 0.5)',
                'glow-md': '0 0 30px rgba(20, 165, 181, 0.6)',
                'glow-lg': '0 0 45px rgba(20, 165, 181, 0.7)',
                'inner-glow': 'inset 0 0 20px rgba(20, 165, 181, 0.3)',
            },
            backdropBlur: {
                xs: '2px',
            },
            transitionDuration: {
                '400': '400ms',
                '600': '600ms',
            },
            spacing: {
                '128': '32rem',
                '144': '36rem',
            },
            borderRadius: {
                '4xl': '2rem',
                '5xl': '2.5rem',
            },
        },
    },
    safelist: [
        // Backgrounds
        'bg-primary-500',
        'bg-primary-600',
        'bg-secondary-500',
        'bg-gradient-to-r',
        'bg-gradient-to-br',
        'from-primary-500',
        'to-primary-700',
        'from-secondary-500',
        'to-secondary-700',
        
        // Text
        'text-white',
        'text-primary-500',
        'text-secondary-500',
        'text-4xl',
        'text-5xl',
        
        // Spacing
        'py-20',
        'px-6',
        'container',
        'mx-auto',
        
        // Effects
        'rounded-full',
        'rounded-2xl',
        'hover:bg-secondary-600',
        'shadow-2xl',
        'shadow-neon',
        'font-semibold',
        
        // Animations
        'animate-fade-in',
        'animate-float',
        'animate-glow',
        'animation-delay-100',
        'animation-delay-200',
        'animation-delay-300',
        'animation-delay-400',
        'animation-delay-500',
        'animation-delay-600',
        'animation-delay-700',
        'animation-delay-800',
    ],
    plugins: [],
}