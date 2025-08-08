import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.jsx",
        "./resources/**/*.vue",
        "./vendor/filament/**/*.blade.php",
        "./app/Filament/**/*.php",
    ],
    theme: {
        extend: {
            colors: {
                "custom-emerald": "#008970",
                shades: "#008970",
                foreground: "#212121",
                primary: {
                    DEFAULT: '#6366F1',
                    30: '#A6B8FF',
                    700: '#4338CA',
                },
                secondary: {
                    DEFAULT: '#D1D5DB',
                    30: '#E4E7EC',
                    700: '#9CA3AF',
                },
                success: {
                    DEFAULT: '#50C878',
                    30: '#C2E6D3',
                    700: '#3C9C5A',
                },
                info: {
                    DEFAULT: '#0096FF',
                    30: '#B8DFFF',
                    700: '#0070C0',
                },
                warning: {
                    DEFAULT: '#FFAC1C',
                    30: '#FFE2B2',
                    700: '#CC8700',
                },
                error: {
                    DEFAULT: '#F87171',
                    30: '#FECACA',
                    700: '#DC2626',
                },
            },
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
                serif: ["Merriweather", "serif"],
            },
        },
    },
    plugins: [],
};
