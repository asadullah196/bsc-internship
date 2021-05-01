<?php

namespace Etn_Pro\Core\Settings;

defined( "ABSPATH" ) || exit;

class Settings {

    use \Etn_Pro\Traits\Singleton;

    public $textdomain = 'eventin-pro';

    /**
     * Call all hooks
     */
    public function init() {
        // add filter to add more settings
        add_filter( 'eventin/settings/pro_settings', [$this, 'add_general_settings'] );
        add_filter( 'etn_event_templates', [$this, 'add_event_pro_template_options'] );
        add_filter( 'etn_speaker_templates', [$this, 'add_speaker_pro_template_options'] );
    }

    /**
     * Add pro settings to general-settings tab
     *
     * @return void
     */
    public function add_general_settings( $settings_arr ) {
        $settings_arr['remainder_email']     = ETN_PRO_DIR . "/core/settings/views/email-notification-settings.php";
        $settings_arr['pro_shortcode']       = ETN_PRO_DIR . "/core/settings/views/shortcode-settings.php";
        $settings_arr['pro_details_options'] = ETN_PRO_DIR . "/core/settings/views/details-settings.php";

        if ( (!is_multisite()) || (is_multisite() && is_main_network() && is_main_site() && defined( 'MULTISITE' )) ) {
            $settings_arr['pro_license_options'] = ETN_PRO_DIR . "/core/settings/views/purchase-settings.php";
        }

        $settings_arr['pro_attendee_options'] = ETN_PRO_DIR . "/core/settings/views/attendee-settings.php";
        return $settings_arr;
    }

        /**
     * Add more templates options for Event Single Page
     *
     * @param [type] $all_templates
     * @return void
     */
    public function add_event_pro_template_options( $all_templates ) {
        $all_templates['event-two']   = esc_html__( 'Template Two', 'eventin-pro' );
        $all_templates['event-three'] = esc_html__( 'Template Three', 'eventin-pro' );
        return $all_templates;
    }

    /**
     * Add more templates options for Speaker Single Page
     *
     * @param [type] $all_templates
     * @return void
     */
    public function add_speaker_pro_template_options( $all_templates ) {
        $all_templates['speaker-two']   = esc_html__( 'Template Two', 'eventin-pro' );
        $all_templates['speaker-three'] = esc_html__( 'Template Three', 'eventin-pro' );
        return $all_templates;
    }
}
