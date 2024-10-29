<?php

namespace BeetleTracking\Schema;

class Advanced
{
    public static function schema() : array
    {
        return [
            'enable_debugging' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'enable_debugging' => false,
        ];
    }
}
