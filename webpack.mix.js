const mix = require('laravel-mix');

mix
    .version()
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
