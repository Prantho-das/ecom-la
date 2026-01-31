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

    // ✅ Enable dark mode via class
    darkMode: "class",

    plugins: [require("daisyui")],

    daisyui: {
        themes: ["light", "dark"], // ✅ Support both themes
        base: true,
    },
};
