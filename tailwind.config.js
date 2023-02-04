/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      "./resources/views/**/*.blade.php",
      "./resources/js/**/*.{vue,ts}",
  ],
  theme: {
    extend: {},
  },
  plugins: [
      require('@tailwindcss/forms'),
  ],
}
