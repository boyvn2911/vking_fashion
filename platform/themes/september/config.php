<?php

use Botble\Theme\Theme;

return [

    /*
    |--------------------------------------------------------------------------
    | Inherit from another theme
    |--------------------------------------------------------------------------
    |
    | Set up inherit from another if the file is not exists,
    | this is work with "layouts", "partials" and "views"
    |
    | [Notice] assets cannot inherit.
    |
    */

    'inherit' => null, //default

    /*
    |--------------------------------------------------------------------------
    | Listener from events
    |--------------------------------------------------------------------------
    |
    | You can hook a theme when event fired on activities
    | this is cool feature to set up a title, meta, default styles and scripts.
    |
    | [Notice] these event can be override by package config.
    |
    */

    'events' => [

        // Listen on event before render a theme,
        // this event should call to assign some assets,
        // breadcrumb template.
        'beforeRenderTheme' => function (Theme $theme)
        {
            // You may use this event to set up your assets.
            $theme->asset()->usePath()->add('font-awesome', 'plugins/font-awesome/css/font-awesome.min.css');
            $theme->asset()->usePath()->add('feather-font', 'fonts/feather-font/css/iconfont.css');
            $theme->asset()->usePath()->add('bootstrap-css', 'plugins/bootstrap/css/bootstrap.min.css');
            $theme->asset()->usePath()->add('slick-css', 'plugins/slick/slick.css');
            $theme->asset()->usePath()->add('jquery-bar-rating', 'plugins/jquery-bar-rating/themes/fontawesome-stars.css');
            $theme->asset()->usePath()->add('nouislider-css', 'plugins/nouislider/nouislider.min.css');
            $theme->asset()->usePath()->add('style', 'css/style.css', [], [], '1.0.10');

            $theme->asset()->container('header')->usePath()->add('jquery', 'plugins/jquery.min.js');
            $theme->asset()->container('footer')->usePath()->add('popper', 'plugins/popper.min.js');
            $theme->asset()->container('footer')->usePath()->add('bootstrap-js', 'plugins/bootstrap/js/bootstrap.min.js');
            $theme->asset()->container('footer')->usePath()->add('slick-js', 'plugins/slick/slick.min.js');
            $theme->asset()->container('footer')->usePath()->add('jquery-bar-rating-js', 'plugins/jquery-bar-rating/jquery.barrating.min.js');
            $theme->asset()->container('footer')->usePath()->add('nouislider-js', 'plugins/nouislider/nouislider.min.js');
            $theme->asset()->container('footer')->usePath()->add('equal-height-js', 'plugins/jquery.matchHeight-min.js');
            $theme->asset()->container('footer')->usePath()->add('script', 'js/script.js', [], [], '1.0.10');
            $theme->asset()->container('footer')->usePath()->add('components-js', 'js/components.js', [], [], '1.0.10');

            if (function_exists('shortcode')) {
                $theme->composer(['index', 'page', 'post'], function (\Botble\Shortcode\View\View $view) {
                    $view->withShortcodes();
                });
            }

            $theme->partialComposer(['short-codes.featured-products'], function (\Illuminate\View\View $view) {
                $view->with('customer', auth('customer')->check() ? auth('customer')->user()->load('wishLists') : null);
            });

            $theme->composer([
                'ecommerce.brand',
                'ecommerce.product-category',
                'ecommerce.product-tag',
                'ecommerce.product',
                'ecommerce.products-archive',
                'ecommerce.search',
            ], function (\Illuminate\View\View $view) {
                $view->with('customer', auth('customer')->check() ? auth('customer')->user()->load('wishLists') : null);
            });
        },
    ]
];
