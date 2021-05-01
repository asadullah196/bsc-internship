<?php

defined( 'ABSPATH' ) || exit;

/**
 * Plugin Name:       Eventin Pro
 * Plugin URI:        https://product.themewinter.com/eventin-pro
 * Description:       Simple and Easy to use Event Management Solution
 * Version:           2.4.0
 * Author:            Themewinter
 * Author URI:        https://themewinter.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       eventin-pro
 * Domain Path:       /languages
 */

require plugin_dir_path( __FILE__ ) . '/autoloader.php';
require plugin_dir_path( __FILE__ ) . '/bootstrap.php';

// define plugin constants
Etn_Pro\Bootstrap::instance()->define_constants();

add_action( 'plugins_loaded', function () {

    do_action( 'eventin-pro/before_load' );

    Etn_Pro\Bootstrap::instance()->init();

    do_action( 'eventin-pro/after_load' );

}, 9999 );