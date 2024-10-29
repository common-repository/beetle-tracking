<?php

namespace BeetleTracking\Schema\WebsiteEvents;

class Download
{
    public static function schema() : array
    {
        return [
            'track_downloads_ga4' => [
                'type' => 'boolean',
            ],
            'track_downloads_meta' => [
                'type' => 'boolean',
            ],
            'track_downloads_google_ads' => [
                'type' => 'boolean',
            ],
            'track_downloads_google_ads_label' => [
                'type' => 'string',
            ],
            'track_downloads_pinterest' => [
                'type' => 'boolean',
            ],
            'track_downloads_linkedin' => [
                'type' => 'boolean',
            ],
            'track_downloads_bing' => [
                'type' => 'boolean',
            ],
            'track_downloads_tiktok' => [
                'type' => 'boolean',
            ],
            'track_downloads_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'track_downloads_linkedin_conversion_id' => [
                'type' => 'string',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'track_downloads_ga4' => true,
            'track_downloads_meta' => true,
            'track_downloads_google_ads' => true,
            'track_downloads_google_ads_label' => '',
            'track_downloads_pinterest' => true,
            'track_downloads_linkedin' => true,
            'track_downloads_linkedin_partner_id' => '',
            'track_downloads_bing' => true,
            'track_downloads_tiktok' => true,
        ];
    }
}
