@extends('plugins/ecommerce::themes.customers.master')

@section('content')
    <div class="title">
        <h2 class="customer-page-title">{{ __('Wishlist') }}</h2>
    </div>
    <br>
    @if (count($wish_lists) > 0 && $wish_lists->count() > 0)
        <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>{{ __('Image') }}</th>
                <th>{{ __('Product') }}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach($wish_lists as $item)
                    @if (!empty($item->product))
                        <tr>
                            <td>
                                <img alt="{{ $item->product->name }}" width="50" height="70" class="img-fluid" style="max-height: 75px" src="{{ RvMedia::getImageUrl($item->product->image, 'thumb', false, RvMedia::getDefaultImage()) }}">
                            </td>
                            <td><a href="{{ $item->product->url }}">{{ $item->product->name }}</a></td>

                            <td>
                                <a href="{{ route('customer.wish-list.remove', $item->product_id) }}">{{ __('Remove') }}</a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        </div>
    @else
        <p>{{ __('No item in wishlist!') }}</p>
    @endif
@endsection
