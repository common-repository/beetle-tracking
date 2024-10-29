<?php

namespace BeetleTracking\Controller;

use BeetleTracking\Models\Event;
use BeetleTracking\Utils\AddEvent;
use BeetleTracking\Utils\Settings;
use BeetleTracking\Utils\Taxonomy;
use BeetleTracking\Utils\WooCommerce\Order;
use BeetleTracking\Utils\WooCommerce\Product;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class WooCommerceController
{
    public function __construct()
    {
        if (Settings::is_event_active('woocommerce_track_add_to_cart')) {
            add_action('woocommerce_after_shop_loop_item', array( $this, 'setup_loop_product_data' ));
            add_action('woocommerce_after_add_to_cart_button', array( $this, 'setup_add_to_cart_product_data' ));
            add_filter('woocommerce_blocks_product_grid_item_html', array( $this, 'setup_blocks_product_data' ), 10, 3);
        }

        if (Settings::is_event_active('woocommerce_track_product_removed')) {
            add_action('wp_footer', array( $this, 'setup_cart_content' ));
        }

        add_action('template_redirect', array( $this, 'setup_static_events' ));
    }

    public function setup_static_events()
    {
        if (Settings::is_event_active('woocommerce_track_product_category_page') && is_product_category()) {
            $this->setup_product_category_event();
        }

        if (Settings::is_event_active('woocommerce_track_product_page') && is_product()) {
            $this->setup_product_page_event();
        }

        if (
            Settings::is_event_active('woocommerce_track_checkout_page')
            && is_checkout()
            && !is_wc_endpoint_url()
            && count(WC()->cart->get_cart()) > 0
        ) {
            $this->setup_checkout_page_event();
        }

        $is_order_received_page = function_exists('is_order_received_page') && is_order_received_page();
        if (is_plugin_active('elementor/elementor.php')) {
            global $post;
            $elementor_page_id = get_option('elementor_woocommerce_purchase_summary_page_id');
            if (
                $post &&
                isset($post->ID) &&
                $elementor_page_id == $post->ID
            ) {
                $is_order_received_page = true;
            }
        }

        if (Settings::is_event_active('woocommerce_order_completed') && $is_order_received_page) {
            $this->setup_purchase_event();
        }
    }

    public function setup_loop_product_data()
    {
        global $product;
        $this->setup_product_data($product);
    }

    public function setup_add_to_cart_product_data()
    {
        /** @var \WC_Product $product */
        global $product;
        $this->setup_product_data($product);
    }

    public function setup_blocks_product_data($html, $attributes, $product)
    {
        if (defined('REST_REQUEST') && REST_REQUEST) {
            return $html;
        }

        $this->setup_product_data($product);
        return $html;
    }

    public function setup_product_data($product)
    {
        if (!is_a($product, "WC_Product")) {
            return;
        }

        $original_product = $product;
        $quantity = 1;

        $params = Product::get_parameters($product, $quantity);
        $product_ids = array();
        $isGrouped = $product->get_type() == "grouped";

        if ($isGrouped) {
            $product_ids = $product->get_children();
        } elseif ($product->is_type('variable')) {
            $product_ids = array_merge($product_ids, $product->get_children());
        } else {
            $product_ids[] = $product->get_id();
        }

        foreach ($product_ids as $product_id) {
            $product = wc_get_product($product_id);
            if (!$product || ($product->get_type() == "variable" && $isGrouped)) {
                continue;
            }

            $params['connected'][$product->get_id()] = Product::get_parameters($product, $quantity);
        }


        if (empty($params)) {
            return;
        }

        ?>
            <script type="application/javascript">
                /* <![CDATA[ */
                window.BeetleTrackingProductData = window.BeetleTrackingProductData || [];
                window.BeetleTrackingProductData[ <?php echo $original_product->get_id(); ?> ] = <?php echo json_encode($params); ?>;
                /* ]]> */
            </script>
        <?php
    }

    public function setup_cart_content()
    {
        $params = array();
        $cart_contents = array();

        $cart = WC()->cart->get_cart();
        if (!empty($cart)) {
            foreach ($cart as $cart_item_key => $cart_item) {
                if (isset($cart_item['variation_id']) && $cart_item['variation_id'] !== 0) {
                    $product_id = $cart_item['variation_id'];
                } else {
                    $product_id = $cart_item['product_id'];
                }

                $product = wc_get_product($product_id);
                $cart_contents[$cart_item_key] = Product::get_parameters($product, $cart_item['quantity']);
            }
        }


        if (empty($cart_contents)) {
            return;
        }

        ?>
            <script type="application/javascript">
                /* <![CDATA[ */
                window.BeetleTrackingWooCommerceCartContent = window.BeetleTrackingWooCommerceCartContent || [];
                window.BeetleTrackingWooCommerceCartContent = <?php echo json_encode($cart_contents); ?>;
                /* ]]> */
            </script>
        <?php
    }

    private function setup_product_category_event()
    {
        global $posts;

        $products = array();

        // Maybe make this bigger in the pro version
        $limit = min(count($posts), 4);
        $term = get_term_by('slug', get_query_var('term'), 'product_cat');

        for ($i = 0; $i < $limit; $i ++) {
            $product = wc_get_product($posts[ $i ]->ID);
            if (is_a($product, "WC_Product")) {
                $products[] = [
                    "name" => $product->get_name(),
                    "id" => $product->get_id(),
                    "sku" =>  $product->get_sku(),
                    "category" => $term->name,
                ];
            }
        }

        AddEvent::add(new Event(
            'Product List Viewed',
            'WooCommerce',
            [
                'products' => $products
            ]
        ));
    }

    private function setup_product_page_event()
    {
        global $post;

        $product = wc_get_product($post->ID);
        $params = Product::get_parameters($product, 1);
        $params['value'] = Product::get_product_value([
            'quantity' => 1,
            'product_id' => $product->get_id(),
        ]);

        $params["price"] = (float) $product->get_price();
        $params["currency"] = get_woocommerce_currency();

        AddEvent::add(new Event(
            'Product Viewed',
            'WooCommerce',
            $params
        ));
    }

    private function setup_checkout_page_event()
    {
        $params = array();

        $cart = WC()->cart->get_cart();
        $cart_contents = [];
        if (!empty($cart)) {
            foreach ($cart as $cart_item) {
                if (isset($cart_item['variation_id']) && $cart_item['variation_id'] !== 0) {
                    $product_id = $cart_item['variation_id'];
                } else {
                    $product_id = $cart_item['product_id'];
                }

                $product = wc_get_product($product_id);
                $cart_contents[] = Product::get_parameters($product, $cart_item['quantity']);
            }
        }

        $params = [
            'total' => (float) WC()->cart->total,
            'shipping' => (float) WC()->cart->shipping_total,
            'tax' => (float) WC()->cart->tax_total,
            'discount' => (float) WC()->cart->discount_total,
            'coupon' => implode(', ', WC()->cart->get_applied_coupons()),
            'currency' => get_woocommerce_currency(),
            'products' => $cart_contents,
            'number_of_products' => WC()->cart->get_cart_contents_count(),
        ];

        AddEvent::add(new Event(
            'Checkout Started',
            'WooCommerce',
            $params
        ));
    }

    public function setup_purchase_event()
    {
        if (!isset($_REQUEST['key']) || empty($_REQUEST['key'])) {
            return;
        }

        $order_id = (int) wc_get_order_id_by_order_key(sanitize_key($_REQUEST['key']));
        if (empty($order_id)) {
            return;
        }

        $order = wc_get_order($order_id);
        if (empty($order)) {
            return;
        }

        if (Order::has_event('Order Completed', $order)) {
            return;
        }

        AddEvent::add(new Event(
            'Order Completed',
            'WooCommerce',
            Order::get_params($order),
        ));

        Order::add_event('Order Completed', $order);
    }
}
