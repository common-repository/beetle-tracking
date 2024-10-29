<?php

namespace BeetleTracking\Utils;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class User
{
    public static function get_current_user_roles()
    {
        $user = wp_get_current_user();

        if ($user->ID !== 0) {
            $user_roles = implode(',', $user->roles);
        } else {
            $user_roles = 'guest';
        }
        return $user_roles;
    }

    public static function get_current_user_page_data()
    {
        return [
            'url' => Url::get_refering(),
            'encoding' => $_SERVER['HTTP_ACCEPT_ENCODING'],
        ];
    }

    public static function get_current_user_device_data()
    {
        return [
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'ip' => Ip::get_user_ip(),
            'language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
        ];
    }

    public static function get_current_user_cookies()
    {
        $cookies = [];
        foreach ($_COOKIE as $key => $value) {
            if(strpos($key, 'cf') !== false) {
                $cookies[$key] = urlencode(stripslashes($value));
            }
        }

        return $cookies;
    }
}
