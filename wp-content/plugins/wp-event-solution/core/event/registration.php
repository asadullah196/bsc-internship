<?php

namespace Etn\Core\Event;

use Etn\Utils\Helper;

defined( "ABSPATH" ) or die();

class Registration {

    use \Etn\Traits\Singleton;

    /**
     * Call all necessary hook
     */
    public function init() {
        add_action( 'init', [$this, 'registration_step_two'] );
    }

    /**
     * Store attendee report
     */
    public function registration_step_two() {

        if ( isset( $_POST['ticket_purchase_next_step'] ) && $_POST['ticket_purchase_next_step'] === "two" ) {
            $post_arr          = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );
            $check             = wp_verify_nonce( $post_arr['ticket_purchase_next_step_two'], 'ticket_purchase_next_step_two' );
            $settings          = Helper::get_settings();
            $include_phone     = !empty( $settings["reg_require_phone"] ) ? true : false;
            $include_email     = !empty( $settings["reg_require_email"] ) ? true : false;
            $reg_form_template = ETN_CORE . "attendee/views/registration/attendee-details-form.php";

            if ( file_exists( $reg_form_template ) ) {
                include_once $reg_form_template;
            }
        }

        return false;
    }

}
