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

mix.sass('resources/sass/settings.sass', 'public/css');
mix.sass('resources/sass/default.sass', 'public/css');
mix.sass('resources/sass/login.sass', 'public/css');
mix.sass('resources/sass/navigation.sass', 'public/css');
mix.sass('resources/sass/movie.sass', 'public/css');

mix.copyDirectory('resources/icons', 'public/icons');

mix.browserSync('http://localhost:8000/');
