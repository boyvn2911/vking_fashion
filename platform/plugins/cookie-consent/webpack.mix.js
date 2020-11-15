let mix = require('laravel-mix');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = 'platform/plugins/' + directory;
const dist = 'public/vendor/core/plugins/' + directory;

mix
    .sass(source + '/resources/assets/sass/cookie-consent.scss', dist + '/css')
    .copy(dist + '/css', source + '/public/css')

    .js(source + '/resources/assets/js/cookie-consent.js', dist + '/js')
    .copy(dist + '/js', source + '/public/js');
