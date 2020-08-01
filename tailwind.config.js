const {
  variants,
} = require('tailwindcss/defaultConfig')

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
        'yellow'      : '#ffef6b',
        'up'          : '#ff7a64',
      },
    },
  },

  variants: {
    translate : [...variants.translate, 'group-hover'],
    scale     : [...variants.scale, 'group-hover'],
  },

  plugins: [
    require('tailwind-css-variables')(),
  ],
}
