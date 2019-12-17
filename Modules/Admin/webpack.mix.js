const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');


mix.js(__dirname + '/Resources/assets/js/app.js', 'public/compiled/js/modules/admin/app.js')
    .sass( __dirname + '/Resources/assets/sass/app.scss', 'public/compiled/css/modules/admin/app.css')
    .mergeManifest();

if (mix.inProduction()) {
    mix.version();
}