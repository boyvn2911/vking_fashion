@php
    $reviews = app(\Botble\Ecommerce\Repositories\Interfaces\ReviewInterface::class)->advancedGet([
        'condition' => [
            'status'     => \Botble\Base\Enums\BaseStatusEnum::PUBLISHED,
            'product_id' => $productId,
        ],
        'order_by' => ['created_at' => 'desc'],
        'paginate'  => [
            'per_page'      => 10,
            'current_paged' => (int) request()->input('page', 1),
        ],
    ]);
@endphp

@foreach ($reviews as $review)
    @if (!empty($review->user) && !empty($review->product))
        <div class="block--review">
            <div class="block__header">
                <div class="block__image"><img src="{{ $review->user->avatar_url }}" alt="{{ $review->user_name }}" width="50"></div>
                <div class="block__info">
                    <h5>{{ $review->user_name }}</h5>
                    <div class="form__rating">
                        <select class="rating" data-read-only="false">
                            <option value="1" @if ($review->star == 1) selected @endif>1</option>
                            <option value="2" @if ($review->star == 2) selected @endif>2</option>
                            <option value="3" @if ($review->star == 3) selected @endif>3</option>
                            <option value="4" @if ($review->star == 4) selected @endif>4</option>
                            <option value="5" @if ($review->star == 5) selected @endif>5</option>
                        </select>
                    </div>
                    <p>{{ $review->created_at->format('d M, Y') }}</p>

                    <div class="block__content">
                        <p>{{ $review->comment }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

@if (count($reviews) > 0)
    {!! $reviews->links() !!}
@endif
