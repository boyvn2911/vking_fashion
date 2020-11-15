<?php

namespace Botble\Ecommerce\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Ecommerce\Repositories\Interfaces\CurrencyInterface;

class CurrencyCacheDecorator extends CacheAbstractDecorator implements CurrencyInterface
{
    /**
     * {@inheritDoc}
     */
    public function getAllCurrencies()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
