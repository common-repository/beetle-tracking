<?php

namespace BeetleTracking\Controller;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class UpgradeController
{

    public function __construct()
    {
        add_action('init', array( $this, 'upgrade' ));
    }

    public function upgrade()
    {
        if (defined('DOING_AJAX') && DOING_AJAX) {
            return;
        }

        if (! is_admin() || ! current_user_can('manage_options')) {
            return;
        }

        $beetle_tracking_core_version = get_option('beetle_tracking_core_version', '1.0.0');

        if ($beetle_tracking_core_version && version_compare($beetle_tracking_core_version, '1.3.0', '<')) {
            $this->upgrade_1_2_0();

            update_option('beetle_tracking_core_version', BEETLE_TRACKING_VERSION);
            update_option('beetle_tracking_updated_at', time());
        }
    }

    private function upgrade_1_2_0()
    {
        delete_option('zee_settings');
    }
}
