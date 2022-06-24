let mix = require('laravel-mix');

mix.postCss('resources/css/preview.css', 'dist/css');
mix.js('resources/js/addon.js', 'dist/js').vue();
