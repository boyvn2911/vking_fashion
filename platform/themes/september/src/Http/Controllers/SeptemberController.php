<?php

namespace Theme\September\Http\Controllers;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Blog\Repositories\Interfaces\PostInterface;
use Botble\Ecommerce\Repositories\Interfaces\OrderInterface;
use Botble\Theme\Http\Controllers\PublicController;
use Cart;
use Illuminate\Http\Request;
use Response;
use SeoHelper;
use Theme;
use Theme\September\Http\Resources\PostResource;

class SeptemberController extends PublicController
{
    /**
     * {@inheritDoc}
     */
    public function getIndex(BaseHttpResponse $response)
    {
        return parent::getIndex($response);
    }

    /**
     * {@inheritDoc}
     */
    public function getView(BaseHttpResponse $response, $key = null)
    {
        return parent::getView($response, $key);
    }

    /**
     * {@inheritDoc}
     */
    public function getSiteMap()
    {
        return parent::getSiteMap();
    }

    /**
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxCart(BaseHttpResponse $response)
    {
        return $response->setData([
            'count' => Cart::count(),
            'html'  => Theme::partial('cart-panel'),
        ]);
    }

    /**
     * @param int $productId
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function ajaxReviews($productId, BaseHttpResponse $response)
    {
        return $response->setData([
            'html' => Theme::partial('reviews', compact('productId')),
        ]);
    }

    /**
     * @param string $code
     * @return Response
     */
    public function getOrderTracking(Request $request, OrderInterface $orderRepository)
    {
        $code = $request->input('order_id');

        SeoHelper::setTitle(__('Order tracking' . ($code ? ' #' . $code : '')));

        Theme::breadcrumb()->add(__('Home'), url('/'))->add(__('Order tracking') . ($code ? ' #' . $code : ''), route('public.orders.tracking', $code));

        $orderId = get_order_id_from_order_code('#' . $code);

        $order = null;
        if ($orderId) {
            $order = $orderRepository
                ->getModel()
                ->where('ec_orders.id', $orderId)
                ->join('ec_order_addresses', 'ec_order_addresses.order_id', '=', 'ec_orders.id')
                ->where('ec_order_addresses.email', $request->input('email'))
                ->with(['address', 'payment', 'products'])
                ->select('ec_orders.*')
                ->first();
        }

        return Theme::scope('ecommerce.order-tracking', compact('order'))->render();
    }

    /**
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getFeaturedProducts(Request $request, BaseHttpResponse $response)
    {
        $data = [];

        $products = get_featured_products($request->input('limit', 8),
            ['slugable', 'variations', 'productCollections', 'variationAttributeSwatchesForProductList', 'promotions']
        );

        $customer = auth('customer')->check() ? auth('customer')->user()->load('wishLists') : null;

        foreach ($products as $product) {
            $data[] = Theme::partial('product-item', compact('product', 'customer'));
        }

        return $response->setData($data);
    }

    /**
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Resources\Json\JsonResource
     */
    public function ajaxGetPosts(BaseHttpResponse $response)
    {
        $posts = app(PostInterface::class)->getFeatured(3);

        return $response
            ->setData(PostResource::collection($posts))
            ->toApiResponse();
    }
}
