/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },

    // ⛔ Turn OFF dark mode completely
    darkMode: false,

    plugins: [require("daisyui")],

    daisyui: {
        themes: ["light"], // ✔ Only light theme
        darkTheme: false,  // ⛔ Disable dark theme
        base: true,
    },
};
