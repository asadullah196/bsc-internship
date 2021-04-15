<?php

namespace weDevs\Academy\Admin;

/**
 * The menu handler class
 */
class Menu{
    function __construct(){
        add_action( 'admin_menu', [$this, 'admin_menu'] );
    }

    public function admin_menu(){
        $parent_slug = 'wedevs-academy';
        $capability = 'manage_options';

        add_menu_page( 
            __( 'weDevs Academy', 'wedevs-academy'),
            __( 'Academy', 'wedevs-academy'),
            $capability,
            $parent_slug,
            [ $this, 'plugin_page'],
            'dashicons-admin-tools'
        );
        add_submenu_page (
            $parent_slug,
            __( 'Address Book', 'wedevs-academy'),
            __( 'Address Book', 'wedevs-academy'),
            $capability,
            
        );
    }
    public function plugin_page(){
        echo 'Hello Galib';
    }
}