<?php

namespace BeetleTracking\Controller;

class NewsletterController
{
    public function __construct()
    {
        add_action('rest_api_init', [$this, 'register_endpoint']);
    }

    public function register_endpoint()
    {
        register_rest_route('beetle-tracking/v1', '/newsletter', array(
            'methods' => 'POST',
            'callback' => [$this, 'handle_newsletter_signup'],
            'permission_callback' => function () {
                return current_user_can(apply_filters('beetle_tracking_dashboard_page_capability', 'manage_options'));
            }
        ));
    }

    public function handle_newsletter_signup(\WP_REST_Request $request)
    {
        $parameters = $request->get_json_params();
        $email = sanitize_email($parameters['email']);

        if (empty($email) || !is_email($email)) {
            return new \WP_Error('invalid_email', 'Invalid or empty email provided.', array('status' => 400));
        }


        $result = wp_mail('support@rocketbeetle.com', 'New newsletter signup', $email);

        if ($result === true) {
            update_user_meta(get_current_user_id(), 'beetle_tracking_signed_up_newsletter', true);
            return new \WP_REST_Response(array('message' => 'Thank you for signing up!'), 200);
        } else {
            return new \WP_Error('signup_failed', 'Failed to sign up for the newsletter.', array('status' => 500));
        }
    }

}
