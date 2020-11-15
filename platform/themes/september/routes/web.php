<?php

Route::group(['namespace' => 'Theme\September\Http\Controllers', 'middleware' => 'web'], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {

        Route::get('ajax/cart', [
            'as'   => 'public.ajax.cart',
            'uses' => 'SeptemberController@ajaxCart',
        ]);

        Route::get('ajax/reviews/{productId}', [
            'as'   => 'public.ajax.reviews',
            'uses' => 'SeptemberController@ajaxReviews',
        ]);

        Route::get('orders/tracking', [
            'as'   => 'public.orders.tracking',
            'uses' => 'SeptemberController@getOrderTracking',
        ]);

        Route::get('ajax/featured-products', 'SeptemberController@getFeaturedProducts')
            ->name('public.ajax.featured-products');

        Route::get('ajax/posts', 'SeptemberController@ajaxGetPosts')->name('public.ajax.posts');
    });
});

Theme::routes();

Route::group(['namespace' => 'Theme\September\Http\Controllers', 'middleware' => 'web'], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {

        Route::get('/', 'SeptemberController@getIndex')->name('public.index');

        Route::get('sitemap.xml', [
            'as'   => 'public.sitemap',
            'uses' => 'SeptemberController@getSiteMap',
        ]);

        Route::get('{slug?}' . config('core.base.general.public_single_ending_url'), [
            'as'   => 'public.single',
            'uses' => 'SeptemberController@getView',
        ]);

    });

});
