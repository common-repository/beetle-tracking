<?php

namespace BeetleTracking\Schema\Platform;

class LinkedIn
{
    public static function schema() : array
    {
        return [
            'linkedin_activated' => [
                'type' => 'boolean',
            ],
            'linkedin_partner_id' => [
                'type' => 'string',
            ],
            'linkedin_conversion_id' => [
                'type' => 'string',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'linkedin_activated' => true,
            'linkedin_partner_id' => '',
            'linkedin_conversion_id' => '',
        ];
    }
}
