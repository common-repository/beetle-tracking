<?php

namespace BeetleTracking\Schema\WebsiteEvents;

class EmailLinks
{
    public static function schema() : array
    {
        return [
            'track_email_links_ga4' => [
                'type' => 'boolean',
            ],
            'track_email_links_meta' => [
                'type' => 'boolean',
            ],
            'track_email_links_google_ads' => [
                'type' => 'boolean',
            ],
            'track_email_links_google_ads_label' => [
                'type' => 'string',
            ],
            'track_email_links_pinterest' => [
                'type' => 'boolean',
            ],
            'track_email_links_linkedin' => [
                'type' => 'boolean',
            ],
            'track_email_links_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'track_email_links_linkedin_conversion_id' => [
                'type' => 'string',
            ],
            'track_email_links_bing' => [
                'type' => 'boolean',
            ],
            'track_email_links_tiktok' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'track_email_links_ga4' => true,
            'track_email_links_meta' => true,
            'track_email_links_google_ads' => true,
            'track_email_links_google_ads_label' => '',
            'track_email_links_pinterest' => true,
            'track_email_links_linkedin' => true,
            'track_email_links_linkedin_partner_id' => '',
            'track_email_links_linkedin_conversion_id' => '',
            'track_email_links_bing' => true,
            'track_email_links_tiktok' => true,
        ];
    }
}
