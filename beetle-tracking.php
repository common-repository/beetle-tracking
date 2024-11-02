<?php
/**
 * Plugin Name: Beetle Tracking - Cloudflare Zaraz for WooCommerce
 * Plugin URI: https://rocketbeetle.com/beetle-tracking
 * Description: Implement Cloudflare Zaraz tracking on your site. Tracking key events with our automated tracking, and add you own custom tracking. WooCommerce is fully supported.
 * Version: 1.6.4
 * Requires PHP: 7.4
 * Author: RocketBeetle
 * Author URI: https://rocketbeetle.com
 * Tested up to: 6.4
 * WC tested up to: 8.2
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: beetle-tracking
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('BEETLE_TRACKING_VERSION', '1.3.1');
define('BEETLE_TRACKING_DIR_PATH', plugin_dir_path(__FILE__));
define('BEETLE_TRACKING_DIR_URL', plugin_dir_url(__FILE__));

require 'autoload.php';

new BeetleTracking\TrackingPlugin(__FILE__);
