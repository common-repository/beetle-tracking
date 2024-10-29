<?php

namespace BeetleTracking\Utils;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class Url
{
    public static function get_current($removeQuery = false)
    {
        if ($removeQuery) {
            return $_SERVER['HTTP_HOST'] . str_replace("?".$_SERVER['QUERY_STRING'], "", $_SERVER['REQUEST_URI']);
        }
        return  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ;
    }

    public static function get_refering()
    {
        return  $_SERVER['HTTP_REFERER'];
    }
}
