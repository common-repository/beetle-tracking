<?php

namespace BeetleTracking\Schema\WooCommerce;

class AddToCart
{
    public static function schema() : array
    {
        return [
            'woocommerce_track_add_to_cart_ga4' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_add_to_cart_meta' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_add_to_cart_google_ads' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_add_to_cart_google_ads_label' => [
                'type' => 'string',
            ],
            'woocommerce_track_add_to_cart_pinterest' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_add_to_cart_linkedin' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_add_to_cart_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'woocommerce_track_add_to_cart_linkedin_conversion_id' => [
                'type' => 'string',
            ],
            'woocommerce_track_add_to_cart_bing' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_add_to_cart_tiktok' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'woocommerce_track_add_to_cart_ga4' => true,
            'woocommerce_track_add_to_cart_meta' => true,
            'woocommerce_track_add_to_cart_google_ads' => true,
            'woocommerce_track_add_to_cart_google_ads_label' => '',
            'woocommerce_track_add_to_cart_pinterest' => true,
            'woocommerce_track_add_to_cart_linkedin' => true,
            'woocommerce_track_add_to_cart_linkedin_partner_id' => '',
            'woocommerce_track_add_to_cart_linkedin_conversion_id' => '',
            'woocommerce_track_add_to_cart_bing' => true,
            'woocommerce_track_add_to_cart_tiktok' => true,
        ];
    }
}
