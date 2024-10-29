<?php

namespace BeetleTracking\Schema\WebsiteEvents;

class UserLogin
{
    public static function schema() : array
    {
        return [
            'track_user_login_ga4' => [
                'type' => 'boolean',
            ],
            'track_user_login_meta' => [
                'type' => 'boolean',
            ],
            'track_user_login_google_ads' => [
                'type' => 'boolean',
            ],
            'track_user_login_google_ads_label' => [
                'type' => 'string',
            ],
            'track_user_login_pinterest' => [
                'type' => 'boolean',
            ],
            'track_user_login_linkedin' => [
                'type' => 'boolean',
            ],
            'track_user_login_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'track_user_login_linkedin_conversion_id' => [
                'type' => 'string',
            ],
            'track_user_login_bing' => [
                'type' => 'boolean',
            ],
            'track_user_login_tiktok' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'track_user_login_ga4' => true,
            'track_user_login_meta' => true,
            'track_user_login_google_ads' => true,
            'track_user_login_google_ads_label' => '',
            'track_user_login_pinterest' => true,
            'track_user_login_linkedin' => true,
            'track_user_login_linkedin_partner_id' => '',
            'track_user_login_linkedin_conversion_id' => '',
            'track_user_login_bing' => true,
            'track_user_login_tiktok' => true,
        ];
    }
}
