module.exports = function (mix) {
    mix.js(__dirname + '/Resources/js/app.js', 'compiled/js/modules/media/app.js')
        .sass( __dirname + '/Resources/sass/app.scss', 'compiled/css/modules/media/app.css');
}