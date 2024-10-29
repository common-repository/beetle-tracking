<?php

namespace BeetleTracking\Utils;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Taxonomy
{
    public static function get_object_terms($taxonomy, $post_id)
    {
        $terms = get_the_terms( $post_id, $taxonomy );

        if ( is_wp_error( $terms ) || empty ( $terms ) ) {
          return array();
        }

        $results = wp_list_pluck( $terms, 'name', 'term_id' );
        return array_map( 'html_entity_decode', $results );
    }
}
