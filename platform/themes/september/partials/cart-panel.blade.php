<div class="cart--mini">
    <div class="cart__items">
        @if (Cart::count() > 0)
            @php
                $products = [];
                $productIds = Cart::content()->pluck('id')->toArray();

                if ($productIds) {
                    $products = get_products([
                        'condition' => [
                            ['ec_products.id', 'IN', $productIds],
                        ],
                        'with' => ['slugable'],
                    ]);
                }
            @endphp
            @if (count($products))
                @foreach(Cart::content() as $key => $cartItem)
                    @php
                        $product = $products->where('id', $cartItem->id)->first();
                    @endphp

                    @if (!empty($product))
                        <article class="product--on-cart">
                            <div class="product__thumbnail"><a href="{{ $product->url }}"><img src="{{ $cartItem->options['image'] }}" alt="{{ $product->name }}"></a></div>
                            <div class="product__content">
                                <a class="product__remove remove-cart-button" href="{{ route('public.cart.remove', $cartItem->rowId) }}">
                                    <i class="feather icon icon-x"></i>
                                </a>
                                <a href="{{ $product->url }}">{{ $product->name }}</a><small>{{ $cartItem->qty }} x <span class="cart-price">{{ format_price($cartItem->price) }}</span></small>
                            </div>
                        </article>
                    @endif
                @endforeach
            @endif
        @else
            <p class="text-center">{{ __('Your cart is empty!') }}</p>
        @endif
    </div>
    @if (Cart::count() > 0)
        <div class="cart__footer">
            <div class="cart__summary">
                <p><strong>{{ __('Sub Total') }}:</strong><span><strong>{{ format_price(Cart::rawTotal()) }}</strong></span></p>
            </div>
            @if (Cart::rawTotal())
                <div class="cart__actions">
                    @if (session('tracked_start_checkout'))
                        <p><a class="btn--custom btn--rounded" href="{{ route('public.checkout.information', session('tracked_start_checkout')) }}">{{ __('Checkout') }} <i class="feather icon-arrow-right"></i></a></p>
                    @endif
                    <p><a class="btn--custom btn--outline btn--rounded" href="{{ route('public.cart') }}">{{ __('View cart') }} <i class="feather icon-arrow-right"></i></a></p>
                </div>
            @endif
        </div>
    @endif
</div>
