<?php

namespace BeetleTracking\Schema\WooCommerce;

class ProductRemoved
{
    public static function schema() : array
    {
        return [
            'woocommerce_track_product_removed_ga4' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_product_removed_meta' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_product_removed_google_ads' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_product_removed_google_ads_label' => [
                'type' => 'string',
            ],
            'woocommerce_track_product_removed_pinterest' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_product_removed_linkedin' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_product_removed_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'woocommerce_track_product_removed_linkedin_conversion_id' => [
                'type' => 'string',
            ],
            'woocommerce_track_product_removed_bing' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_product_removed_tiktok' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'woocommerce_track_product_removed_ga4' => true,
            'woocommerce_track_product_removed_meta' => true,
            'woocommerce_track_product_removed_google_ads' => true,
            'woocommerce_track_product_removed_google_ads_label' => '',
            'woocommerce_track_product_removed_pinterest' => true,
            'woocommerce_track_product_removed_linkedin' => true,
            'woocommerce_track_product_removed_linkedin_partner_id' => '',
            'woocommerce_track_product_removed_linkedin_conversion_id' => '',
            'woocommerce_track_product_removed_bing' => true,
            'woocommerce_track_product_removed_tiktok' => true,
        ];
    }
}
