@php
    Theme::layout('full-width');
    $brands = get_all_brands(['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED], ['slugable', 'products'], ['products']);
    $categories = get_product_categories(['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED], ['slugable'], ['products']);
    $tags = app(\Botble\Ecommerce\Repositories\Interfaces\ProductTagInterface::class)->allBy(['status' => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED], ['slugable']);
@endphp
<main class="page--shop">
    <div class="page__hero bg--cover" data-background="{{ theme_option('product_page_banner_image') ? RvMedia::getImageUrl(theme_option('product_page_banner_image')) : Theme::asset()->url('img/bg/shop.jpg') }}">
        <h1>{{ theme_option('product_page_banner_title') ? theme_option('product_page_banner_title') : __('Enjoy Shopping with us') }}</h1>
    </div>
    <div class="page__content">
        <div class="container">
            <div class="shop shop--sidebar">
                <div class="container">
                    <form action="{{ URL::current() }}" method="GET">
                        <div class="shop__header">
                            {!! Theme::partial('breadcrumbs') !!}
                            @include(Theme::getThemeNamespace() . '::views/ecommerce/includes/sort')
                            <a class="panel-trigger btn--custom btn--rounded btn--outline" href="#filter-product">{{ __('Filter Products') }}</a>
                        </div>
                        <div class="shop__content">
                            <div class="shop__left">
                                @include(Theme::getThemeNamespace() . '::views/ecommerce/includes/filters', compact('brands', 'categories', 'tags'))
                            </div>
                            <div class="shop__right">
                                <div class="shop__products">
                                    @if ($products->count() > 0)
                                        <div class="row">
                                            @if ($products->count() > 0)
                                                @foreach($products as $product)
                                                    <div class="col-md-4 col-6">
                                                        {!! Theme::partial('product-item', compact('product', 'customer')) !!}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="shop__pagination">
                                            {!! $products->appends(request()->query())->links() !!}
                                        </div>
                                    @else
                                        <br>
                                        <p class="text-center">{{ __('No products!') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="{{ URL::current() }}" method="GET">
                        @include(Theme::getThemeNamespace() . '::views/ecommerce/includes/filters-modal', compact('brands', 'categories', 'tags'))
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

