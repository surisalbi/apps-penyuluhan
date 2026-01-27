/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#2E7D32",
                danger: "#dc2626",
                primaryDark: "#1B5E20",
            },
            borderRadius: {
                big: "3rem",
            },
        },
    },
    plugins: [],
};
