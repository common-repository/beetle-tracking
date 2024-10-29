<?php

namespace BeetleTracking\Schema\Platform;

class Meta
{
    public static function schema() : array
    {
        return [
            'meta_activated' => [
                'type' => 'boolean',
            ],
            'meta_id' => [
                'type' => 'string',
            ],
            'meta_conversion_api' => [
                'type' => 'string',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'meta_activated' => true,
            'meta_id' => '',
            'meta_conversion_api' => '',
        ];
    }
}
