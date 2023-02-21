/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./App/**/*.{html,js,blade.php}"],
  // purge: ["./**/*.{html,js,blade.php}"],
  theme: {
    extend: {
      spacing: {
        '120': '30rem',
      },
      keyframes: {
        grayTransition: {
          '0%': { background: 'white' },
          '100%': { background: 'gray' },
        },
      },
      animation: {
        'buttonTransition': 'grayTransition .2s linear infinite',
      },
    },
  },
  plugins: [],
}
