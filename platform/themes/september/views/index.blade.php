@php
Theme::layout('homepage')
@endphp

{!! do_shortcode('[simple-slider key="home-slider"][/simple-slider]') !!}
{!! do_shortcode('[product-categories title="A change of Season" description="Update your wardrobe with new seasonal trend"][/product-categories]') !!}
{!! do_shortcode('[featured-products title="Our Picks For You" description="Always find the best ways for you" limit="8"][/featured-products]') !!}
{!! do_shortcode('[news title="Visit Our Blog" description="Our Blog updated the newest trend of the world regularly"][/news]') !!}
