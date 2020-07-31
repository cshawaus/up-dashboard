module.exports = {
  purge: [
    './resources/js/**/*.js',
    './resources/js/**/*.vue',
    './resources/views/**/*.blade.php',
  ],

  theme: {
    extend: {
      colors: {
        'offset-grey' : '#242430',
        'up'          : '#ff7a64',
      },
    },
  },

  plugins: [
    require('tailwind-css-variables')(),
  ],
}
