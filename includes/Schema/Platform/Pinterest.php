<?php

namespace BeetleTracking\Schema\Platform;

class Pinterest
{
    public static function schema() : array
    {
        return [
            'pinterest_activated' => [
                'type' => 'boolean',
            ],
            'pinterest_id' => [
                'type' => 'string',
            ],
            'pinterest_api_token' => [
                'type' => 'string',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'pinterest_activated' => false,
            'pinterest_id' => '',
            'pinterest_api_token' => '',
        ];
    }
}
