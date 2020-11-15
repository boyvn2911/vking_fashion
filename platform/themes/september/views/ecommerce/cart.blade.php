<div class="page__header">
    {!! Theme::partial('breadcrumbs') !!}
</div>
<section class="section section--shopping-cart">
    <div class="section__header">
        <h3>{{ __('Shopping Cart') }}</h3>
    </div>
    <div class="section__content">
        @if (Cart::count() > 0)
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
            <form class="form--shopping-cart" method="post" action="{{ route('public.cart.update') }}">
                @csrf
                <div class="form__section">
                        <div class="table-responsive">
                            <table class="table table--cart">
                                <thead>
                                <tr>
                                    <th>{{ __('Image') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Price') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if (isset($products) && $products)
                                        @foreach(Cart::content() as $key => $cartItem)
                                            @php
                                                $product = $products->where('id', $cartItem->id)->first();
                                            @endphp

                                            @if (!empty($product))
                                                <tr>
                                                    <td>
                                                        <div class="product--cart">
                                                            <div class="product__thumbnail">
                                                                <a href="{{ $product->url }}" class="product__overlay">
                                                                    <img src="{{ $cartItem->options['image'] }}" alt="{{ $product->name }}" />
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="product__content">
                                                            <a href="{{ $product->url }}" title="{{ $product->name }}">{{ $product->name }}</a>
                                                            <small>{{ $cartItem->options['attributes'] ?? '' }}</small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="product-price-amount amount">
                                                            <span class="currency-sign">
                                                                <strong>{{ format_price($cartItem->price) }}</strong>
                                                            </span>
                                                            <input type="hidden" name="items[{{ $key }}][rowId]" value="{{ $cartItem->rowId }}">
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="form-group--number product__qty">
                                                            <button type="button" class="up"></button>
                                                            <input class="form-control qty-input" type="number" value="{{ $cartItem->qty }}" name="items[{{ $key }}][values][qty]">
                                                            <button type="button" class="down"></button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('public.cart.remove', $cartItem->rowId) }}" class="btn--remove remove-cart-button"><i class="feather icon icon-trash-2"></i></a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                    <tr class="sub-total">
                                        <td colspan="4">
                                            <h5>{{ __('Sub total') }}</h5>
                                        </td>
                                        <td>
                                            <h5>{{ format_price(Cart::rawSubTotal()) }}</h5>
                                        </td>
                                    </tr>
                                    @if ($promotionDiscountAmount)
                                        <tr class="sub-total">
                                            <td colspan="4">
                                                <h5>{{ __('Discount promotion') }}</h5>
                                            </td>
                                            <td>
                                                <h5 class="promotion-discount-amount-text">{{ format_price($promotionDiscountAmount) }}</h5>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr class="total">
                                        <td colspan="4"><strong>{{ __('Total') }}</strong> <br /> <span>({{ __('It is not include shipping fee') }})</span></td>
                                        <td class="total__price product-subtotal">
                                            <span class="amount">{{ format_price(Cart::rawTotal() - $promotionDiscountAmount - $couponDiscountAmount) }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <div class="form__submit text-right">
                    <button type="submit" class="btn--custom btn--outline btn--rounded">{{ __('Update cart') }}</button>&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn--custom btn--outline btn--rounded" name="checkout">{{ __('Checkout') }}</button>
                </div>
            </form>
        @else
            <p class="text-center">{{ __('Your cart is empty!') }}</p>
        @endif
    </div>
</section>
