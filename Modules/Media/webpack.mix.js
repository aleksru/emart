const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.js(__dirname + '/Resources/js/app.js', 'public/compiled/js/modules/media/app.js')
    .sass( __dirname + '/Resources/sass/app.scss', 'public/compiled/css/modules/media/app.css')
    .mergeManifest();

if (mix.inProduction()) {
    mix.version();
}