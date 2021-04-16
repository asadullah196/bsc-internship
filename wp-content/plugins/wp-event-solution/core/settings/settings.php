<?php

namespace Etn\Core\Settings;

defined( 'ABSPATH' ) || exit;

class Settings {

    use \Etn\Traits\Singleton;

    private $key_settings_option;

    public function init() {
        $this->key_settings_option = 'etn_event_options';

        add_action( 'admin_menu', [$this, 'add_setting_menu'] );
        add_action( 'admin_init', [$this, 'register_actions'], 999 );
    }

    public function get_settings_option( $key = null, $default = null ) {

        if ( $key != null ) {
            $this->key_settings_option = $key;
        }

        return get_option( $this->key_settings_option );
    }

    public function add_setting_menu() {
        add_submenu_page(
            'etn-events-manager',
            esc_html__( 'Settings', 'eventin' ),
            esc_html__( 'Settings', 'eventin' ),
            'manage_options',
            'etn-event-settings',
            [$this, 'etn_settings_page'],
            6
        );
    }

    public function etn_settings_page() {
        $settings_file = ETN_DIR . "/core/settings/views/etn-settings.php"; 
        if( file_exists( $settings_file ) ){
            include $settings_file;
        }
    }

    public function register_actions() {

        if ( isset( $_POST['etn_settings_page_action'] ) ) {
            if ( !check_admin_referer( 'etn-settings-page', 'etn-settings-page' ) ) {
                return;
            }

            $post_arr        = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );
            $data            = \Etn\Base\Action::instance()->store( -1, $post_arr );
            $check_transient = get_option( 'zoom_user_list' );

            if ( isset( $post_arr['zoom_api_key'] ) && isset( $post_arr['zoom_secret_key'] ) && $check_transient == false ) {
                // get host list
                \Etn\Core\Zoom_Meeting\Api_Handlers::instance()->zoom_meeting_user_list();
            }
            return $data;
        }
        return false;
    }

}