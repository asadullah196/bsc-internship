<?php
defined( 'ABSPATH' ) || exit;

/**
 * Plugin Name:       WP Event Solution
 * Plugin URI:        https://themewinter.com/eventin/
 * Description:       Simple and Easy to use Event Management Solution
 * Version:           2.4.0
 * Author:            Themewinter
 * Author URI:        https://themewinter.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       eventin
 * Domain Path:       /languages
 */

require_once plugin_dir_path( __FILE__ ) . 'autoloader.php';
require_once plugin_dir_path( __FILE__ ) . 'bootstrap.php';

//block for showing banner
require_once plugin_dir_path( __FILE__ ) . '/utils/notice/notice.php';
require_once plugin_dir_path( __FILE__ ) . '/utils/banner/banner.php';
require_once plugin_dir_path( __FILE__ ) . '/utils/pro-awareness/pro-awareness.php';

// init notice class
\Oxaim\Libs\Notice::init();

// init pro menu class
\Wpmet\Libs\Pro_Awareness::init();


//define all constants
define( 'ETN_FILE', __FILE__ );
define( 'ETN_PATH', plugin_dir_url( ETN_FILE ) );
define( 'ETN_DIR', untrailingslashit( plugin_dir_path( ETN_FILE ) ) );
define( 'ETN_ASSETS', ETN_PATH . 'assets/' );
define( 'ETN_CORE', ETN_DIR . '/core/' );
define( 'ETN_WIDGETS', ETN_DIR . '/widgets/' );
define( 'ETN_UTILS', ETN_DIR . '/utils/' );
define( 'ETN_BASENAME', plugin_basename( ETN_FILE ) );
define( 'ETN_PLUGIN_TEMPLATE_DIR', ETN_DIR . '/templates/' );
define( 'ETN_THEME_TEMPLATE_DIR', '/eventin/templates/' );

// handle demo site features
define( 'ETN_DEMO_SITE', false );
if( ETN_DEMO_SITE === true ){
    define('ETN_EVENT_TEMPLATE_ONE_ID', '37');
    define('ETN_EVENT_TEMPLATE_TWO_ID', '13');
    define('ETN_EVENT_TEMPLATE_THREE_ID', '39');

    define('ETN_SPEAKER_TEMPLATE_ONE_ID', '29');
    define('ETN_SPEAKER_TEMPLATE_TWO_ID', '35');
    define('ETN_SPEAKER_TEMPLATE_THREE_ID', '33');
}


// load hook for post url flush rewrites
register_activation_hook( __FILE__, [Etn\Bootstrap::instance(), 'flush_rewrites'] );

// load plugin
add_action( 'plugins_loaded', function () {

    do_action( 'eventin/before_load' );

    // action plugin instance class
    Etn\Bootstrap::instance()->init();

    if ( file_exists( ETN_DIR . '/core/woocommerce/etn_woocommerce.php' ) ) {
        include_once ETN_DIR . '/core/woocommerce/etn_woocommerce.php';
    }

    do_action( 'eventin/after_load' );
    
}, 999 );
