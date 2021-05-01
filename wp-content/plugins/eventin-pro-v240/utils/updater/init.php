<?php
namespace Etn_Pro\Utils\Updater;
use Etn_Pro\Utils\Helper;

defined( 'ABSPATH' ) || exit;

class Init {

    use \Etn_Pro\Traits\Singleton;

    public function init() {
        $license_key = explode( '-', trim( get_option( "etn_license_key" ) ) );
        $license_key = !isset( $license_key[0] ) ? '' : $license_key[0];

        $plugin_dir_and_filename = ETN_PRO_DIR . 'eventin-pro.php';

        $active_plugins = get_option( 'active_plugins' );

        foreach ( $active_plugins as $active_plugin ) {

            if ( false !== strpos( $active_plugin, 'eventin-pro.php' ) ) {
                $plugin_dir_and_filename = $active_plugin;
                break;
            }

        }

        if ( !isset( $plugin_dir_and_filename ) || empty( $plugin_dir_and_filename ) ) {
            throw ( 'Plugin not found! Check the name of your plugin file in the if check above' );
        }

        new Edd_Warper(
            \Etn_Pro\Bootstrap::instance()->store_url(),
            $plugin_dir_and_filename,
            [
                'version' => \Etn_Pro\Bootstrap::instance()->version(),
                'license' => $license_key,
                'item_id' => \Etn_Pro\Bootstrap::instance()->product_id(),
                'author'  => \Etn_Pro\Bootstrap::instance()->author_name(),
                'url'     => home_url(),
            ]
        );
    }

}
