<?php

namespace weDevs\Academy;

/**
 * Installer class
 */
class Installer {
    /**
     * Run the installer
     * 
     * @return void
     */
    public function run() {
        $this -> add_version();
        $this -> create_tables();
    }

    public function add_version() {
        $installed = get_option( 'wd_academy_installed');

        if (! $installed ){
            update_option ( 'wd_academy_installed', time() );
        }

        update_option( 'wd_academy_version', WD_ACADEMY_VERSION );
    }

    /**
     * Create necessary database table
     * 
     * @return void
     */
    public function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        $schema = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}ac_addresses` (
            `id` int(20) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL,
            `address` varchar(255) NOT NULL,
            `phone` varchar(30) NOT NULL,
            `created_by` binary(20) NOT NULL,
            `created_at` datetime NOT NULL,
            PRIMARY KEY (`id`)
           ) $charset_collate";

           if ( ! function_exists( 'dbDelta' ) ) {
               require_once ABSPATH . 'wp-admin/includes/upgrade.php';
           }

           dbDelta( $schema );
    }
}