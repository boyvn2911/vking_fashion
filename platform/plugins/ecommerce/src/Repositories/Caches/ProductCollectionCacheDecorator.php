<?php

namespace Botble\Ecommerce\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Ecommerce\Repositories\Interfaces\ProductCollectionInterface;

class ProductCollectionCacheDecorator extends CacheAbstractDecorator implements ProductCollectionInterface
{
    /**
     * {@inheritDoc}
     */
    public function createSlug($name, $id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
