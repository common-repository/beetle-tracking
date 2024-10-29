<?php

namespace BeetleTracking\Schema;

class License
{
    public static function schema() : array
    {
        return [
            'license' => [
                'type' => 'string',
            ],
            'license_activated' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'license' => '',
            'license_activated' => false,
        ];
    }

    public static function override() : array
    {
        $activated = false;
        if (class_exists('BeetleTrackingPro\License\License')) {
            $activated = \BeetleTrackingPro\License\License::isActive();
        }

        return [
            'license_activated' => $activated
        ];
    }
}
