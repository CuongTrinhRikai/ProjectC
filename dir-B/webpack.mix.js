const mix = require('laravel-mix');

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
    .sass('resources/sass/app.scss', 'public/css');

mix.js('resources/asset/system/js/system.js', 'public/compiledCssAndJs/js/')
    .sass('resources/asset/system/styles/system.scss', 'public/compiledCssAndJs/css')
    .options({
        processCssUrls: false,
    });
