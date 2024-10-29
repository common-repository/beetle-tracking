<?php

namespace BeetleTracking\Schema\Platform;

class TikTok
{
    public static function schema() : array
    {
        return [
            'tiktok_activated' => [
                'type' => 'boolean',
            ],
            'tiktok_pixel_code' => [
                'type' => 'string',
            ],
            'tiktok_access_token' => [
                'type' => 'string',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'tiktok_activated' => false,
            'tiktok_pixel_code' => '',
            'tiktok_access_token' => '',
        ];
    }
}
