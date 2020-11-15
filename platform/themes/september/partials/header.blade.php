<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport"/>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,900&display=swap" rel="stylesheet">

        <style>
            :root {
                --color-1st: {{ theme_option('primary_color', '#026e94') }};
                --color-2nd: {{ theme_option('secondary_color', '#2c1dff') }};
                --primary-font: '{{ theme_option('primary_font', 'Poppins') }}', sans-serif;
            }
        </style>

        {!! Theme::header() !!}
    </head>
    <body>
        <header class="header header--mobile">
            <nav class="navigation--mobile">
                <div class="navigation__left">
                    @if (theme_option('logo'))
                        <a class="logo" href="{{ route('public.single') }}">
                            <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" height="60">
                        </a>
                    @endif
                </div>
                <div class="navigation__right">
                    <div class="header__actions">
                        <a class="search-btn" href="#"><i class="feather icon icon-search"></i></a>
                        @if (is_plugin_active('ecommerce'))
                            <a href="{{ route('customer.login') }}"><i class="feather icon icon-user"></i></a>
                            <a class="btn-shopping-cart" href="{{ route('customer.wish-lists') }}"><i class="feather icon icon-heart"></i>@if (auth('customer')->check())<span>{{ auth('customer')->user()->wishLists()->count() }}</span>@endif</a>
                            @if (get_ecommerce_setting('shopping_cart_enabled', '1') == '1')
                                <a class="btn-shopping-cart panel-trigger" href="#panel-cart">
                                    <i class="feather icon icon-shopping-cart"></i><span>{{ Cart::count() }}</span>
                                </a>
                            @endif
                        @endif
                        <a class="panel-trigger" href="#panel-menu"><i class="feather icon icon-menu"></i></a></div>
                </div>
            </nav>
        </header>
        <header class="header">
            <nav class="navigation">
                <div class="container">
                    <div class="navigation__left">
                        @if (theme_option('logo'))
                            <a class="logo" href="{{ route('public.single') }}">
                                <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" height="80">
                            </a>
                        @endif
                    </div>
                    <div class="navigation__center">
                        {!!
                            Menu::renderMenuLocation('main-menu', [
                                'options' => ['class' => 'menu'],
                                'view'    => 'main-menu',
                            ])
                        !!}
                    </div>
                    <div class="navigation__right">
                        <div class="header__actions">
                            <a class="search-btn" href="#"><i class="feather icon icon-search"></i></a>
                            @if (is_plugin_active('ecommerce'))
                                <a href="{{ route('customer.login') }}"><i class="feather icon icon-user"></i></a>
                                <a class="btn-shopping-cart" href="{{ route('customer.wish-lists') }}"><i class="feather icon icon-heart"></i>@if (auth('customer')->check())<span>{{ auth('customer')->user()->wishLists()->count() }}</span>@endif</a>
                                @if (get_ecommerce_setting('shopping_cart_enabled', '1') == '1')
                                    <a class="btn-shopping-cart panel-trigger" href="#panel-cart"><i class="feather icon icon-shopping-cart"></i><span>{{ Cart::count() }}</span></a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </nav>
        </header>
