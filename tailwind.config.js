/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/tw-elements/js/**/*.js"
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require("tw-elements/plugin.cjs")
    ],
}