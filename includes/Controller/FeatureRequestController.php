<?php

namespace BeetleTracking\Controller;

class FeatureRequestController
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_endpoint']);
    }

    public function register_endpoint()
    {
        register_rest_route('beetle-tracking/v1', '/feature-request', array(
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
        $content = sanitize_text_field($parameters['content']);


        $email_content = "Feature request from " . wp_get_current_user()->user_email . ":\n\n" . $content;
        $result = wp_mail('support@rocketbeetle.com', 'Feature request', $email_content);

        if ($result === true) {
            return new \WP_REST_Response(array('message' => __('Thank you for your feature request!', 'beetle-tracking')), 200);
        } else {
            return new \WP_Error('feature_request_failed', __('Failed to send feature request, you could also send an email to support@rocketbeetle.com.', 'beetle-tracking'), array('status' => 500));
        }
    }

}
