<?php

namespace Botble\Ecommerce\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Ecommerce\Repositories\Interfaces\DiscountInterface;

class DiscountCacheDecorator extends CacheAbstractDecorator implements DiscountInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAvailablePromotions()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getProductPriceBasedOnPromotion(array $productIds = [], array $productCollections = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
