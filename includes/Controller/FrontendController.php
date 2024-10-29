<?php

namespace BeetleTracking\Controller;

use BeetleTracking\Params\StandardParams;
use BeetleTracking\Utils\Settings;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class FrontendController
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function enqueue_scripts()
    {
        $asset = require_once BEETLE_TRACKING_DIR_PATH . '/assets/dist/public.asset.php';
        $asset['dependencies'][] = 'wp-hooks';
        wp_enqueue_script('bt-frontend', BEETLE_TRACKING_DIR_URL . 'assets/dist/public.js', array_unique($asset['dependencies']), $asset['version'], true);
        wp_localize_script('bt-frontend', 'BEETLE_TRACKING', array(
            'settings' => array_filter(get_option('beetle_tracking_settings', []), function ($key) {
                return !in_array($key, ['meta_conversion_api', 'license']);
            }, ARRAY_FILTER_USE_KEY),
            'standard_params' => StandardParams::get_frontend_params(),
            'custom_params' => apply_filters('beetle_tracking_custom_params', [
                'search_query' => is_search() && isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '',
            ]),
            'events' => array_map(function ($event) {
                return $event->getEvent();
            }, apply_filters('beetle_tracking_events', array())),
            'is' => [
                'search' => is_search(),
                'woocommerce_enabled' => class_exists('WooCommerce'),
                'loaded' => false,
            ],
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('bt-nonce'),
            'debugging' => Settings::get('enable_debugging'),
        ));
    }
}
