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

    public function create_tables() {
        global $wpdb;
    }
}