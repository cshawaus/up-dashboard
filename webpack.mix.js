const mix     = require('laravel-mix')
const webpack = require('webpack')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
  .postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('postcss-nested'),
    require('autoprefixer'),
  ])

/*
 |--------------------------------------------------------------------------
 | Webpack Options
 |--------------------------------------------------------------------------
 */

mix.webpackConfig({
  output: {
    chunkFilename: mix.inProduction() ? 'js/[name].[chunkhash].js' : 'js/[name].js',
  },

  plugins: [
    new webpack.ContextReplacementPlugin(
      /date\-fns[\/\\]/,
      new RegExp(`[/\\\\\](en-AU)[/\\\\\]`)
    ),
  ],

  resolve: {
    alias: {
      vue$: 'vue/dist/vue.runtime.esm.js',
    },
  },
})

/*
 |--------------------------------------------------------------------------
 | Hot Module Replacement
 |--------------------------------------------------------------------------
 */

mix.options({
  hmrOptions: {
      host : process.env.APP_DOMAIN,
      port : 8080,
  },
})
