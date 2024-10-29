<?php

namespace BeetleTracking\Cloudflare;

use BeetleTracking\Utils\Ip;
use BeetleTracking\Utils\Url;
use BeetleTracking\Utils\User;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class Zaraz
{
    public static function track($eventName, $clientParams = [], $systemParams = [], $isEcommerce = false)
    {
        $pushParams = [
            'events' => [
                [
                    'client' => [
                        '__zarazTrack' => $eventName,
                        '__zarazEcommerce' => $isEcommerce,
                        'plugin' => "Beetle Tracking",
                        'user_role' => User::get_current_user_roles(),
                        'timestamp' => time(),
                    ],
                    'system' => $systemParams
                ]
            ]
        ];

        $pushParams['events'][0]['client'] = array_merge($pushParams['events'][0]['client'], $clientParams);
        $url = site_url() .  '/cdn-cgi/zaraz/api';
        $response = wp_remote_post($url, array(
            'method' => 'POST',
            'timeout' => 10,
            'blocking' => true,
            'headers' => array(),
            'body' => json_encode($pushParams)
        ));

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            error_log("Beetle Tracking: Something went wrong with request to Zaraz: $error_message");
        }
    }
}
