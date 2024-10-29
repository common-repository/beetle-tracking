<?php

namespace BeetleTracking\Controller;

use BeetleTracking\Utils\Url;
use BeetleTracking\Models\Event;
use BeetleTracking\Utils\AddEvent;
use BeetleTracking\Utils\Settings;
use BeetleTracking\Cloudflare\Zaraz;
use BeetleTracking\Params\StandardParams;
use BeetleTracking\Utils\User;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Class WebsiteEventsController
 *
 * Takes care of the website events which is "server side" events.
 *
 * @package Zee\Controller
 */
class WebsiteEventsController
{
    public function __construct()
    {
        // track user logins
        add_action('wp_login', [$this,'user_login'], 10, 2);

        // track user registrations
        add_action('user_register', array( $this, 'user_register_handler' ));

        if(Settings::is_event_active('track_pageviews', true)) {
            add_action('template_redirect', array($this, 'setup_static_events'));
        }
    }

    /**
     * Setup static events
     */
    public function setup_static_events()
    {
        $this->track_pageview();
    }

    /**
     * Track pageviews
     */
    public function track_pageview()
    {
        AddEvent::add(new Event(
            'BeetlePageView',
            'WebsiteEvent',
            []
        ));
    }

    /**
     * Track user logins
     *
     * @param $user_login
     * @param $user
     */
    public function user_login($user_login, $user)
    {
        if (!Settings::is_event_active('track_user_login', true)) {
            return;
        }

        Zaraz::track(
            'UserLogin',
            [
                'user_id' => $user->ID,
                'user_login' => $user->user_login,
                'user_email' => $user->user_email,
                'user_role' => $user->roles[0],
            ],
            StandardParams::get_system_params(),
        );
    }

    /**
     * Track user registrations
     *
     * @param $user_id
     */
    public function user_register_handler($user_id)
    {
        if (!Settings::is_event_active('track_user_signup')) {
            return;
        }

        $user = get_user_by('id', $user_id);

        Zaraz::track(
            'SignUp',
            [
                'user_id' => $user_id,
                'user_login' => $user->user_login,
                'user_email' => $user->user_email,
            ],
            StandardParams::get_system_params(),
        );
    }
}
