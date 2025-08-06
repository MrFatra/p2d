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
            },
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
                serif: ["Merriweather", "serif"],
            },
        },
    },
    plugins: [],
};
