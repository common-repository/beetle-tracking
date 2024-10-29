<?php

namespace BeetleTracking\Schema\Platform;

class Bing
{
    public static function schema() : array
    {
        return [
            'bing_activated' => [
                'type' => 'boolean',
            ],
            'bing_tag_id' => [
                'type' => 'string',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'bing_activated' => false,
            'bing_tag_id' => '',
        ];
    }
}
