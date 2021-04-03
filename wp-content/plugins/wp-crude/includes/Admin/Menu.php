<?php

namespace ollzo\slider\Admin;

/**
 * The Mneu handler class
 */
class Menu {
    /**
     * Initialize the class
     */
    function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu(){
        add_menu_page(
            __( 'Hello Ollzo', 'hello_ollzo'),
            __( 'Hello Oll', 'hello_ollzo'),
            'manage_options',
            'hello-ollzo',
            [ $this, 'plugin_page'],
            'dashicons-admin-site-alt'
        );
    }

    public function plugin_page(){
        echo 'Hello Ollzo dhaka';
    }
}