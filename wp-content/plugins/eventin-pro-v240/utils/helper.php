<?php
namespace Etn_Pro\Utils;

use Etn_Pro\Traits\Singleton;
use Etn\Core\Settings\Settings as SettingsFree;
defined( 'ABSPATH' ) || exit;

/**
 * Global helper class.
 *
 * @since 1.0.0
 */

class Helper extends \Etn\Utils\Helper {
     
    /**
     * Undocumented function
    *
    * @param [type] $content_id
    * @return void
    */
    public static function render_elementor_content($content_id){
        $elementor_instance = \Elementor\Plugin::instance();

        return $elementor_instance->frontend->get_builder_content_for_display( $content_id );
    }

    /**
     * Undocumented function
    *
    * @param [type] $content
    * @param [type] $id
    * @return void
    */
    public static function render_inner_content($content, $id){
        return str_replace('.elementor-'.$id.' ', '#elementor .elementor-'.$id.' ', $content);
    }

    /**
     * Generates url with query params
    *
    * @param [type] $url
    * @param [type] $params
    * @return void
    */
    public static function url_generate($url, $params){
        $params_url = http_build_query($params, '', '&'); 
        if (strpos($url, '?') === false) {
            return ($url .'?'. $params_url);
        } else {
            return ($url .'&'. $params_url);
        }
    }

    /**
     * Get expiry date from user function
    *
    */
    public static function get_expiry_date(){
        $settings =  SettingsFree::instance()->get_settings_option();

        return (isset($settings['expiry_point']) && "" != $settings['expiry_point']) ? $settings['expiry_point'] : "start";
    }

    /**
     * get texonomy function
    */
    public static function get_custom_texonomy( $taxonomy ){
        // show category
        $terms = get_terms([
            'taxonomy' 			=> $taxonomy ,
            'hide_empty' 		=> false,
        ]);

        return $terms; 
    }

    /**
     * Make Eventin free version ready before initiating Eventin Pro
     *
     * @return void
     */
    public static function make_eventin_ready(){
        
        $basename = 'wp-event-solution/eventin.php';
        $is_plugin_installed 	= self::get_installed_plugin_data( $basename );
        $plugin_data 			= self::get_plugin_data( 'wp-event-solution', $basename );

        if( $is_plugin_installed ) {
            // upgrade plugin - attempt for once
            if( isset( $plugin_data->version ) && $is_plugin_installed['Version'] != $plugin_data->version ) {
                self::upgrade_or_install_plugin( $basename );
            }

            // activate plugin
            if ( is_plugin_active( $basename ) ) {
                return true;
            } else {
                activate_plugin( self::safe_path( WP_PLUGIN_DIR . DIRECTORY_SEPARATOR . $basename ), '', false, true );
                return true;
            }
        } else {
            // install & activate plugin
            $download_link = isset( $plugin_data->download_link ) ? $plugin_data->download_link : "";
            if( self::upgrade_or_install_plugin( $download_link, false ) ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Download and Install Eventin Free version
     *
     * @param string $slug
     * @param string $basename
     * @return void
     */
    private static function get_plugin_data( $slug = '', $basename = '' ){
        if( empty( $slug ) ) {
            return false;
        }
        $installed_plugin = false;
        if( $basename ) {
            $installed_plugin = self::get_installed_plugin_data( $basename );
        }

        if( $installed_plugin ) {
            return $installed_plugin;
        }

        $args = array(
            'slug' => $slug,
            'fields' => array(
                'version' => false,
            ),
        );

        $response = wp_remote_post(
            'http://api.wordpress.org/plugins/info/1.0/',
            array(
                'body' => array(
                    'action' => 'plugin_information',
                    'request' => serialize((object) $args),
                ),
            )
        );

        if ( is_wp_error( $response ) ) {
            return false;
        } else {
            $response = unserialize( wp_remote_retrieve_body( $response ) );

            if( $response ) {
                return $response;
            } else {
                return false;
            }
        }
    }

    /**
     * Get installed plugin data
     *
     * @param string $basename
     * @return void
     */
    public static function get_installed_plugin_data( $basename = '' ) {
        if( empty( $basename ) ) {
            return false;
        }
        if( ! function_exists( 'get_plugins' ) ) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $plugins = get_plugins();
        return isset( $plugins[ $basename ] ) ? $plugins[ $basename ] : false;
    }

    /**
     * Install or Upgrade plugin
     *
     * @param string $basename
     * @param boolean $upgrade
     * @return void
     */
    private static function upgrade_or_install_plugin( $basename = '', $upgrade = true ){
        if( empty( $basename ) ) {
            return false;
        }
        include_once ABSPATH . 'wp-admin/includes/file.php';
        include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        include_once ABSPATH . 'wp-admin/includes/class-automatic-upgrader-skin.php';

        $skin = new \Automatic_Upgrader_Skin;
        $upgrader = new \Plugin_Upgrader( $skin );
        if( $upgrade == true ) {
            $upgrader->upgrade( $basename );
        } else {
            $upgrader->install( $basename );
            activate_plugin( $upgrader->plugin_info(), '', false, true );
        }
        return $skin->result;
    }

    /**
     * Countdown markup
    */
    public static function countdown_markup( $etn_start_date, $event_start_time ){

        $event_start_time   =  isset($event_start_time) && ( "" != $event_start_time ) ? date_i18n( "H:i:s", strtotime( $event_start_time ) ) : "00:00:00";
        $event_start_date   =  isset($etn_start_date) && ( "" != $etn_start_date ) ? date_i18n( "m/d/Y", strtotime( $etn_start_date ) ) : date_i18n( "m/d/Y", time() );
        $counter_start_time = $event_start_date . " " . $event_start_time;
        $countdown_day      = esc_html__("day", "eventin-pro");
        $countdown_hr       = esc_html__( "hr","eventin-pro");
        $countdown_min      = esc_html__( "min", "eventin-pro" );
        $countdown_sec      = esc_html__( "sec", "eventin-pro" );
        $event_options      = get_option("etn_event_options");
        $show_seperate_dot  = true;
        $date_texts = [
            'day'=> $countdown_day,
            'days'=> esc_html__( "days", "eventin-pro" ),
            'hr'=> $countdown_hr,
            'hrs'=> esc_html__("hrs", "eventin-pro"),
            'min'=> $countdown_min,
            'mins'=> esc_html__("mins", "eventin-pro"),
            'sec'=> $countdown_sec,
            'secs'=>esc_html__(  "secs", "eventin-pro" ),
        ];

        if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-countdown.php' ) ) {
            require get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-countdown.php' ;
        } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-countdown.php' ) ) {
            require get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-countdown.php' ;
        } else {
            require ETN_PRO_PLUGIN_TEMPLATE_DIR . 'event/event-pro-countdown.php';
        }
    }

    /**
     * Single page organizer block
    */
    public static function single_template_organizer( $etn_organizer_events ){

        if( file_exists( ETN_PRO_PLUGIN_TEMPLATE_DIR . 'event/event-pro-organizers.php' ) ) {

            require ETN_PRO_PLUGIN_TEMPLATE_DIR . 'event/event-pro-organizers.php';
        }
        
    }

    public static function attendee_list_widget( $event_id, $show_avatar, $show_email ){
        global $wpdb;
        $event_attendees    = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key='etn_event_id' AND meta_value='$event_id'" );
        $template           = ETN_PRO_DIR . "/core/shortcodes/views/event-attendees-view.php";
        $attendee_enabled   = self::get_option("attendee_registration");
        if( $attendee_enabled && file_exists( $template ) ){
            include $template;
        }
    }
    
}
