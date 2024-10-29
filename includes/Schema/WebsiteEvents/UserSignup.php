<?php

namespace BeetleTracking\Schema\WebsiteEvents;

class UserSignup
{
    public static function schema() : array
    {
        return [
            'track_user_signup_ga4' => [
                'type' => 'boolean',
            ],
            'track_user_signup_meta' => [
                'type' => 'boolean',
            ],
            'track_user_signup_google_ads' => [
                'type' => 'boolean',
            ],
            'track_user_signup_google_ads_label' => [
                'type' => 'string',
            ],
            'track_user_signup_pinterest' => [
                'type' => 'boolean',
            ],
            'track_user_signup_linkedin' => [
                'type' => 'boolean',
            ],
            'track_user_signup_linkedin_partner_id' => [
                'type' => 'string',
            ],
            'track_user_signup_linkedin_conversion_id' => [
                'type' => 'string',
            ],
            'track_user_signup_bing' => [
                'type' => 'boolean',
            ],
            'track_user_signup_tiktok' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'track_user_signup_ga4' => true,
            'track_user_signup_meta' => true,
            'track_user_signup_google_ads' => true,
            'track_user_signup_google_ads_label' => '',
            'track_user_signup_pinterest' => true,
            'track_user_signup_linkedin' => true,
            'track_user_signup_linkedin_partner_id' => '',
            'track_user_signup_linkedin_conversion_id' => '',
            'track_user_signup_bing' => true,
            'track_user_signup_tiktok' => true,
        ];
    }
}
