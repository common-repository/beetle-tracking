<?php

namespace BeetleTracking;

use BeetleTracking\Utils\Settings;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class TrackingPlugin
{
    public $main_file;

    public function __construct($main_file)
    {
        $this->main_file = $main_file;
        register_activation_hook($this->main_file, array($this, 'activate'));

        new Controller\UpgradeController;
        new Controller\DashboardController;
        new Controller\FrontendController;
        new Controller\WebsiteEventsController;
        new Controller\NewsletterController;
        new Controller\FeatureRequestController;
        new Controller\SettingsPushController;

        add_action('before_woocommerce_init', array($this, 'WooCommerceBeforeInit'));
        add_action('woocommerce_init', array($this, 'WooCommerceInit'));
        do_action('beetle_tracking_tracking_init', $this);
    }

    public function WooCommerceBeforeInit()
    {
        if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', $this->main_file, true);
        }
    }

    public function WooCommerceInit()
    {
        new Controller\WooCommerceController;

        // if debugging is enabled
        if(Settings::get('enable_debugging')) {
            new Controller\WooCommerce\Admin\OrderMetaBoxController;
        }
    }

    public function activate()
    {

    }
}
