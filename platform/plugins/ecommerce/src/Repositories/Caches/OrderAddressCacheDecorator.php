<?php

namespace Botble\Ecommerce\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\Ecommerce\Repositories\Interfaces\OrderAddressInterface;

class OrderAddressCacheDecorator extends CacheAbstractDecorator implements OrderAddressInterface
{
}
