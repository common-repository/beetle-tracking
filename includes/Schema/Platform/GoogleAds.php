<?php

namespace BeetleTracking\Schema\Platform;

class GoogleAds
{
    public static function schema() : array
    {
        return [
            'google_ads_activated' => [
                'type' => 'boolean',
            ],
            'google_ads_conversion_linker' => [
                'type' => 'boolean',
            ],
            'google_ads_conversion_id' => [
                'type' => 'string',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'google_ads_activated' => true,
            'google_ads_conversion_linker' => true,
            'google_ads_conversion_id' => '',
        ];
    }
}
