<?php

namespace Botble\Ecommerce\Http\Controllers\Fronts;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Http\Requests\CartRequest;
use Botble\Ecommerce\Http\Requests\UpdateCartRequest;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Botble\Ecommerce\Services\HandleApplyPromotionsService;
use Cart;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use OrderHelper;
use Response;
use Theme;

class PublicCartController extends Controller
{
    /**
     * @var ProductInterface
     */
    protected $productRepository;

    /**
     * PublicCartController constructor.
     * @param ProductInterface $productRepository
     */
    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param CartRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(CartRequest $request, BaseHttpResponse $response)
    {
        if (get_ecommerce_setting('shopping_cart_enabled', '1') != '1') {
            return $response->setError(true);
        }

        $product = $this->productRepository->findById($request->id);

        if (!$product) {
            return $response
                ->setError()
                ->setMessage(__('This product is out of stock or not exists!'));
        }

        if ($product->isOutOfStock()) {
            return $response
                ->setError()
                ->setMessage(__('Product :product is out of stock!', ['product' => $product->original_product->name]));
        }

        $maxQuantity = $product->quantity;

        $product->quantity -= $request->input('qty', 1);

        if ($product->isOutOfStock()) {
            return $response
                ->setError()
                ->setMessage(__('Maximum quantity is ' . $maxQuantity));
        }

        if ($product->variations->count() > 0) {
            return $response
                ->setError()
                ->setMessage(__('Please choose attributes to buy this product'));
        }

        $outOfQuantity = false;
        foreach (Cart::content() as $item) {
            if ($item->id == $product->id) {
                $originalQuantity = $product->quantity;
                $product->quantity = (int)$product->quantity - $item->qty;
                if ($product->quantity < 0) {
                    $product->quantity = 0;
                }
                if ($product->isOutOfStock()) {
                    $outOfQuantity = true;
                    break;
                }
                $product->quantity = $originalQuantity;
            }
        }

        if ($outOfQuantity) {
            return $response
                ->setError()
                ->setMessage(__('Product :product is out of stock!', ['product' => $product->original_product->name]));
        }

        $cartItems = OrderHelper::handleAddCart($product, $request);

        if (!session()->has('tracked_start_checkout')) {
            $token = md5(Str::random(40));
            session(['tracked_start_checkout' => $token]);
        }

        return $response
            ->setData([
                'status'      => true,
                'count'       => Cart::count(),
                'total_price' => format_price(Cart::rawSubTotal()),
                'content'     => $cartItems,
            ])
            ->setMessage(__('Added product :product to cart successfully!', ['product' => $product->original_product->name]));
    }

    /**
     * @param HandleApplyPromotionsService $applyPromotionsService
     * @return Response
     */
    public function getView(HandleApplyPromotionsService $applyPromotionsService)
    {
        if (get_ecommerce_setting('shopping_cart_enabled', '1') != '1') {
            abort(404);
        }

        Theme::asset()
            ->container('footer')
            ->add('ecommerce-coupon-js', 'vendor/core/plugins/ecommerce/js/discount.js', ['jquery']);

        $promotionDiscountAmount = $applyPromotionsService->execute();

        $sessionData = [];
        if (session()->has('tracked_start_checkout')) {
            $token = session()->get('tracked_start_checkout');
            $sessionData = OrderHelper::getOrderSessionData($token);
        }
        $couponDiscountAmount = 0;
        if (session()->has('applied_coupon_code')) {
            $couponDiscountAmount = Arr::get($sessionData, 'coupon_discount_amount', 0);
        }

        return Theme::scope(
            'ecommerce.cart',
            compact('promotionDiscountAmount', 'couponDiscountAmount'),
            'plugins/ecommerce::themes.cart'
        )->render();
    }

    /**
     * @param UpdateCartRequest $request
     * @param BaseHttpResponse $response
     * @return array|BaseHttpResponse|RedirectResponse
     */
    public function postUpdate(UpdateCartRequest $request, BaseHttpResponse $response)
    {
        if (get_ecommerce_setting('shopping_cart_enabled', '1') != '1') {
            return $response->setError(true);
        }

        if ($request->has('checkout')) {
            if (session()->has('tracked_start_checkout')) {
                $token = session()->get('tracked_start_checkout');
            } else {
                $token = md5(Str::random(40));
                session(['tracked_start_checkout' => $token]);
            }

            return $response->setNextUrl(route('public.checkout.information', $token));
        }
        $data = $request->input('items', []);

        $outOfQuantity = false;
        foreach ($data as $item) {
            $cartItem = Cart::get($item['rowId']);
            $product = null;
            if ($cartItem) {
                $product = $this->productRepository->findById($cartItem->id);
            }
            if ($product) {
                $originalQuantity = $product->quantity;
                $product->quantity = (int)$product->quantity - Arr::get($item['values'], 'qty', 0) + 1;
                if ($product->quantity < 0) {
                    $product->quantity = 0;
                }
                if ($product->isOutOfStock()) {
                    $outOfQuantity = true;
                } else {
                    Cart::update($item['rowId'], $item['values']);
                }
                $product->quantity = $originalQuantity;
            }
        }

        if ($outOfQuantity) {
            return $response
                ->setError()
                ->setData([
                    'count'       => Cart::count(),
                    'total_price' => format_price(Cart::rawSubTotal()),
                    'content'     => Cart::content(),
                ])
                ->setMessage(__('One or all products are not enough quantity so cannot update!'));
        }

        return $response
            ->setData([
                'count'       => Cart::count(),
                'total_price' => format_price(Cart::rawSubTotal()),
                'content'     => Cart::content(),
            ])
            ->setMessage(__('Update cart successfully!'));
    }

    /**
     * @param string $id
     * @param BaseHttpResponse $response
     * @return array|BaseHttpResponse|RedirectResponse
     */
    public function getRemove($id, BaseHttpResponse $response)
    {
        if (get_ecommerce_setting('shopping_cart_enabled', '1') != '1') {
            abort(404);
        }

        try {
            Cart::remove($id);
        } catch (Exception $exception) {
            return $response->setError()->setMessage(__('Cart item is not existed!'));
        }

        return $response
            ->setData([
                'count'       => Cart::count(),
                'total_price' => format_price(Cart::rawSubTotal()),
                'content'     => Cart::content(),
            ])
            ->setMessage(__('Removed item from cart successfully!'));
    }

    /**
     * @param BaseHttpResponse $response
     * @return array|BaseHttpResponse|RedirectResponse
     */
    public function getDestroy(BaseHttpResponse $response)
    {
        if (get_ecommerce_setting('shopping_cart_enabled', '1') != '1') {
            abort(404);
        }

        Cart::destroy();

        return $response
            ->setData(Cart::content())
            ->setMessage(__('Empty cart successfully!'));
    }
}
