<?php

namespace BeetleTracking\Utils\WooCommerce;

use BeetleTracking\Utils\Settings;
use BeetleTracking\Utils\Taxonomy;
use BeetleTracking\Utils\CustomAudience;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Product
{
    public static function get_parameters($product, $quantity)
    {
        $product_params = [
            'name' => self::get_name($product->get_id()),
            'category' => self::get_category($product->get_id()),
            "id" => $product->get_id(),
            "sku" =>  $product->get_sku(),
            'tags' => implode(', ', Taxonomy::get_object_terms('tag', $product->get_id())),
            'quantity' => $quantity,
            'currency' => get_woocommerce_currency(),
            'price' => self::get_product_value([
                'product_id' => $product->get_id(),
                'quantity' => $quantity
            ]),
        ];

        return $product_params;
    }

    /**
     * Get product value (price)
     * @param array $args
     * @return float
     * @throws Exception
     */
    public static function get_product_value($args)
    {
        $product_id = $args['product_id'];
        $quantity = $args['quantity'];

        $product = wc_get_product($product_id);
        if(!$product) {
            return 0;
        }

        return (float) self::get_product_display_price($product_id, $quantity);
    }

    /**
     * Get product sale price
     *
     * @param \WC_product $product
     * @param mixed $args
     * @return float|-1
     */
    public static function get_product_sale_price($product, $args)
    {
        if($product) {
            if(!empty($args['discount_value']) && !empty($args['discount_type'])) {
                $product_price = $product->get_price();
                if($args['discount_type'] == "discount_percent") {
                    $percent = $args['discount_value'] / 100;
                    return $product_price - $product_price * $percent;
                } elseif ($args['discount_type'] == "discount_price") {
                    return $product_price - $args['discount_value'];
                }
            }
        }

        return -1;
    }

    public static function get_product_display_price($product_id, $qty = 1)
    {

        if (! $product = wc_get_product($product_id)) {
            return 0;
        }

        $productPrice = "";

        // take min price for variable product
        if($product->get_type() == "variable") {
            $prices = $product->get_variation_prices(true);
            if(!empty($prices['price'])) {
                $productPrice = current($prices['price']);
            }
        }

        return wc_get_price_to_display(
            $product,
            array(
                'qty' => $qty,
                'price'=>$productPrice
            )
        );
    }

    public static function get_name($post_id)
    {
        $post = get_post($post_id);
        if (! $post) {
            return null;
        }

        return $post->post_title;
    }

    public static function get_category($post_id)
    {
        $post = get_post($post_id);
        if (! $post) {
            return null;
        }

        if ($post->post_type == 'product_variation') {
            $post_id = $post->post_parent;
        }

        return implode(', ', Taxonomy::get_object_terms('product_cat', $post_id));
    }
}
