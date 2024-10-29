<?php

namespace BeetleTracking\Schema\WebsiteEvents;

class TimeOnPage
{
    public static function schema() : array
    {
        return [
            // Deprecated
            'track_time_on_page_after_seconds' => [
                'type' => 'integer',
            ],
            'track_time_on_page_after_seconds_ga4' => [
                'type' => 'integer',
            ],
            'track_time_on_page_after_seconds_meta' => [
                'type' => 'integer',
            ],
            'track_time_on_page_after_seconds_google_ads' => [
                'type' => 'integer',
            ],
            'track_time_on_page_after_seconds_pinterest' => [
                'type' => 'integer',
            ],
            'track_time_on_page_after_seconds_linkedin' => [
                'type' => 'integer',
            ],
            'track_time_on_page_after_seconds_bing' => [
                'type' => 'integer',
            ],
            'track_time_on_page_after_seconds_tiktok' => [
                'type' => 'integer',
            ],
            'track_time_on_page_ga4' => [
                'type' => 'boolean',
            ],
            'track_time_on_page_meta' => [
                'type' => 'boolean',
            ],
            'track_time_on_page_google_ads' => [
                'type' => 'boolean',
            ],
            'track_time_on_page_google_ads_label' => [
                'type' => 'string',
            ],
            'track_time_on_page_pinterest' => [
                'type' => 'boolean',
            ],
            'track_time_on_page_linkedin' => [
                'type' => 'boolean',
            ],
            'track_time_on_page_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'track_time_on_page_linkedin_conversion_id' => [
                'type' => 'string',
            ],
            'track_time_on_page_bing' => [
                'type' => 'boolean',
            ],
            'track_time_on_page_tiktok' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'track_time_on_page_after_seconds_ga4' => 30,
            'track_time_on_page_after_seconds_meta' => 30,
            'track_time_on_page_after_seconds_google_ads' => 30,
            'track_time_on_page_after_seconds_pinterest' => 30,
            'track_time_on_page_after_seconds_linkedin' => 30,
            'track_time_on_page_after_seconds_bing' => 30,
            'track_time_on_page_after_seconds_tiktok' => 30,
            'track_time_on_page_ga4' => true,
            'track_time_on_page_meta' => true,
            'track_time_on_page_google_ads' => true,
            'track_time_on_page_google_ads_label' => '',
            'track_time_on_page_pinterest' => true,
            'track_time_on_page_linkedin' => true,
            'track_time_on_page_linkedin_partner_id' => '',
            'track_time_on_page_linkedin_conversion_id' => '',
            'track_time_on_page_bing' => true,
            'track_time_on_page_tiktok' => true,
            // Deprecated
            'track_time_on_page_after_seconds' => 30,
        ];
    }
}
