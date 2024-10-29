<?php

namespace BeetleTracking\Schema\WebsiteEvents;

class Search
{
    public static function schema() : array
    {
        return [
            'track_searches_ga4' => [
                'type' => 'boolean',
            ],
            'track_searches_meta' => [
                'type' => 'boolean',
            ],
            'track_searches_google_ads' => [
                'type' => 'boolean',
            ],
            'track_searches_google_ads_label' => [
                'type' => 'string',
            ],
            'track_searches_pinterest' => [
                'type' => 'boolean',
            ],
            'track_searches_linkedin' => [
                'type' => 'boolean',
            ],
            'track_searches_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'track_searches_linkedin_conversion_id' => [
                'type' => 'string',
            ],
            'track_searches_bing' => [
                'type' => 'boolean',
            ],
            'track_searches_tiktok' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'track_searches_ga4' => true,
            'track_searches_meta' => true,
            'track_searches_google_ads' => true,
            'track_searches_google_ads_label' => '',
            'track_searches_pinterest' => true,
            'track_searches_linkedin' => true,
            'track_searches_linkedin_partner_id' => '',
            'track_searches_linkedin_conversion_id' => '',
            'track_searches_bing' => true,
            'track_searches_tiktok' => true,
        ];
    }
}
