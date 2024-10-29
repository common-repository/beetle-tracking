<?php

namespace BeetleTracking\Schema\WooCommerce;

class OrderCompleted
{
    public static function schema() : array
    {
        return [
            'woocommerce_order_completed_server_side' => [
                'type' => 'boolean',
            ],
            'woocommerce_order_completed_server_side_status' => [
                'type' => 'string',
            ],
            'woocommerce_order_completed_ga4' => [
                'type' => 'boolean',
            ],
            'woocommerce_order_completed_meta' => [
                'type' => 'boolean',
            ],
            'woocommerce_order_completed_google_ads' => [
                'type' => 'boolean',
            ],
            'woocommerce_order_completed_google_ads_label' => [
                'type' => 'string',
            ],
            'woocommerce_order_completed_pinterest' => [
                'type' => 'boolean',
            ],
            'woocommerce_order_completed_linkedin' => [
                'type' => 'boolean',
            ],
            'woocommerce_order_completed_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'woocommerce_order_completed_linkedin_conversion_id' => [
                'type' => 'string',
            ],
            'woocommerce_order_completed_bing' => [
                'type' => 'boolean',
            ],
            'woocommerce_order_completed_tiktok' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'woocommerce_order_completed_server_side' => false,
            'woocommerce_order_completed_server_side_status' => '',
            'woocommerce_order_completed_ga4' => true,
            'woocommerce_order_completed_meta' => true,
            'woocommerce_order_completed_google_ads' => true,
            'woocommerce_order_completed_google_ads_label' => '',
            'woocommerce_order_completed_pinterest' => true,
            'woocommerce_order_completed_linkedin' => true,
            'woocommerce_order_completed_linkedin_partner_id' => '',
            'woocommerce_order_completed_linkedin_conversion_id' => '',
            'woocommerce_order_completed_bing' => true,
            'woocommerce_order_completed_tiktok' => true,
        ];
    }
}
