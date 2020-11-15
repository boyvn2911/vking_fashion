<div class="product">
    <div class="product__wrapper">
        <div class="product__thumbnail">
            @if ($product->front_sale_price !== $product->price)
                <div class="product__badges">
                    <span class="badge badge--sale">{{ get_sale_percentage($product->price, $product->front_sale_price) }}</span>
                </div>
            @endif
            <a class="product__overlay" href="{{ $product->url }}"></a>
            <img src="{{ RvMedia::getImageUrl($product->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->url }}" />
            @if (auth('customer')->check())
                @if ($customer->wishLists->where('product_id', $product->id)->count() > 0)
                    <a class="product__favorite active js-remove-favorite-button" href="{{ route('customer.wish-list.remove', $product->id) }}">
                        <i class="fa fa-heart"></i>
                    </a>
                @else
                    <a class="product__favorite js-add-favorite-button" href="{{ route('customer.wish-list.add', $product->id) }}">
                        <i class="fa fa-heart-o"></i>
                    </a>
                @endif
            @else
                <a class="product__favorite" href="{{ route('customer.login') }}">
                    <i class="fa fa-heart-o"></i>
                </a>
            @endif
            <ul class="product__actions">
                @if (get_ecommerce_setting('shopping_cart_enabled', '1') == '1' && $product->variations->count() == 0)
                    <li><a class="add-to-cart-button" data-url="{{ route('public.cart.add-to-cart') }}" data-id="{{ $product->id }}" href="javascript:void(0);">{{ __('Add to cart') }}</a></li>
                @endif
            </ul>
            @if (count($product->variationAttributeSwatchesForProductList))
                <ul class="product__variants color-swatch">
                    @foreach($product->variationAttributeSwatchesForProductList->unique('attribute_id') as $attribute)
                        @if ($attribute->display_layout == 'visual')
                            <li>
                                <div class="custom-checkbox">
                                    <span style="{{ $attribute->image ? 'background-image: url(' . asset($attribute->image) . ');' : 'background-color: ' . $attribute->color . ';' }}; cursor: initial;"></span>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="product__content" data-mh="product-item">
            <a class="product__title" href="{{ $product->url }}">{{ $product->name }}</a>
            <p class="product__price @if ($product->front_sale_price !== $product->price) sale @endif">
                <span>{{ format_price($product->front_sale_price) }}</span>
                @if ($product->front_sale_price !== $product->price)
                    <del><span>{{ format_price($product->price) }}</span></del>
                @endif
            </p>
        </div>
    </div>
</div>
