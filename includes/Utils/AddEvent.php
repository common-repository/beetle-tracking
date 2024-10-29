<?php

namespace BeetleTracking\Utils;

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class AddEvent
{
    public static function add($event)
    {
        add_filter('beetle_tracking_events', function ($events) use ($event) {
            if (!in_array($event->get('name'), array_map(function ($event) {
                return $event->get('name');
            }, $events))) {
                $events[] = $event;
            }

            return array_values($events);
        });
    }
}
