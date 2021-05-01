<?php

namespace Etn_Pro\Utils;

class Plugin_Installer {
    
    use \Etn_Pro\Traits\Singleton;
        
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

    private static function get_installed_plugin_data( $basename = '' ) {
        if( empty( $basename ) ) {
            return false;
        }
        if( ! function_exists( 'get_plugins' ) ) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $plugins = get_plugins();
        return isset( $plugins[ $basename ] ) ? $plugins[ $basename ] : false;
    }

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
    
    public static function safe_path( $path ) {
        $path = str_replace( ['//', '\\\\'], ['/', '\\'], $path );
        return str_replace( ['/', '\\'], DIRECTORY_SEPARATOR, $path );
    }
}
?>