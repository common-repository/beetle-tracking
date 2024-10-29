<?php

namespace BeetleTracking\Schema\WebsiteEvents;

class PageScroll
{
    public static function schema() : array
    {
        return [
            'track_page_scroll_percentages' => [
                'type' => 'string',
            ],
            'track_page_scroll_ga4' => [
                'type' => 'boolean',
            ],
            'track_page_scroll_meta' => [
                'type' => 'boolean',
            ],
            'track_page_scroll_google_ads' => [
                'type' => 'boolean',
            ],
            'track_page_scroll_google_ads_label' => [
                'type' => 'string',
            ],
            'track_page_scroll_pinterest' => [
                'type' => 'boolean',
            ],
            'track_page_scroll_linkedin' => [
                'type' => 'boolean',
            ],
            'track_page_scroll_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'track_page_scroll_linkedin_conversion_id' => [
                'type' => 'string',
            ],
            'track_page_scroll_bing' => [
                'type' => 'boolean',
            ],
            'track_page_scroll_tiktok' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'track_page_scroll_percentages' => '50',
            'track_page_scroll_ga4' => true,
            'track_page_scroll_meta' => true,
            'track_page_scroll_google_ads' => true,
            'track_page_scroll_google_ads_label' => '',
            'track_page_scroll_pinterest' => true,
            'track_page_scroll_linkedin' => true,
            'track_page_scroll_linkedin_partner_id' => '',
            'track_page_scroll_linkedin_conversion_id' => '',
            'track_page_scroll_bing' => true,
            'track_page_scroll_tiktok' => true,
        ];
    }
}
