@extends('plugins/ecommerce::orders.master')
@section('title')
    {{ __('Shipping information') }}
@stop
@section('content')
    @if (Cart::count() > 0)
        {!! Form::open(['route' => ['public.checkout.save-information', $token], 'class' => 'checkout-form', 'id' => 'checkout-form']) !!}
        <input type="hidden" name="checkout-token" id="checkout-token" value="{{ $token }}">

        @php
            $productIds = Cart::content()->pluck('id')->toArray();
            if ($productIds) {
                $products = get_products([
                    'condition' => [
                        ['ec_products.id', 'IN', $productIds],
                    ],
                ]);
            }
        @endphp

        <div class="row">
            <div class="col-lg-7 col-md-6 col-12 left">

                @if (theme_option('logo'))
                    <div class="checkout-logo">
                        <a href="{{ url('/') }}" title="{{ theme_option('site_title') }}">
                            <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" class="img-fluid" width="150" alt="{{ theme_option('site_title') }}" />
                        </a>
                    </div>
                @endif

                <ol class="breadcrumb d-none d-sm-flex">
                    <li class="breadcrumb-item"><a href="{{ route('public.cart') }}">{{ __('Cart') }}</a></li>
                    <li class="breadcrumb-item">{{ __('Shipping information') }}</li>
                    <li class="breadcrumb-item">{{ __('Payment information') }}</li>
                </ol>

                <!-- for mobile device display -->
                <div class="d-lg-none d-sm-block" style="padding: 0 15px;">
                    <div id="cart-item">
                        @if (isset($products) && $products)
                            <p>{{ __('Product(s)') }}:</p>
                            @foreach (Cart::content() as $key => $cartItem)
                                @php
                                    $product = $products->where('id', $cartItem->id)->first();
                                @endphp
                                @if (!empty($product))
                                    <div class="row cart-item">
                                        <div class="col-3">
                                            <div class="checkout-product-img-wrapper">
                                                <img class="item-thumb img-thumbnail img-rounded"
                                                     src="{{ $cartItem->options['image']}}"
                                                     alt="{{ $product->name ?? '' }}">
                                                <span class="checkout-quantity">{{ $cartItem->qty }}</span>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <p style="margin-bottom: 0;">{{ $product->name }}</p>
                                            <p>
                                                <small>
                                                    @php
                                                        $attributes = get_product_attributes($product->id);
                                                    @endphp

                                                    @if (!empty($attributes))
                                                        @foreach ($attributes as $attr)
                                                            @if (!$loop->last)
                                                                {{ $attr->attribute_set_title }}: {{ $attr->title }},
                                                            @else
                                                                {{ $attr->attribute_set_title }}: {{ $attr->title }}
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </small>
                                            </p>
                                        </div>
                                        <div class="col-4 float-right">
                                            <p>{{ format_price($cartItem->price) }}</p>
                                        </div>
                                    </div> <!--  /item -->
                                @endif
                            @endforeach
                        @endif

                        <div class="row">
                            <div class="col-6">
                                <p>{{ __('Subtotal') }}:</p>
                            </div>
                            <div class="col-6">
                                <p class="price-text sub-total-text text-right"> {{ format_price(Cart::rawSubTotal()) }} </p>
                            </div>
                        </div>
                        @if (session('applied_coupon_code'))
                            <hr/>
                            <div class="row coupon-information">
                                <div class="col-lg-7 col-md-8 col-5">
                                    <p>{{ __('Coupon code') }}:</p>
                                </div>
                                <div class="col-lg-5 col-md-4 col-5">
                                    <p class="price-text coupon-code-text"> {{ session('applied_coupon_code') }} </p>
                                </div>
                            </div>
                        @endif
                        @if ($couponDiscountAmount > 0)
                            <hr>
                            <div class="row price discount-amount">
                                <div class="col-lg-7 col-md-8 col-5">
                                    <p>{{ __('Coupon code discount amount') }}:</p>
                                </div>
                                <div class="col-lg-5 col-md-4 col-5">
                                    <p class="price-text total-discount-amount-text"> {{ format_price($couponDiscountAmount) }} </p>
                                </div>
                            </div>
                        @endif
                        @if ($promotionDiscountAmount > 0)
                            <hr>
                            <div class="row">
                                <div class="col-lg-7 col-md-8 col-5">
                                    <p>{{ __('Promotion discount amount') }}:</p>
                                </div>
                                <div class="col-lg-5 col-md-4 col-5">
                                    <p class="price-text"> {{ format_price($promotionDiscountAmount) }} </p>
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-6">
                                <p>{{ __('Shipping fee') }}:</p>
                            </div>
                            <div class="col-6 float-right">
                                <p class="price-text shipping-price-text">-</p>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-6">
                                <p>{{ __('Total') }}:</p>
                            </div>
                            <div class="col-6 float-right">
                                <p class="total-text raw-total-text"
                                   data-price="{{ Cart::rawTotal() }}"> {{ format_price(Cart::rawTotal() - $promotionDiscountAmount - $couponDiscountAmount) }} </p>
                            </div>
                        </div>

                    </div>

                    <div>
                        <hr/>
                        @include('plugins/ecommerce::themes.discounts.partials.form')
                        <hr/>
                    </div>
                </div> <!-- /mobiile display -->

                <div class="form-checkout">
                    @include('plugins/ecommerce::themes.customers.address.partials.address-form', compact('sessionCheckoutData'))
                    <hr>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6 d-none d-md-block" style="line-height: 53px">
                                <a class="text-info" href="{{ route('public.cart') }}"><i class="fas fa-long-arrow-alt-left"></i> {{ __('Back to cart') }}</a>
                            </div>
                            <div class="col-md-6 col-sm-12 col-12">
                                <button type="submit"
                                        class="btn payment-checkout-btn payment-checkout-btn-step float-right">
                                    {{ __('Continue to payment method') }}
                                </button>
                            </div>
                        </div>
                    </div>

                </div> <!-- /form checkout -->

            </div>
            <!---------------------- start right column ---------------- -->
            <div class="col-lg-5 col-md-6 d-none d-md-block right" id="main-checkout-product-info">
                @if (isset($products) && $products)
                    @foreach (Cart::content() as $key => $cartItem)
                        @php
                            $product = $products->where('id', $cartItem->id)->first();
                        @endphp
                        @if (!empty($product))
                            <div class="row product-item">
                                <div class="col-lg-2 col-md-2">
                                    <div class="checkout-product-img-wrapper">
                                        <img class="item-thumb img-thumbnail img-rounded"
                                             src="{{ $cartItem->options['image']}}" alt="{{ $product->name ?? '' }}">
                                        <span class="checkout-quantity">{{ $cartItem->qty }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-5">
                                    <p style="margin-bottom: 0;">{{ $product->name }}</p>
                                    <p>
                                        <small>
                                            @php $attributes = get_product_attributes($product->id) @endphp
                                            @if (!empty($attributes))
                                                @foreach ($attributes as $attr)
                                                    @if (!$loop->last)
                                                        {{ $attr->attribute_set_title }}: {{ $attr->title }},
                                                    @else
                                                        {{ $attr->attribute_set_title }}: {{ $attr->title }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </small>
                                    </p>
                                </div>
                                <div class="col-lg-4 col-md-4 col-4 float-right">
                                    <p class="price-text">
                                        <span>{{ format_price($cartItem->price) }}</span>
                                    </p>
                                </div>
                            </div> <!--  /item -->
                        @endif
                    @endforeach
                @endif
                <hr/>
                @include('plugins/ecommerce::themes.discounts.partials.form')
                <hr/>
                <div class="row price">
                    <div class="col-lg-7 col-md-8 col-5">
                        <p>{{ __('Subtotal') }}:</p>
                    </div>
                    <div class="col-lg-5 col-md-4 col-5">
                        <p class="price-text sub-total-text"> {{ format_price(Cart::rawSubTotal()) }} </p>
                    </div>
                </div>
                @if (session('applied_coupon_code'))
                    <div class="row coupon-information">
                        <div class="col-lg-7 col-md-8 col-5">
                            <p>{{ __('Coupon code') }}:</p>
                        </div>
                        <div class="col-lg-5 col-md-4 col-5">
                            <p class="price-text coupon-code-text"> {{ session('applied_coupon_code') }} </p>
                        </div>
                    </div>
                @endif
                @if ($couponDiscountAmount > 0)
                    <div class="row price discount-amount">
                        <div class="col-lg-7 col-md-8 col-5">
                            <p>{{ __('Coupon code discount amount') }}:</p>
                        </div>
                        <div class="col-lg-5 col-md-4 col-5">
                            <p class="price-text total-discount-amount-text"> {{ format_price($couponDiscountAmount) }} </p>
                        </div>
                    </div>
                @endif
                @if ($promotionDiscountAmount > 0)
                    <div class="row">
                        <div class="col-lg-7 col-md-8 col-5">
                            <p>{{ __('Promotion discount amount') }}:</p>
                        </div>
                        <div class="col-lg-5 col-md-4 col-5">
                            <p class="price-text"> {{ format_price($promotionDiscountAmount) }} </p>
                        </div>
                    </div>
                @endif
                <div class="row shipment">
                    <div class="col-lg-7 col-md-8 col-5">
                        <p>{{ __('Shipping fee') }}:</p>
                    </div>
                    <div class="col-lg-5 col-md-4 col-5 float-right">
                        <p class="price-text shipping-price-text"> - </p>
                    </div>
                </div>
                <hr/>
                <div class="row total-price">
                    <div class="col-lg-7 col-md-8 col-5">
                        <p>{{ __('Total') }}:</p>
                    </div>
                    <div class="col-lg-5 col-md-4 col-5 float-right">
                        <p class="total-text raw-total-text"
                           data-price="{{ Cart::rawTotal() }}"> {{ format_price(Cart::rawTotal() - $promotionDiscountAmount - $couponDiscountAmount) }} </p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning">
                    <p>{!! __('No products in cart. :link!', ['link' => Html::link(url('/'), __('Back to shopping'))]) !!}</p>
                </div>
            </div>
        </div>
    @endif
@stop
