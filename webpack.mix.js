const mix = require('laravel-mix');
mix.sass('resources/sass/app.scss', 'public/css');
mix.sass('resources/sass/custom.scss', 'public/css');
mix.sass('resources/sass/variables.scss', 'public/css');