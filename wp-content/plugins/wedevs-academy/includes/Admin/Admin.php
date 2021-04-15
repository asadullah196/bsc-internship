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
        add_menu_page( 
            __( 'weDevs Academy', 'wedevs-academy'),
            __( 'Academy', 'wedevs-academy'),
            'manage_options',
            'wedevs-academy',
            [ $this, 'plugin_page'],
            'dashicons-admin-tools'
     );
    }
    public function plugin_page(){
        echo 'Hello Galib';
    }
}