<?php

namespace BeetleTracking\Schema;

class Cloudflare
{
    public static function schema() : array
    {
        return [
            'cloudflare_api_key' => [
                'type' => 'string',
            ],
            'cloudflare_zone_id' => [
                'type' => 'string',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'cloudflare_api_key' => '',
            'cloudflare_zone_id' => '',
        ];
    }
}
