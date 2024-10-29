<?php

namespace BeetleTracking\Controller;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class DashboardController
{
    public function __construct()
    {
        add_action('init', [$this, 'register_settings']);
        add_action('admin_menu', [$this, 'add_menu_item']);
        add_filter('admin_body_class', [$this, 'set_admin_body_class']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);

        add_filter("default_option_beetle_tracking_settings", [$this, 'default_settings']);
        add_filter("option_beetle_tracking_settings", [$this, 'maybe_add_default_settings']);
        add_filter('rest_pre_dispatch', [$this, 'add_settings_to_wpml'], 10, 3);
    }

    public function register_settings()
    {
        register_setting(
            'beetle_tracking_settings',
            'beetle_tracking_settings',
            apply_filters('beetle_tracking_settings_schema', [
                'show_in_rest' => [
                    'schema' => [
                        'type'       => 'object',
                        'properties' => array_merge(
                            \BeetleTracking\Schema\WebsiteEvents\Pageview::schema(),
                            \BeetleTracking\Schema\WebsiteEvents\Forms::schema(),
                            \BeetleTracking\Schema\WebsiteEvents\UserSignup::schema(),
                            \BeetleTracking\Schema\WebsiteEvents\UserLogin::schema(),
                            \BeetleTracking\Schema\WebsiteEvents\Download::schema(),
                            \BeetleTracking\Schema\WebsiteEvents\Comment::schema(),
                            \BeetleTracking\Schema\WebsiteEvents\TimeOnPage::schema(),
                            \BeetleTracking\Schema\WebsiteEvents\Search::schema(),
                            \BeetleTracking\Schema\WebsiteEvents\PageScroll::schema(),
                            \BeetleTracking\Schema\WebsiteEvents\PhoneLinks::schema(),
                            \BeetleTracking\Schema\WebsiteEvents\EmailLinks::schema(),

                            /** WooCommerce Events */
                            \BeetleTracking\Schema\WooCommerce\AddToCart::schema(),
                            \BeetleTracking\Schema\WooCommerce\CheckoutPage::schema(),
                            \BeetleTracking\Schema\WooCommerce\OrderCompleted::schema(),
                            \BeetleTracking\Schema\WooCommerce\ProductCategoryPage::schema(),
                            \BeetleTracking\Schema\WooCommerce\ProductPage::schema(),
                            \BeetleTracking\Schema\WooCommerce\ProductRemoved::schema(),
                            /** Consent */
                            \BeetleTracking\Schema\Consent::schema(),
                            /** Platforms */
                            \BeetleTracking\Schema\Platform\GA4::schema(),
                            \BeetleTracking\Schema\Platform\Meta::schema(),
                            \BeetleTracking\Schema\Platform\GoogleAds::schema(),
                            \BeetleTracking\Schema\Platform\Pinterest::schema(),
                            \BeetleTracking\Schema\Platform\LinkedIn::schema(),
                            \BeetleTracking\Schema\Platform\Bing::schema(),
                            \BeetleTracking\Schema\Platform\TikTok::schema(),
                            /** Advanced */
                            \BeetleTracking\Schema\Advanced::schema(),
                            \BeetleTracking\Schema\Cloudflare::schema(),
                            \BeetleTracking\Schema\License::schema(),
                        ),
                    ]
                ]
            ])
        );

        register_setting(
            'beetle_tracking_settings',
            'beetle_tracking_license_key',
            [
                'type' => 'string',
                'show_in_rest' => true,
                'default' => '',
            ]
        );
    }

    /**
     * Add our dashboard menu item.
     */
    public function add_menu_item()
    {
        add_menu_page(
            esc_html__('Beetle Tracking - Cloudflare Zaraz for WooCommerce', 'beetle-tracking'),
            esc_html__('Beetle Tracking', 'beetle-tracking'),
            apply_filters('beetle_tracking_dashboard_page_capability', 'manage_options'),
            'beetle-tracking-dashboard',
            [$this, 'page'],
            'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbDpzcGFjZT0icHJlc2VydmUiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUwOS44IDY2NC40IiB2aWV3Qm94PSIwIDAgNTA5LjggNjY0LjQiPjxwYXRoIGQ9Ik0xMTguOSA0MzQuOGMtNS45IDQuOS0xMiA5LjYtMTcuNiAxNC44LTE1LjcgMTQuMy0yNy45IDMxLjEtMzYuNyA1MC40LTIuMSA0LjctMy44IDkuNS02IDE0LjItMy4zIDYuOC03IDkuMS0xMy42IDguNS02LjMtLjUtOS01LjItOS45LTEwLjMtMi40LTEyLjgtNS4yLTI1LjYtNS45LTM4LjYtMi0zOC44IDctNzUuMSAyNi45LTEwOC42IDkuNy0xNi40IDIxLjUtMzEgMzYuNC00MyA1LjQtNC4zIDExLjUtNy43IDE3LTExLjkgMS40LTEuMSAyLjUtMy4zIDIuNi01LjEuNS04LjMtLjEtMTYuNyAxLjEtMjQuOSAzLjEtMjEuNyA2LjQtNDMuNSAxMC43LTY1IDctMzUuNSAyMS4xLTY4LjIgNDEuNC05OC4xIDYuMS05IDEzLjUtMTcuMiAyMS0yNi42LTYuOS05LjgtMTQuMS0yMC4zLTIxLjUtMzAuNy0uNi0uOC0yLjItMS4yLTMuNC0xLjQtNy40LTEtMTQuMi03LjMtMTUuMi0xNC40LTEuMS03LjIgMi42LTE0LjcgOC42LTE3LjYgOC4xLTMuOSAxNi4xLTMuMSAyMS4yIDMuNSA4LjggMTEuMyAxNi45IDIzLjEgMjUuMyAzNC43IDIgMi44IDQgNS43IDYuMyA4LjkgNi4zLTQgMTIuMi04LjIgMTguNS0xMS44IDcuNC00LjEgMTUtNy43IDIyLjYtMTEuNSA0LjItMi4xIDguMy0xLjggMTIuNC40IDEzLjYgNy4yIDI3LjMgMTQuNCA0MS40IDIxLjkgNS43LTguMiAxMi4xLTE3LjMgMTguNS0yNi4zIDMuNy01LjEgNy4zLTEwLjIgMTEuMi0xNS4yIDUuMy02LjggMTMuMy04LjYgMjEuNC01LjMgNiAyLjUgMTAuNSAxMC45IDkuNSAxNy44LTEgNy40LTcuNSAxMy42LTE1LjQgMTQuOS0xLjQuMi0zLjIgMS00IDIuMS03LjEgOS44LTE0LjEgMTkuOC0yMS4xIDI5LjggNS44IDYuOCAxMS42IDEzLjQgMTcuMSAyMC4yIDE2LjggMjAuOSAyOC4yIDQ0LjggMzYuMyA3MC4xIDYuOCAyMS4yIDEyLjcgNDIuOSAxNi42IDY0LjggMy4zIDE5IDMuMyAzOC42IDQuNSA1Ny45LjIgMy4yIDEuMiA1LjIgMy44IDYuOCAyMC43IDEzLjEgMzcuNSAzMCA1MC40IDUwLjkgMTUuMSAyNC40IDI0LjQgNTAuOCAyNy43IDc5LjIgMi40IDIwLjUuOCA0MS0zIDYxLjMtLjcgMy43LTEuNCA3LjQtMi4yIDExLjEtMS4zIDUuNy01LjUgOS42LTEwLjkgMTAuMS02LjEuNi04LjYtMS4yLTExLjgtNy41LTYuNy0xMy4yLTEyLjctMjYuNy0yMC41LTM5LjItMTAuMi0xNi41LTI0LjUtMjkuNC00MC40LTQwQzM2Ni42IDUwNS40IDMyMi43IDU0OS45IDI0NiA1NDZjLTY5LTMuNC0xMDYuNC00OC41LTEyNy4xLTExMS4yem0xNDguNiA4NC44YzMuNS0uNSA2LjctLjcgOS43LTEuNSAyNy42LTYuOCA0OS4yLTIyLjUgNjUuNy00NS40IDE4LjYtMjUuNyAyNi40LTU1LjIgMjctODYuMS43LTQwIDIuMi04MC4xLTItMTIwLTEuMy0xMS44LTMuNS0yMy42LTUuMy0zNWgtOTUuMXYyODh6bS0yNS45LjJWMjMxLjNoLTk0LjFjLTUuMyAyMi03LjUgNDQtNy45IDY2LjEtLjUgMjUtLjEgNTAtLjQgNzUtLjIgMTcuNyAxLjkgMzUuMiA1LjkgNTIuMyA4LjcgMzcgMjguMiA2Ni4yIDYyLjYgODQuMiAxMC40IDUuNSAyMS40IDkuNCAzMy45IDEwLjl6bTExMy4xLTMxNC40Yy0uMi0xLjItLjQtMi0uNi0yLjgtNC0xOC4yLTExLjUtMzUtMjAuMy01MS4zLTE3LjktMzIuOC00My44LTU3LjItNzcuMS03My45LTEuNC0uNy0zLjctLjgtNS0uMS0xNi41IDguMy0zMS42IDE4LjctNDQuOCAzMS42LTIwLjUgMTkuOS0zNC42IDQ0LjEtNDQuOCA3MC42LTMuMiA4LjQtNS42IDE3LTguNSAyNS44IDY3LjcuMSAxMzQuMy4xIDIwMS4xLjF6bTQzLjEgMTM2Yy0uNi4xLTEuMi4xLTEuNy4yIDAgMjAuOC4xIDQxLjUtLjEgNjIuMyAwIDMuMyAxIDUuMSAzLjggNi43IDE0LjMgOC4zIDI3LjUgMTguMSAzOCAzMS4xIDUuMSA2LjIgOS45IDEyLjYgMTUuNCAxOS42LTEuMy00OC42LTE4LjYtODguNy01NS40LTExOS45ek01NS4zIDQ2Mi43Yy4zLS40LjYtLjguOS0xLjEgMTQuNC0yMS42IDMxLjgtNDAuMSA1NC45LTUyLjggMS0uNiAxLjktMi42IDEuOC0zLjktLjEtNi42LS44LTEzLjItLjktMTkuOC0uMi0xMy4xLS4xLTI2LjMtLjEtMzkuNCAwLTEuNC0uMi0yLjgtLjMtNC43LTM3LjcgMzIuMS01NC42IDczLjMtNTYuMyAxMjEuN3pNMzI5LjcgNTg1LjFjMCA2LjMuMSAyNS4zIDAgMzEuNi0uMSA3LjYtNS42IDEzLjItMTIuNiAxMy4zLTYuOC4xLTEyLTUuNC0xMi4xLTEzLjEtLjEtMTIuNyAwLTM4IC4xLTUwLjYgMC04IDQuOC0xMi45IDEyLjYtMTIuOSA3LjUgMCAxMiA0LjYgMTIuMSAxMi43LjEgNi4zLS4xIDEyLjctLjEgMTl6TTI2Ni43IDYxNi43Yy0uMSA3LjYtNS42IDEzLjItMTIuNiAxMy4zLTYuOC4xLTEyLTUuNC0xMi4xLTEzLjEtLjEtMTIuNyAwLTE4IC4xLTMwLjYgMC04IDQuOC0xMi45IDEyLjYtMTIuOSA3LjUgMCAxMiA0LjYgMTIuMSAxMi43IDAgNi4zIDAgMjQuMy0uMSAzMC42ek0yMDQuMSA1ODUuNGMwIDYuMy4xIDI1LjMgMCAzMS42LS4xIDYuOS00LjkgMTIuMy0xMC44IDEyLjgtNy42LjYtMTMuMS0yLjktMTMuNS0xMC42LS42LTE0LjMtLjUtNDEuMy4yLTU1LjUuMy02LjcgNi41LTEwLjggMTMuMS0xMC4yIDYuMy42IDEwLjcgNS4zIDExLjEgMTJ2MWMtLjEgNi4yLS4xIDEyLjYtLjEgMTguOXoiLz48cGF0aCBkPSJNMTc5IDM1My45di0yOGMwLTcuMyA1LjUtMTMuMyAxMi0xMy4zIDYuOC0uMSAxMi42IDUuOSAxMi42IDEzLjMuMSAxOC41LjEgMzcgMCA1NS40IDAgOC4xLTUuMyAxMy40LTEyLjkgMTMuMy02LjctLjEtMTEuNy01LjctMTEuOC0xMy4zIDAtOS4xIDAtMTguMy4xLTI3LjR6TTMwNS4yIDM1My45di0yOGMwLTcuMyA1LjUtMTMuMyAxMi0xMy4zIDYuOC0uMSAxMi42IDUuOSAxMi42IDEzLjMuMSAxOC41LjEgMzcgMCA1NS40IDAgOC4xLTUuMyAxMy40LTEyLjkgMTMuMy02LjctLjEtMTEuNy01LjctMTEuOC0xMy4zLjEtOS4xLjEtMTguMy4xLTI3LjR6TTI4My44IDE0OC45Yy4xLTcuOCA2LjctMTQuNCAxNC40LTE0LjMgNy45LjEgMTQuNyA3LjIgMTQuNiAxNS4yLS4xIDctNy42IDE0LjMtMTQuNyAxNC4zLTguMS4yLTE0LjQtNi41LTE0LjMtMTUuMnpNMjEwLjQgMTYzLjljLTcuOSAwLTEzLjktNi4zLTE0LTE0LjktLjEtNy41IDYuNy0xNC4xIDE0LjMtMTQuMSA4LjIgMCAxNC40IDYuMyAxNC41IDE0LjQgMCA4LjItNi40IDE0LjUtMTQuOCAxNC42eiIvPjwvc3ZnPg=='
        );
    }

    /**
     * Add the HTML for our page.
     */
    public function page()
    {
        ?>
        <div
            id="beetle-tracking-dashboard-app"
            class="-bt-ml-[20px]"
        ></div>
		<?php
    }

    /**
     * Add a body class on GP dashboard pages.
     *
     * @param string $classes The existing classes.
     */
    public function set_admin_body_class($classes)
    {
        $dashboard_pages = self::get_pages();
        $current_screen = get_current_screen();

        if (in_array($current_screen->id, $dashboard_pages)) {
            $classes .= ' beetle-tracking-dashboard-page';
        }

        return $classes;
    }

    /**
     * Get our dashboard pages so we can style them.
     */
    public static function get_pages()
    {
        return apply_filters(
            'beetle_tracking_dashboard_screens',
            [
                'toplevel_page_beetle-tracking-dashboard',
            ]
        );
    }

    /**
     * Add our scripts to the page.
     */
    public function enqueue_scripts()
    {
        $dashboard_pages = self::get_pages();
        $current_screen = get_current_screen();
        wp_tinymce_inline_scripts();

        if (in_array($current_screen->id, $dashboard_pages)) {
            wp_enqueue_style(
                'beetle-tracking-dashboard',
                BEETLE_TRACKING_DIR_URL . '/assets/css/admin.css',
                array( 'wp-components' ),
                BEETLE_TRACKING_VERSION
            );

            $asset = require_once BEETLE_TRACKING_DIR_PATH . '/assets/dist/dashboard.asset.php';
            $asset['dependencies'][] = 'react';
            $asset['dependencies'][] = 'wp-polyfill';
            $asset['dependencies'][] = 'wp-primitives';
            $asset['dependencies'][] = 'wp-api-fetch';
            $asset['dependencies'][] = 'regenerator-runtime';
            $asset['dependencies'][] = 'wp-api';
            $asset['dependencies'][] = 'wp-i18n';
            $asset['dependencies'][] = 'wp-components';
            $asset['dependencies'][] = 'wp-element';
            $asset['dependencies'][] = 'wp-media-utils';
            $asset['dependencies'] = array_unique($asset['dependencies']);

            wp_enqueue_script(
                'beetle-tracking-dashboard',
                BEETLE_TRACKING_DIR_URL . '/assets/dist/dashboard.js',
                $asset['dependencies'],
                $asset['version'],
                true
            );

            wp_set_script_translations('beetle-tracking-dashboard', 'beetle-tracking');

            wp_localize_script(
                'beetle-tracking-dashboard',
                'BeetleTrackingDashboard',
                apply_filters(
                    'beetle_tracking_dashboard_localize_script',
                    [
                        'hasPro' => defined('BEETLE_TRACKING_PRO_VERSION'),
                        'big_logo' => BEETLE_TRACKING_DIR_URL . '/assets/images/big-logo.png',
                        'plugin_url' => BEETLE_TRACKING_DIR_URL,
                        'user' => wp_get_current_user(),
                        'signed_up_newsletter' => get_user_meta(get_current_user_id(), 'beetle_tracking_signed_up_newsletter', true) ? true : false,
                        'nonce' => wp_create_nonce('wp_rest'),
                    ]
                )
            );
        }
    }

    public function default_settings($default)
    {
        return array_merge(
            /** Website events */
            \BeetleTracking\Schema\WebsiteEvents\Pageview::defaults(),
            \BeetleTracking\Schema\WebsiteEvents\Forms::defaults(),
            \BeetleTracking\Schema\WebsiteEvents\UserSignup::defaults(),
            \BeetleTracking\Schema\WebsiteEvents\UserLogin::defaults(),
            \BeetleTracking\Schema\WebsiteEvents\Download::defaults(),
            \BeetleTracking\Schema\WebsiteEvents\Comment::defaults(),
            \BeetleTracking\Schema\WebsiteEvents\TimeOnPage::defaults(),
            \BeetleTracking\Schema\WebsiteEvents\Search::defaults(),
            \BeetleTracking\Schema\WebsiteEvents\PageScroll::defaults(),
            \BeetleTracking\Schema\WebsiteEvents\PhoneLinks::defaults(),
            \BeetleTracking\Schema\WebsiteEvents\EmailLinks::defaults(),
            /** WooCommerce Events */
            \BeetleTracking\Schema\WooCommerce\AddToCart::defaults(),
            \BeetleTracking\Schema\WooCommerce\CheckoutPage::defaults(),
            \BeetleTracking\Schema\WooCommerce\OrderCompleted::defaults(),
            \BeetleTracking\Schema\WooCommerce\ProductCategoryPage::defaults(),
            \BeetleTracking\Schema\WooCommerce\ProductPage::defaults(),
            \BeetleTracking\Schema\WooCommerce\ProductRemoved::defaults(),
            /** Platforms */
            \BeetleTracking\Schema\Platform\GA4::defaults(),
            \BeetleTracking\Schema\Platform\Meta::defaults(),
            \BeetleTracking\Schema\Platform\GoogleAds::defaults(),
            \BeetleTracking\Schema\Platform\Pinterest::defaults(),
            \BeetleTracking\Schema\Platform\LinkedIn::defaults(),
            /** Consent */
            \BeetleTracking\Schema\Consent::defaults(),
            /** Advanced */
            \BeetleTracking\Schema\Advanced::defaults(),
            \BeetleTracking\Schema\License::defaults(),
        );
    }

    public function overriding_settings()
    {
        return array_merge(
            \BeetleTracking\Schema\License::override(),
        );
    }

    public function maybe_add_default_settings($options)
    {
        $options = array_merge(
            $this->default_settings([]),
            $options
        );

        $options = array_merge(
            $options,
            $this->overriding_settings()
        );

        return $options;
    }

    public function add_settings_to_wpml($result, $server, $request)
    {
        if ($request->get_route() === '/wp/v2/settings') {
            $method = $request->get_method();

            if ($method === 'POST') {
                $params = $request->get_params();

                if (isset($params['beetle_tracking_settings'])) {
                    $text_inputs = [
                        'consent_title' => 'Cookie banner title',
                        'consent_text' => 'Cookie banner text',
                        'consent_accept_all_text' => 'Cookie banner accept all text',
                        'consent_accept_selected_text' => 'Cookie banner accept selected text',
                        'consent_decline_all_text' => 'Cookie banner decline all text',
                        'consent_purpose_necessary_title' => 'Cookie banner necessary title',
                        'consent_purpose_necessary_text' => 'Cookie banner necessary text',
                        'consent_purpose_preferences_title' => 'Cookie banner preferences title',
                        'consent_purpose_preferences_text' => 'Cookie banner preferences text',
                        'consent_purpose_statistics_title' => 'Cookie banner statistics title',
                        'consent_purpose_statistics_text' => 'Cookie banner statistics text',
                        'consent_purpose_marketing_title' => 'Cookie banner marketing title',
                        'consent_purpose_marketing_text' => 'Cookie banner marketing text',
                    ];

                    foreach ($text_inputs as $key => $value) {
                        if (isset($params['beetle_tracking_settings'][$key])) {
                            do_action('wpml_register_single_string', 'Beetle Tracking', $value, sanitize_text_field($params['beetle_tracking_settings'][$key]));
                        }
                    }
                }

                $request->set_body_params($params);
            }
        }

        return $result;
    }
}
