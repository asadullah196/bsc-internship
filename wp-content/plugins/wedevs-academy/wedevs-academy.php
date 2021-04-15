<?php

/**
 * weDevs Academy
 *
 * @package           PluginPackage
 * @author            Asadullah Galib
 * @copyright         2019 XpeedStudio
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       weDevs Academy
 * Plugin URI:        https://xpeedstudio.com/wedevs-academy
 * Description:       This is a basic WordPressplugin for development tutorial for development practice.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Asadullah Galib
 * Author URI:        https://galib.co
 * Text Domain:       weDevs Academy
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

 if ( ! defined('ABSPATH')){
     exit;
 }

 require_once __DIR__ . '/vendor/autoload.php';

 /**
  * The main plugin class
  */
 final class weDevs_Academy {

    /**
     * Plugin version
     * 
     * @var
     */
    const version = '1.0';
     /**
      * Class constructor
      */
     private function __construct(){
         $this -> define_constants();

         register_activation_hook( __FILE__, [$this,'activate'] );
         add_action( 'plugins_loaded', [$this,'init_plugin'] );
     }

     /**
      * Initializes a singleton instance
      *
      * @return \weDevs_Academy
      */
     public static function init(){
        static $instance = false;

        if( ! $instance ){
            $instance = new self();
        }

        return $instance;
     }

     /**
      * Define the required plugin constants
      *
      *@return void
      */
     public function define_constants(){
         define( 'WD_ACADEMY_VERSION', self::version );
         define( 'WD_ACADEMY_FILE', __FILE__ );
         define( 'WD_ACADEMY_PATH', __DIR__ );
         define( 'WD_ACADEMY_URL', plugins_url( '', WD_ACADEMY_FILE) );
         define('WD_ACADEMY_ASSETS', WD_ACADEMY_URL . '/assets');
     }

     /**
      * Initialize the plugin
      *
      * @return void
      */
     public function init_plugin(){
        new weDevs\Academy\Admin\Menu();
     }
     /**
      * Do stuff plugin activation 
      *
      * @return void
      */
     public function activate(){
        $installed = get_option( 'wd_academy_installed');

        if (! $installed ){
            update_option ( 'wd_academy_installed', time() );
        }

        update_option( 'wd_academy_version', WD_ACADEMY_VERSION );
     }
 }

 /**
  * Initializes the main plugin
  *
  * @return \weDevs_Academy
  */
 function wedevs_academy() {
    return weDevs_academy::init();
 }

 // kick-off the plugin
 wedevs_academy();