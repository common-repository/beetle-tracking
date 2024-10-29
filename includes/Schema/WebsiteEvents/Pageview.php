<?php

namespace BeetleTracking\Schema\WebsiteEvents;

class Pageview
{
    public static function schema() : array
    {
        return [
            'track_pageviews_ga4' => [
                'type' => 'boolean',
            ],
            'track_pageviews_meta' => [
                'type' => 'boolean',
            ],
            'track_pageviews_google_ads' => [
                'type' => 'boolean',
            ],
            'track_pageviews_google_ads_remarketing' => [
                'type' => 'boolean',
            ],
            'track_pageviews_google_ads_label' => [
                'type' => 'string',
            ],
            'track_pageviews_pinterest' => [
                'type' => 'boolean',
            ],
            'track_pageviews_linkedin' => [
                'type' => 'boolean',
            ],
            'track_pageviews_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'track_pageviews_linkedin_conversion_id' => [
                'type' => 'string',
            ],
            'track_pageviews_bing' => [
                'type' => 'boolean',
            ],
            'track_pageviews_tiktok' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'track_pageviews_ga4' => true,
            'track_pageviews_meta' => true,
            'track_pageviews_google_ads' => true,
            'track_pageviews_google_ads_remarketing' => true,
            'track_pageviews_google_ads_label' => '',
            'track_pageviews_pinterest' => true,
            'track_pageviews_linkedin' => true,
            'track_pageviews_linkedin_partner_id' => '',
            'track_pageviews_linkedin_conversion_id' => '',
            'track_pageviews_bing' => true,
            'track_pageviews_tiktok' => true,
        ];
    }
}
