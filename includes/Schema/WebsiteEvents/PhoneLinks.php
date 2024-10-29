<?php

namespace BeetleTracking\Schema\WebsiteEvents;

class PhoneLinks
{
    public static function schema() : array
    {
        return [
            'track_phone_number_links_ga4' => [
                'type' => 'boolean',
            ],
            'track_phone_number_links_meta' => [
                'type' => 'boolean',
            ],
            'track_phone_number_links_google_ads' => [
                'type' => 'boolean',
            ],
            'track_phone_number_links_google_ads_label' => [
                'type' => 'string',
            ],
            'track_phone_number_links_pinterest' => [
                'type' => 'boolean',
            ],
            'track_phone_number_links_linkedin' => [
                'type' => 'boolean',
            ],
            'track_phone_number_links_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'track_phone_number_links_linkedin_conversion_id' => [
                'type' => 'string',
            ],
            'track_phone_number_links_bing' => [
                'type' => 'boolean',
            ],
            'track_phone_number_links_tiktok' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'track_phone_number_links_ga4' => true,
            'track_phone_number_links_meta' => true,
            'track_phone_number_links_google_ads' => true,
            'track_phone_number_links_google_ads_label' => '',
            'track_phone_number_links_pinterest' => true,
            'track_phone_number_links_linkedin' => true,
            'track_phone_number_links_linkedin_partner_id' => '',
            'track_phone_number_links_linkedin_conversion_id' => '',
            'track_phone_number_links_bing' => true,
            'track_phone_number_links_tiktok' => true,
        ];
    }
}
