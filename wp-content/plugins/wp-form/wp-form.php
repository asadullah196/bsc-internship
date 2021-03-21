<?php

/*
Plugin Name: WP Form
Plugin URI: https://www.galibnotes.com/product/wordpress-form/
Description: WordPress form is a plugin that takes user registration data and store in mySQL data store. After that, you can read data from the view button.
Author: Asadullah Galib
Version: 1.0.0
Author URI: https://galibnotes.com
Requires at least: 4.5
Tested up to: 5.7
License: GPLv2 or later
Text Domain: wpform
*/

// Only "Plugin Name" is required and the rest options are optional.

// Define the PATH
define("PLUGIN_DIR_PATH",plugin_dir_path(__FILE__));
define("PLUGINS_URL",plugins_url(__FILE__));

if ( ! defined( 'ABSPATH' ) )
	exit;

// Register settings using the Settings API 
function add_custom_menu(){
    add_menu_page(
        'custom plugin',
        'Custom Plugin',
        'manage_options',
        'custom-plugin',
        'custom_plugin_func',
        'dashicons-share-alt',
        9
    );
}
add_action('admin_menu','add_custom_menu');

function custom_plugin_func(){
    include_once PLUGIN_DIR_PATH.'/view/form.php';
    echo "<h2>Hello Dhaka</h2>";
    //include_once PLUGIN_DIR_PATH.'/view/styles.css';
}

function custom_plugin_create_table(){
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $sql = "CREATE TABLE `wp_custom_table1` (
        `Id` int(11) NOT NULL AUTO_INCREMENT,
        `fnam` varchar(255) NOT NULL,
        `lnam` varchar(255) NOT NULL,
        PRIMARY KEY (`Id`)
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
       ";

    dbDelta( $sql );
}

register_activation_hook( __FILE__, 'custom_plugin_create_table' );
//register_deactivation_hook( __FILE__, 'custom_plugin_deactivation_table' );
register_uninstall_hook( __FILE__, 'custom_plugin_delete_table' );

/*
function custom_plugin_deactivation_table(){
    global $wpdb;
    $wpdb -> query("DROP table IF Exists wp_custom_table1");
}
*/

function custom_plugin_delete_table(){
    global $wpdb;
    $wpdb -> query("DROP table IF Exists wp_custom_table1");
}

/**
 * Proper way to enqueue styles
 */
function custom_plugin_assets() {
    wp_enqueue_style( 'style-name', '/wp-content/plugins/wp-form/view/styles.css','','1.0' );
    //wp_enqueue_script( 'script-name', get_template_directory_uri() . '/js/example.js', array(), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'custom_plugin_assets' );

?>