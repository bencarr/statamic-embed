/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      'resources/views/**/*',
  ],
  theme: {
    extend: {},
  },
  plugins: [
      require('@tailwindcss/aspect-ratio'),
      require('@tailwindcss/line-clamp'),
  ],
}
