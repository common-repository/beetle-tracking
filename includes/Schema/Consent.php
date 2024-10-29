<?php

namespace BeetleTracking\Schema;

class Consent
{
    public static function schema() : array
    {
        return [
            'consent_activated' => [
                'type' => 'boolean',
            ],
            'consent_title' => [
                'type' => 'string',
            ],
            'consent_text' => [
                'type' => 'string',
            ],
            'consent_dialog_text_color' => [
                'type' => 'string',
            ],
            'consent_dialog_bg_color' => [
                'type' => 'string',
            ],
            'consent_dialog_contrast_color' => [
                'type' => 'string',
            ],
            'consent_dialog_active_color' => [
                'type' => 'string',
            ],
            'consent_accept_all_activated' => [
                'type' => 'boolean',
            ],
            'consent_accept_all_text' => [
                'type' => 'string',
            ],
            'consent_accept_all_text_color' => [
                'type' => 'string',
            ],
            'consent_accept_all_text_bg_color' => [
                'type' => 'string',
            ],
            'consent_accept_all_text_border_color' => [
                'type' => 'string',
            ],
            'consent_accept_selected_activated' => [
                'type' => 'boolean',
            ],
            'consent_accept_selected_text' => [
                'type' => 'string',
            ],
            'consent_accept_selected_text_color' => [
                'type' => 'string',
            ],
            'consent_accept_selected_bg_color' => [
                'type' => 'string'
            ],
            'consent_accept_selected_border_color' => [
                'type' => 'string'
            ],
            'consent_decline_all_activated' => [
                'type' => 'boolean',
            ],
            'consent_decline_all_text' => [
                'type' => 'string',
            ],
            'consent_decline_all_text_color' => [
                'type' => 'string',
            ],
            'consent_decline_all_text_bg_color' => [
                'type' => 'string',
            ],
            'consent_decline_all_text_border_color' => [
                'type' => 'string',
            ],
            'consent_logo' => [
                'type' => 'object',
                'properties' => [
                    'id' => [
                        'type' => 'integer',
                    ],
                    'src' => [
                        'type' => 'string',
                    ],
                    'alt' => [
                        'type' => 'string',
                    ],
                    'name' => [
                        'type' => 'string',
                    ],
                ],
            ],
            'consent_purpose_necessary_title' => [
                'type' => 'string',
            ],
            'consent_purpose_necessary_text' => [
                'type' => 'string',
            ],
            'consent_purpose_preferences_title' => [
                'type' => 'string',
            ],
            'consent_purpose_preferences_text' => [
                'type' => 'string',
            ],
            'consent_purpose_statistics_title' => [
                'type' => 'string',
            ],
            'consent_purpose_statistics_text' => [
                'type' => 'string',
            ],
            'consent_purpose_marketing_title' => [
                'type' => 'string',
            ],
            'consent_purpose_marketing_text' => [
                'type' => 'string',
            ],
            'consent_purpose_ga4' => [
                'type' => 'string',
            ],
            'consent_purpose_google_ads' => [
                'type' => 'string',
            ],
            'consent_purpose_meta' => [
                'type' => 'string',
            ],
            'consent_purpose_pinterest' => [
                'type' => 'string',
            ],
            'consent_purpose_linkedin' => [
                'type' => 'string',
            ],
            'consent_purpose_bing' => [
                'type' => 'string',
            ],
            'consent_purpose_tiktok' => [
                'type' => 'string',
            ],
            'google_consent_v2_activated' => [
                'type' => 'boolean',
            ],
        ];
    }

    public static function defaults() : array
    {
        return [
            'consent_activated' => true,
            'consent_title' => __('This website uses cookies', 'beetle-tracking'),
            'consent_text' => 'We use cookies to personalise content and ads, to provide social media features and to analyse our traffic. We also share information about your use of our site with our social media, advertising and analytics partners who may combine it with other information that you’ve provided to them or that they’ve collected from your use of their services.',
            'consent_dialog_text_color' => '#333333',
            'consent_dialog_bg_color' => '#ffffff',
            'consent_dialog_contrast_color' => '#F7F7F7',
            'consent_dialog_active_color' => '#EE9B00',
            'consent_accept_all_activated' => true,
            'consent_accept_all_text' => __('Accept all', 'beetle-tracking'),
            'consent_accept_all_text_color' => '#ffffff',
            'consent_accept_all_text_bg_color' => '#EE9B00',
            'consent_accept_all_text_border_color' => '#EE9B00',
            'consent_accept_selected_activated' => true,
            'consent_accept_selected_text' => __('Accept selected', 'beetle-tracking'),
            'consent_accept_selected_text_color' => '#EE9B00',
            'consent_accept_selected_bg_color' => '#ffffff',
            'consent_accept_selected_border_color' => '#EE9B00',
            'consent_decline_all_text' => __('Decline all', 'beetle-tracking'),
            'consent_decline_all_text_color' => '#333333',
            'consent_decline_all_text_bg_color' => '#ffffff',
            'consent_decline_all_text_border_color' => '#333333',
            'consent_decline_all_activated' => false,
            'consent_purpose_necessary_title' => __('Necessary', 'beetle-tracking'),
            'consent_purpose_necessary_text' => __('Necessary cookies help make a website usable by enabling basic functions like page navigation and access to secure areas of the website. The website cannot function properly without these cookies.', 'beetle-tracking'),
            'consent_purpose_preferences_title' => __('Preferences', 'beetle-tracking'),
            'consent_purpose_preferences_text' => __('Preference cookies enable a website to remember information that changes the way the website behaves or looks, like your preferred language or the region that you are in.', 'beetle-tracking'),
            'consent_purpose_statistics_title' => __('Statistics', 'beetle-tracking'),
            'consent_purpose_statistics_text' => __('Statistic cookies help website owners to understand how visitors interact with websites by collecting and reporting information anonymously.', 'beetle-tracking'),
            'consent_purpose_marketing_title' => __('Marketing', 'beetle-tracking'),
            'consent_purpose_marketing_text' => __('Marketing cookies are used to track visitors across websites. The intention is to display ads that are relevant and engaging for the individual user and thereby more valuable for publishers and third party advertisers.', 'beetle-tracking'),
            'consent_purpose_ga4' => 'bt_statistics',
            'consent_purpose_google_ads' => 'bt_marketing',
            'consent_purpose_meta' => 'bt_marketing',
            'consent_purpose_pinterest' => 'bt_marketing',
            'consent_purpose_linkedin' => 'bt_marketing',
            'consent_purpose_bing' => 'bt_marketing',
            'consent_purpose_tiktok' => 'bt_marketing',
            'google_consent_v2_activated' => true,
        ];
    }
}
