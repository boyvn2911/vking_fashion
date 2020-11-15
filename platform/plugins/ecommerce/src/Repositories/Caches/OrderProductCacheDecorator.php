<?php

namespace Botble\Ecommerce\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Ecommerce\Repositories\Interfaces\OrderProductInterface;

class OrderProductCacheDecorator extends CacheAbstractDecorator implements OrderProductInterface
{
}
