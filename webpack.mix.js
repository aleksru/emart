const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

// Если задана опция --module=[Module], то билдим
// соответствующий модуль, иначе билдим основное приложение.
if (process.env.npm_config_module) {
    require(`${__dirname}/Modules/${process.env.npm_config_module}/webpack.mix.js`);
    return;
}

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
    .webpackConfig({
        module: {
            rules: [{
                test: /\.js?$/,
                use: [{
                    loader: 'babel-loader',
                    options: mix.config.babel()
                }]
            }]
        }
    })
   .sass('resources/sass/app.scss', 'public/css')
    .mergeManifest();
