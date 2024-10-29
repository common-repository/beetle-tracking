<?php

namespace BeetleTracking\Controller\WooCommerce\Admin;

use BeetleTracking\Utils\WooCommerce\Order;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class OrderMetaBoxController
{

    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_meta_box']);
    }

    public function add_meta_box()
    {
        $screen_id = 'shop_order';

        add_meta_box(
            'beetle-tracking-order-events',
            __('Beetle Tracking Events', 'beetle-tracking'),
            [$this, 'render_meta_box'],
            $screen_id,
            'normal',
            'default'
        );
    }

    public function render_meta_box($post_id)
    {
        $order = wc_get_order($post_id);
        $tracked = \BeetleTracking\Utils\WooCommerce\Order::get_events($order);
        $parmas = Order::get_params($order);
        ?>
        <strong><?= __('Tracked Events:', 'beetle-tracking'); ?></strong>
        <ul>
            <?php foreach ($tracked as $event) : ?>
                <li><?php echo $event; ?></li>
            <?php endforeach; ?>
        </ul>
        <hr>
        <strong><?= __('Parameters:', 'beetle-tracking'); ?></strong>
        <pre>
            <?php print_r($parmas); ?>
        </pre>
        <?php
    }
}
