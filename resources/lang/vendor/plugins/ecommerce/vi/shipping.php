<?php

use Botble\Ecommerce\Enums\ShippingCodStatusEnum;
use Botble\Ecommerce\Enums\ShippingCrossCheckingStatusEnum;
use Botble\Ecommerce\Enums\ShippingMethodEnum;
use Botble\Ecommerce\Enums\ShippingStatusEnum;

return [
    'name'                    => 'Phí vận chuyển',
    'shipping'                => 'Vận chuyển',
    'title'                   => 'Title',
    'country'                 => 'Quốc gia',
    'state'                   => 'State',
    'city'                    => 'City',
    'amount'                  => 'Amount',
    'currency'                => 'Currency',
    'enable'                  => 'Enable',
    'enabled'                 => 'Enabled',
    'disable'                 => 'Disable',
    'disabled'                => 'Disabled',
    'create_shipping'         => 'Create a shipping',
    'edit_shipping'           => 'Edit shipping #',
    'status'                  => 'Status',
    'shipping_methods'        => 'Phương thức vận chuyển',
    'create_shipping_method'  => 'Tạo phương thức vận chuyển',
    'edit_shipping_method'    => 'Sửa phương thức vận chuyển',
    'add_shipping_region'     => 'Thêm khu vực vận chuyển',
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
