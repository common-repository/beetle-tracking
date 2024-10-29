<?php

namespace BeetleTracking\Schema\WebsiteEvents;

class Forms
{
    public static function schema() : array
    {
        return [
            'track_forms_ga4' => [
                'type' => 'boolean',
            ],
            'track_forms_meta' => [
                'type' => 'boolean',
            ],
            'track_forms_google_ads' => [
                'type' => 'boolean',
            ],
            'track_forms_google_ads_remarketing' => [
                'type' => 'boolean',
            ],
            'track_forms_google_ads_label' => [
                'type' => 'string',
            ],
            'track_forms_pinterest' => [
                'type' => 'boolean',
            ],
            'track_forms_linkedin' => [
                'type' => 'boolean',
            ],
            'track_forms_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'track_forms_linkedin_conversion_id' => [
                'type' => 'string',
            ],
            'track_forms_bing' => [
                'type' => 'boolean',
            ],
            'track_forms_tiktok' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'track_forms_ga4' => true,
            'track_forms_meta' => true,
            'track_forms_google_ads' => true,
            'track_forms_google_ads_remarketing' => true,
            'track_forms_google_ads_label' => '',
            'track_forms_pinterest' => true,
            'track_forms_linkedin' => true,
            'track_forms_linkedin_partner_id' => '',
            'track_forms_linkedin_conversion_id' => '',
            'track_forms_bing' => true,
            'track_forms_tiktok' => true,
        ];
    }
}
