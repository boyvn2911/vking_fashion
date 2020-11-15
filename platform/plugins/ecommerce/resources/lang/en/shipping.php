<?php

use Botble\Ecommerce\Enums\ShippingCodStatusEnum;
use Botble\Ecommerce\Enums\ShippingCrossCheckingStatusEnum;
use Botble\Ecommerce\Enums\ShippingMethodEnum;
use Botble\Ecommerce\Enums\ShippingStatusEnum;

return [
    'name'                    => 'Shipping Rules',
    'shipping'                => 'Shipping',
    'title'                   => 'Title',
    'amount'                  => 'Amount',
    'currency'                => 'Currency',
    'enable'                  => 'Enable',
    'enabled'                 => 'Enabled',
    'disable'                 => 'Disable',
    'disabled'                => 'Disabled',
    'create_shipping'         => 'Create a shipping',
    'edit_shipping'           => 'Edit shipping #',
    'status'                  => 'Status',
    'shipping_methods'        => 'Shipping methods',
    'create_shipping_method'  => 'Create shipping method',
    'edit_shipping_method'    => 'Edit shipping method',
    'add_shipping_region'     => 'Add shipping region',
    'country'                 => 'Country',
    'methods'                 => [
        ShippingMethodEnum::DEFAULT => 'Default',
    ],
    'statuses'                => [
        ShippingStatusEnum::NOT_APPROVED  => 'Not approved',
        ShippingStatusEnum::APPROVED      => 'Approved',
        ShippingStatusEnum::PICKING       => 'Picking',
        ShippingStatusEnum::DELAY_PICKING => 'Delay picking',
        ShippingStatusEnum::PICKED        => 'Picked',
        ShippingStatusEnum::NOT_PICKED    => 'Not picked',
        ShippingStatusEnum::DELIVERING    => 'Delivering',
        ShippingStatusEnum::DELIVERED     => 'Delivered',
        ShippingStatusEnum::NOT_DELIVERED => 'Not delivered',
        ShippingStatusEnum::AUDITED       => 'Audited',
        ShippingStatusEnum::CANCELED      => 'Canceled',
    ],
    'cod_statuses'            => [
        ShippingCodStatusEnum::PENDING   => 'Pending',
        ShippingCodStatusEnum::COMPLETED => 'Completed',
    ],
    'cross_checking_statuses' => [
        ShippingCrossCheckingStatusEnum::PENDING   => 'Pending',
        ShippingCrossCheckingStatusEnum::COMPLETED => 'Completed',
    ],
];
