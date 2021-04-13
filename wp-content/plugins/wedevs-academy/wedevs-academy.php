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

     public function define_constants(){
         define( 'WD_ACADEMY_VERSION', self::version );
         define( 'WD_ACADEMY_FILE', __FILE__ );
         define( 'WD_ACADEMY_PATH', __DIR__ );
         define( 'WD_ACADEMY_URL', plugins_url( '', WD_ACADEMY_FILEW) );
         define('WD_ACADEMY_ASSETS', WD_ACADEMY_URL . '/assets');
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