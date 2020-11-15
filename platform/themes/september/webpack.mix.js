let mix = require('laravel-mix');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = 'platform/themes/' + directory;
const dist = 'public/themes/' + directory;

mix
    .sass(source + '/assets/sass/style.scss', dist + '/css')
    .copy(dist + '/css/style.css', source + '/public/css')
    .scripts([
        source + '/assets/js/backend.js',
        source + '/assets/js/main.js',
    ], dist + '/js/script.js')
    .copy(dist + '/js/script.js', source + '/public/js')

    .js(source + '/assets/js/components.js', dist + '/js')
    .copy(dist + '/js/components.js', source + '/public/js');
