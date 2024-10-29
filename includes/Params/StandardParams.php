<?php

namespace BeetleTracking\Params;

use BeetleTracking\Utils\Url;
use BeetleTracking\Utils\User;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class StandardParams
{
    public static function get_frontend_params()
    {
        global $post;
        $cpt = get_post_type();
        $params = array(
            'page_title' => "",
            'post_type' => $cpt,
            'post_id' => "",
        );

        $params['user_role'] = User::get_current_user_roles();
        $params['event_url'] = Url::get_current(true);
        $params['logged_in_status'] = is_user_logged_in() ? 'logged_in' : 'logged_out';

        if (is_singular('post')) {
            $params['page_title'] = $post->post_title;
            $params['post_id'] = $post->ID;
        } elseif (is_singular('page') || is_home()) {
            $params['post_type'] = 'page';
            $params['post_id'] = is_home() ? null : $post->ID;
            $params['page_title'] = is_home() == true ? get_bloginfo('name') : $post->post_title;
        } elseif (class_exists('woocommerce') && is_shop()) {
            $page_id = (int) wc_get_page_id('shop');
            $params['post_type'] = 'page';
            $params['post_id']   = $page_id;
            $params['page_title'] = get_the_title($page_id);
        } elseif (is_category()) {
            $cat  = get_query_var('cat');
            $term = get_category($cat);
            $params['post_type'] = 'category';
            $params['post_id'] = $cat;
            $params['page_title'] = $term->name;
        } elseif (is_tag()) {
            $slug = get_query_var('tag');
            $term = get_term_by('slug', $slug, 'post_tag');
            $params['post_type'] = 'tag';
            if ($term) {
                $params['post_id'] = $term->term_id;
                $params['page_title'] = $term->name;
            }
        } elseif (is_tax()) {
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $params['post_type'] = get_query_var('taxonomy');
            if ($term) {
                $params['post_id'] = $term->term_id;
                $params['page_title'] = $term->name;
            }
        } elseif (class_exists('woocommerce') && $cpt == 'product') {
            $params['page_title'] = $post->post_title;
            $params['post_id']   = $post->ID;
        } elseif ($post instanceof \WP_Post) {
            $params['page_title'] = $post->post_title;
            $params['post_id']   = $post->ID;
        }

        return $params;
    }

    public static function get_system_params()
    {
        return [
            'page' => User::get_current_user_page_data(),
            'device' => User::get_current_user_device_data(),
            'cookies' => User::get_current_user_cookies(),
        ];
    }
}
