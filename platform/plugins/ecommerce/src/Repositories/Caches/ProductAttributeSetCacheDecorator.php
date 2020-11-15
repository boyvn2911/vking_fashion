<?php

namespace Botble\Ecommerce\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Ecommerce\Repositories\Interfaces\ProductAttributeSetInterface;

class ProductAttributeSetCacheDecorator extends CacheAbstractDecorator implements ProductAttributeSetInterface
{
    /**
     * {@inheritDoc}
     */
    public function getByProductId($productId)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritDoc}
     */
    public function getAllWithSelected($productId)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
