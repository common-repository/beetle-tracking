<?php

namespace BeetleTracking\Schema\WebsiteEvents;

class Comment
{
    public static function schema() : array
    {
        return [
            'track_comments_ga4' => [
                'type' => 'boolean',
            ],
            'track_comments_meta' => [
                'type' => 'boolean',
            ],
            'track_comments_google_ads' => [
                'type' => 'boolean',
            ],
            'track_comments_google_ads_label' => [
                'type' => 'string',
            ],
            'track_comments_pinterest' => [
                'type' => 'boolean',
            ],
            'track_comments_linkedin' => [
                'type' => 'boolean',
            ],
            'track_comments_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'track_comments_linkedin_conversion_id' => [
                'type' => 'string',
            ],
            'track_comments_bing' => [
                'type' => 'boolean',
            ],
            'track_comments_tiktok' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'track_comments_ga4' => true,
            'track_comments_meta' => true,
            'track_comments_google_ads' => true,
            'track_comments_google_ads_label' => '',
            'track_comments_pinterest' => true,
            'track_comments_linkedin' => true,
            'track_comments_linkedin_partner_id' => '',
            'track_comments_linkedin_conversion_id' => '',
            'track_comments_bing' => true,
            'track_comments_tiktok' => true,
        ];
    }
}
