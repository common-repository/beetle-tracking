<?php

namespace BeetleTracking\Utils\WooCommerce;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Order
{

    public static function get_events($order)
    {
        $tracked = $order->get_meta('_beetle_tracking_tracked_events', true);
        return is_array($tracked) ? $tracked : [];
    }

    public static function has_event($event, $order)
    {
        $tracked = self::get_events($order);
        return in_array($event, $tracked);
    }

    public static function add_event($event, $order)
    {
        $tracked = self::get_events($order);
        $tracked[] = $event;
        $order->update_meta_data('_beetle_tracking_tracked_events', $tracked);
        $order->save();
    }

    public static function get_params($order)
    {
        return apply_filters('BeetleTracking.Utils.WooCommerce.Order.get_params', [
            'order_id' => $order->get_id(),
            'total' => (float) $order->get_total(),
            'shipping' => (float) $order->get_shipping_total(),
            'tax' => (float) $order->get_total_tax(),
            'discount' => (float) $order->get_total_discount(),
            'coupon' => implode(', ', $order->get_coupon_codes()),
            'currency' => $order->get_currency(),
            'products' => self::get_products($order),
            'number_of_products' => $order->get_item_count(),
        ], $order);
    }

    public static function get_products($order)
    {
        $products = [];
        foreach ($order->get_items() as $item) {
            $product = $item->get_product();
            $products[] = Product::get_parameters($product, $item->get_quantity());
        }

        return $products;
    }
}
