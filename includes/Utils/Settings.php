<?php

namespace BeetleTracking\Utils;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class Settings
{
    public static function get($key, $default = null)
    {
        $settings = get_option('beetle_tracking_settings', []);
        $value = isset($settings[$key]) ? $settings[$key] : $default;
        return $value;
    }

    public static function update($key, $value)
    {
        $settings = get_option('beetle_tracking_settings', []);
        $settings[$key] = $value;
        update_option('beetle_tracking_settings', $settings);
    }

    public static function is_event_active($event)
    {
        $settings = get_option('beetle_tracking_settings', []);

        return apply_filters(
            'BeetleTracking.Utils.is_event_active',
            (
                (
                    $settings['meta_activated'] &&
                    $settings[$event . '_meta']
                ) ||
                (
                    $settings['ga4_activated'] &&
                    $settings[$event . '_ga4']
                ) ||
                (
                    $settings['google_ads_activated'] &&
                    $settings[$event . '_google_ads']
                )
            )
        );
    }
}
