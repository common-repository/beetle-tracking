<?php

namespace BeetleTracking\Schema\WooCommerce;

class ProductPage
{
    public static function schema() : array
    {
        return [
            'woocommerce_track_product_page_value' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_product_page_ga4' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_product_page_meta' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_product_page_google_ads' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_product_page_google_ads_label' => [
                'type' => 'string',
            ],
            'woocommerce_track_product_page_pinterest' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_product_page_linkedin' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_product_page_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'woocommerce_track_product_page_linkedin_conversion_id' => [
                'type' => 'string',
            ],
            'woocommerce_track_product_page_bing' => [
                'type' => 'boolean',
            ],
            'woocommerce_track_product_page_tiktok' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'woocommerce_track_product_page_value' => true,
            'woocommerce_track_product_page_ga4' => true,
            'woocommerce_track_product_page_meta' => true,
            'woocommerce_track_product_page_google_ads' => true,
            'woocommerce_track_product_page_google_ads_label' => '',
            'woocommerce_track_product_page_pinterest' => true,
            'woocommerce_track_product_page_linkedin' => true,
            'woocommerce_track_product_page_linkedin_partner_id' => '',
            'woocommerce_track_product_page_linkedin_conversion_id' => '',
            'woocommerce_track_product_page_bing' => true,
            'woocommerce_track_product_page_tiktok' => true,
        ];
    }
}
