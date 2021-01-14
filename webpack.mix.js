const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/sass/main.sass', 'public/css');

mix.copyDirectory('resources/icons', 'public/icons');
mix.copyDirectory('resources/img', 'public/img');
mix.copyDirectory('resources/js', 'public/js');

mix.browserSync('http://localhost:8000/');
