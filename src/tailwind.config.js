/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./App/**/*.{html,js,blade.php}"],
  // purge: ["./**/*.{html,js,blade.php}"],
  theme: {
    extend: {
      spacing: {
        '120': '30rem',
      }
    },
  },
  plugins: [],
}
