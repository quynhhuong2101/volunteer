/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    DEFAULT: '#0F4C81', // Ocean Blue
                    light: '#357abd',
                    dark: '#0a365c',
                },
                accent: {
                    DEFAULT: '#FF6D00', // Energetic Orange
                    light: '#ff9e40',
                },
                neutral: {
                    bg: '#F4F7FE',
                    surface: '#FFFFFF',
                }
            },
            fontFamily: {
                sans: ['"Be Vietnam Pro"', 'sans-serif'],
            },
        },
    },
    plugins: [],
}
