<?php

namespace weDevs\Academy\Admin;

/**
 * The menu handler class
 */
class Menu{

    public $addressbook;

    /**
     * Initialize the class
     */
    function __construct( $addressbook ){
        $this->addressbook = $addressbook;
        add_action( 'admin_menu', [$this, 'admin_menu'] );
    }

    /**
     * Register admin menu
     * 
     * @return void
     */
    public function admin_menu(){
        $parent_slug = 'wedevs-academy';
        $capability = 'manage_options';

        add_menu_page( 
            __( 'weDevs Academy', 'wedevs-academy'),
            __( 'Academy', 'wedevs-academy'),
            $capability,
            $parent_slug,
            [ $this->addressbook, 'plugin_page'],
            'dashicons-admin-tools',
            '2'
        );

        /**
         * add_submenu_page( 
         * string $parent_slug, 
         * string $page_title, 
         * string $menu_title, 
         * string $capability, 
         * string $menu_slug, 
         * callable $function = '', 
         * int $position = null 
         * );
         */
        add_submenu_page (
            $parent_slug,
            __( 'Address Book', 'wedevs-academy'),
            __( 'Address Book', 'wedevs-academy'),
            $capability,
            $parent_slug,
            [ $this->addressbook, 'plugin_page']
        );
        add_submenu_page (
            $parent_slug,
            __( 'Address Book', 'wedevs-academy'),
            __( 'Settings', 'wedevs-academy'),
            $capability,
            'wedevs-academy-settings',
            [ $this, 'settings_page']
        );
    }

    public function settings_page(){
        echo 'Hello Settings Page';
    }
}