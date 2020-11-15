<?php

register_page_template([
    'default'    => 'Default',
    'homepage'   => 'Homepage',
    'full-width' => 'Full width',
]);

register_sidebar([
    'id'          => 'footer_sidebar',
    'name'        => 'Footer sidebar',
    'description' => 'Footer sidebar',
]);

app()->booted(function () {
    remove_sidebar('primary_sidebar');
});

Menu::removeMenuLocation('header-menu')
    ->removeMenuLocation('footer-menu');

theme_option()
    ->setField([
        'id'         => 'hotline',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => 'Hotline',
        'attributes' => [
            'name'    => 'hotline',
            'value'   => null,
            'options' => [
                'class'        => 'form-control',
                'placeholder'  => 'Hotline',
                'data-counter' => 30,
            ],
        ],
    ])
    ->setField([
        'id'         => 'address',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => 'Address',
        'attributes' => [
            'name'    => 'address',
            'value'   => null,
            'options' => [
                'class'        => 'form-control',
                'placeholder'  => 'Address',
                'data-counter' => 120,
            ],
        ],
    ])
    ->setSection([
        'title'      => __('Social'),
        'desc'       => __('Social links'),
        'id'         => 'opt-text-subsection-social',
        'subsection' => true,
        'icon'       => 'fa fa-share-alt',
    ])
    ->setField([
        'id'         => 'facebook',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Facebook',
        'attributes' => [
            'name'    => 'facebook',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setField([
        'id'         => 'twitter',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Twitter',
        'attributes' => [
            'name'    => 'twitter',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setField([
        'id'         => 'linkedin',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Linkedin',
        'attributes' => [
            'name'    => 'linkedin',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setField([
        'id'         => 'youtube',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Youtube',
        'attributes' => [
            'name'    => 'youtube',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setField([
        'id'         => 'instagram',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Instagram',
        'attributes' => [
            'name'    => 'instagram',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setField([
        'id'         => 'pinterest',
        'section_id' => 'opt-text-subsection-social',
        'type'       => 'text',
        'label'      => 'Pinterest',
        'attributes' => [
            'name'    => 'pinterest',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setSection([
        'title'      => 'Ecommerce',
        'desc'       => 'Theme options for Ecommerce',
        'id'         => 'opt-text-subsection-ecommerce',
        'subsection' => true,
        'icon'       => 'fa fa-shopping-cart',
        'fields'     => [
            [
                'id'         => 'number_of_products_per_page',
                'type'       => 'number',
                'label'      => __('Number of products per page'),
                'attributes' => [
                    'name'    => 'number_of_products_per_page',
                    'value'   => 12,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'max_filter_price',
                'type'       => 'number',
                'label'      => __('Maximum price to filter'),
                'attributes' => [
                    'name'    => 'max_filter_price',
                    'value'   => 100000,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'product_page_banner_title',
                'type'       => 'text',
                'label'      => 'The description for products page',
                'attributes' => [
                    'name'    => 'product_page_banner_title',
                    'value'   => null,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'id'         => 'product_page_banner_image',
                'type'       => 'mediaImage',
                'label'      => __('Banner image for products page'),
                'attributes' => [
                    'name'  => 'product_page_banner_image',
                    'value' => null,
                ],
            ],
        ],
    ])
    ->setField([
        'id'         => 'primary_font',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'googleFonts',
        'label'      => __('Primary font'),
        'attributes' => [
            'name'  => 'primary_font',
            'value' => 'Poppins',
        ],
    ])
    ->setField([
        'id'         => 'primary_color',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'customColor',
        'label'      => __('Primary color'),
        'attributes' => [
            'name'  => 'primary_color',
            'value' => '#026e94',
        ],
    ])
    ->setField([
        'id'         => 'secondary_color',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'customColor',
        'label'      => __('Secondary color'),
        'attributes' => [
            'name'  => 'secondary_color',
            'value' => '#2c1dff',
        ],
    ])
    ->setField([
        'id'         => 'facebook_chat_enabled',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'select',
        'label'      => __('Enable Facebook chat?'),
        'attributes' => [
            'name'    => 'facebook_chat_enabled',
            'list'    => [
                'yes' => 'Yes',
                'no'  => 'No',
            ],
            'value'   => 'yes',
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setField([
        'id'         => 'facebook_page_id',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'text',
        'label'      => __('Facebook page ID'),
        'attributes' => [
            'name'    => 'facebook_page_id',
            'value'   => null,
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setField([
        'id'         => 'facebook_comment_enabled_in_post',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'select',
        'label'      => __('Enable Facebook comment in post detail page?'),
        'attributes' => [
            'name'    => 'facebook_comment_enabled_in_post',
            'list'    => [
                'yes' => 'Yes',
                'no'  => 'No',
            ],
            'value'   => 'yes',
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ])
    ->setField([
        'id'         => 'facebook_comment_enabled_in_product',
        'section_id' => 'opt-text-subsection-general',
        'type'       => 'select',
        'label'      => __('Enable Facebook comment in product detail page?'),
        'attributes' => [
            'name'    => 'facebook_comment_enabled_in_product',
            'list'    => [
                'yes' => 'Yes',
                'no'  => 'No',
            ],
            'value'   => 'yes',
            'options' => [
                'class' => 'form-control',
            ],
        ],
    ]);

add_action('init', function () {
    config(['filesystems.disks.public.root' => public_path('storage')]);
}, 124);

RvMedia::addSize('medium', 570, 570)
    ->addSize('small', 570, 268);

//add_shortcode('instagram', 'Instagram', 'Instagram', function ($shortCode) {
//    return Theme::partial('short-codes.instagram', [
//        'username'    => $shortCode->username,
//        'title'       => $shortCode->title,
//        'description' => $shortCode->description,
//        'store'       => $shortCode->store,
//    ]);
//});
//
//shortcode()->setAdminConfig('instagram', Theme::partial('short-codes.instagram-admin-config'));

add_shortcode('google-map', 'Google map', 'Custom map', function ($shortCode) {
    return Theme::partial('short-codes.google-map', ['address' => $shortCode->content]);
});

shortcode()->setAdminConfig('google-map', Theme::partial('short-codes.google-map-admin-config'));

if (is_plugin_active('ecommerce')) {
    add_shortcode('product-categories', 'Product categories', 'Product categories', function ($shortCode) {
        return Theme::partial('short-codes.product-categories', [
            'title'       => $shortCode->title,
            'description' => $shortCode->description,
        ]);
    });

    shortcode()->setAdminConfig('product-categories', Theme::partial('short-codes.product-categories-admin-config'));

    add_shortcode('featured-products', 'Featured products', 'Featured products', function ($shortCode) {

        return Theme::partial('short-codes.featured-products', [
            'title'       => $shortCode->title,
            'description' => $shortCode->description,
            'limit'    => $shortCode->limit ? $shortCode->limit : 8,
        ]);
    });

    shortcode()->setAdminConfig('featured-products', Theme::partial('short-codes.featured-products-admin-config'));
}

if (is_plugin_active('blog')) {
    add_shortcode('news', 'News', 'News', function ($shortCode) {
        return Theme::partial('short-codes.news', [
            'title'       => $shortCode->title,
            'description' => $shortCode->description,
        ]);
    });
    shortcode()->setAdminConfig('news', Theme::partial('short-codes.news-admin-config'));
}

if (is_plugin_active('contact')) {
    add_shortcode('september-contact-form', __('Contact form (deprecated)'), __('Add contact form'), function () {
        return Theme::partial('short-codes.contact-form');
    });

    add_filter(CONTACT_FORM_TEMPLATE_VIEW, function () {
        return Theme::getThemeNamespace() . '::partials.short-codes.contact-form';
    }, 120);
}

if (is_plugin_active('simple-slider')) {
    add_filter(SIMPLE_SLIDER_VIEW_TEMPLATE, function () {
        return Theme::getThemeNamespace() . '::partials.short-codes.sliders';
    }, 120);
}

add_shortcode('our-features', 'Our features', 'Our features', function ($shortCode) {
    $items = $shortCode->items;
    $items = explode(';', $items);
    $data = [];
    foreach ($items as $item) {
        $data[] = json_decode(trim($item), true);
    }

    return Theme::partial('short-codes.our-features', compact('data'));
});
