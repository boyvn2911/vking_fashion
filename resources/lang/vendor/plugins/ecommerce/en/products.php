<?php

return [
    'name'                        => 'Products',
    'create'                      => 'New product',
    'edit'                        => 'Edit product - :name',
    'form'                        =>
        [
            'name'                    => 'Name',
            'name_placeholder'        => 'Product\'s name (Maximum 120 characters)',
            'description'             => 'Description',
            'description_placeholder' => 'Short description for product (Maximum 400 characters)',
            'categories'              => 'Categories',
            'content'                 => 'Content',
            'price'                   => 'Price',
            'quantity'                => 'Quantity',
            'brand'                   => 'Brand',
            'width'                   => 'Width',
            'height'                  => 'Height',
            'weight'                  => 'Weight',
            'date'                    =>
                [
                    'end'   => 'From date',
                    'start' => 'To date',
                ],
            'image'                   => 'Images',
            'label'                   => 'Product collections',
            'price_sale'              => 'Price sale',
            'product_type'            =>
                [
                    'title' => 'Product type',
                ],
            'shipping'                =>
                [
                    'height' => 'Height',
                    'length' => 'Length',
                    'title'  => 'Shipping',
                    'weight' => 'Weight',
                    'wide'   => 'Wide',
                ],
            'stock'                   =>
                [
                    'allow_order_when_out' => 'Allow customer checkout when this product out of stock',
                    'in_stock'             => 'In stock',
                    'out_stock'            => 'Out stock',
                    'title'                => 'Stock status',
                ],
            'storehouse'              =>
                [
                    'no_storehouse' => 'No storehouse management',
                    'storehouse'    => 'With storehouse management',
                    'title'         => 'Storehouse',
                    'quantity'      => 'Quantity',
                ],
        ],
    'price'                       => 'Price',
    'quantity'                    => 'Quantity',
    'type'                        => 'Type',
    'image'                       => 'Thumbnail',
    'sku'                         => 'Sku',
    'brand'                       => 'Brand',
    'notices'                     =>
        [
            'no_select'              => 'Please select at least one record to take this action!',
            'update_success_message' => 'Update successfully',
        ],
    'cannot_delete'               => 'Product could not be deleted',
    'product_deleted'             => 'Product deleted',
    'product_collections'         => 'Product collections',
    'products'                    => 'Products',
    'menu'                        => 'Products',
    'control'                     =>
        [
            'button_add_image' => 'Add image',
        ],
    'price_sale'                  => 'Sale price',
    'price_group_title'           => 'Manager product price',
    'store_house_group_title'     => 'Manager store house',
    'shipping_group_title'        => 'Manager shipping',
    'overview'                    => 'Overview',
    'attributes'                  => 'Attributes',
    'product_has_variations'      => 'Product has variations',
    'manage_products'             => 'Manage products',
    'add_new_product'             => 'Add a new product',
    'start_by_adding_new_product' => 'Start by adding new products.',
    'edit_this_product'           => 'Edit this product',
];
