let mix = require('laravel-mix');

const path = require('path');
let directory = path.basename(path.resolve(__dirname));

const source = 'platform/plugins/' + directory;
const dist = 'public/vendor/core/plugins/' + directory;

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
mix
    .sass(source + '/resources/assets/sass/ecommerce.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/ecommerce-product-attributes.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/currencies.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/review.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/customer.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/address.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/order.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/invoice.scss', dist + '/css')
    .sass(source + '/resources/assets/sass/front-theme.scss', dist + '/css')

    .js(source + '/resources/assets/js/edit-product.js', dist + '/js')
    .js(source + '/resources/assets/js/ecommerce-product-attributes.js', dist + '/js')
    .js(source + '/resources/assets/js/change-product-swatches.js', dist + '/js')
    .js(source + '/resources/assets/js/currencies.js', dist + '/js')
    .js(source + '/resources/assets/js/review.js', dist + '/js')
    .js(source + '/resources/assets/js/shipping.js', dist + '/js')
    .js(source + '/resources/assets/js/utilities.js', dist + '/js')
    .js(source + '/resources/assets/js/payment-method.js', dist + '/js')
    .js(source + '/resources/assets/js/customer.js', dist + '/js')
    .js(source + '/resources/assets/js/setting.js', dist + '/js')
    .js(source + '/resources/assets/js/front/checkout.js', dist + '/js')
    .js(source + '/resources/assets/js/order.js', dist + '/js')
    .js(source + '/resources/assets/js/order-incomplete.js', dist + '/js')
    .js(source + '/resources/assets/js/shipment.js', dist + '/js')
    .js(source + '/resources/assets/js/store-locator.js', dist + '/js')
    .js(source + '/resources/assets/js/discount.js', dist + '/js')
    .js(source + '/resources/assets/js/report.js', dist + '/js')
    .js(source + '/resources/assets/js/order-create.js', dist + '/js')
    .js(source + '/resources/assets/js/avatar.js', dist + '/js')

    .copy(dist + '/css', source + '/public/css')
    .copy(dist + '/js', source + '/public/js');
