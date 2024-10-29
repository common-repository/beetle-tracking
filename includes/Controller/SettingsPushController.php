<?php

namespace BeetleTracking\Controller;

use BeetleTracking\Utils\Settings;

class SettingsPushController
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_endpoint']);
    }

    public function register_endpoint()
    {
        register_rest_route('beetle-tracking/v1', '/push-to-cloudflare', array(
            'methods' => 'POST',
            'callback' => [$this, 'handle_request'],
            'permission_callback' => function () {
                return current_user_can(apply_filters('beetle_tracking_dashboard_page_capability', 'manage_options'));
            }
        ));
    }

    public function handle_request(\WP_REST_Request $request)
    {
        $parameters = $request->get_json_params();

        $zone_id = Settings::get('cloudflare_zone_id');
        $api_key = Settings::get('cloudflare_api_key');

        if (empty($zone_id) || empty($api_key)) {
            return new \WP_Error('missing_settings', 'Cloudflare settings are missing.', array('status' => 400));
        }

        $url = 'https://api.cloudflare.com/client/v4/zones/' . $zone_id . '/settings/zaraz/config';
        $response = wp_remote_get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ]
        ]);
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);
        $original_config = $data['result'];

        $config = $data['result'];
        $config = $this->removeAllCurrentBtFields($config);
        $config['settings']['ecommerce'] = $parameters['settings']['ecommerce'];
        $config['settings']['googleConsentV2Default'] = $parameters['settings']['googleConsentV2Default'];
        $config['settings']['eventsApiPath'] = $parameters['settings']['eventsApiPath'];
        $config['settings']['trackPageviews'] = $parameters['settings']['trackPageviews'];
        $config['tools'] = array_merge($config['tools'], $parameters['tools']);
        $config['triggers'] = array_merge($config['triggers'], $parameters['triggers']);
        $config['variables'] = array_merge($config['variables'], $parameters['variables']);

        if (isset($config['consent'])) {
            if (isset($config['consent']['buttonTextTranslations'])) {
                foreach ($config['consent']['buttonTextTranslations'] as $key => $value) {
                    if (empty($value)) {
                        unset($config['consent']['buttonTextTranslations'][$key]);
                    }
                }
            }

            foreach ($config['consent'] as $key => $value) {
                if (empty($value)) {
                    unset($config['consent'][$key]);
                }
            }
            $config['consent'] = array_merge($config['consent'], $parameters['consent']);
        } else {
            $config['consent'] = $parameters['consent'];
        }

        if (isset($config['tools'])) {
            foreach ($config['tools'] as $key => $tool) {
                if (isset($tool['defaultFields']) && empty($tool['defaultFields'])) {
                    $config['tools'][$key]['defaultFields'] = (object)[];
                }

                if (isset($tool['settings']) && empty($tool['settings'])) {
                    $config['tools'][$key]['settings'] = (object)[];
                }

                if ((isset($tool['actions']) && empty($tool['actions']))) {
                    unset($config['tools'][$key]['actions']);
                }

                // if(!isset($tool['neoEvents'])) {
                //     $config['tools'][$key]['neoEvents'] = [];
                // }
            }
        }

        $response = wp_remote_request(
            $url,
            [
                'method' => 'PUT',
                'headers' => [
                    'Authorization' => 'Bearer ' . $api_key,
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($config),
            ]
        );
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        $message = __('Successfully pushed to Cloudflare.', 'beetle-tracking');
        if ($data['errors']) {
            $message = __('Failed to push to Cloudflare.', 'beetle-tracking');
        }

        return new \WP_REST_Response([
            'message' => $message,
            'config' => $config,
            'response' => $data,
            'original_config' => $original_config,
        ], 200);
    }

    public function removeAllCurrentBtFields($config)
    {
        foreach ($config['tools'] as $key => $tool) {
            if (preg_match('/^bt-/', $key)) {
                unset($config['tools'][$key]);
            }
        }

        foreach ($config['tools'] as $key => $tool) {
            if (preg_match('/^bt-/', $key)) {
                unset($config['tools'][$key]);
            }
        }

        foreach ($config['variables'] as $key => $tool) {
            if (preg_match('/^bt-/', $key)) {
                unset($config['variables'][$key]);
            }
        }

        return $config;
    }
}
