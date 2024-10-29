<?php

namespace BeetleTracking\Schema\Platform;

class GA4
{
    public static function schema() : array
    {
        return [
            'ga4_activated' => [
                'type' => 'boolean',
            ],
            'ga4_measurement_id' => [
                'type' => 'string',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'ga4_activated' => true,
            'ga4_measurement_id' => '',
        ];
    }
}
