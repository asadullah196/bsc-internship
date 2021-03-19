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
}



?>