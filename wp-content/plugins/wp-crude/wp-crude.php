<?php

/**
 * Plugin Name:       Ollzo Hello
 * Plugin URI:        https://ollzo.com/plugins/ollzo-basics/
 * Description:       Handle the basics with this plugin. It's a slider for WP Site.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Asadullah Galib
 * Author URI:        https://galib.co/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ollzo-hello
 * Domain Path:       /languages
 */

 if ( ! defined('ABSPATH')){
     exit; 
 }

 require_once __DIR__ . '/vendor/autoload.php';

 /**
  * The main plugin class
  */
  final class Hello_Ollzo{

    /**
     * plugin version
     * 
     * @var string
     */
    //const $version = '1.0';
    const version = '1.0';
    /**
     * Class constructor
     */
      private function __construct(){
            $this -> define_constants();

            register_activation_hook( __FILE__, [$this,'activate']);
            add_action('plugins_loaded', [$this, 'init_plugin']);
      }

      /**
       * Initializes a singleton instance
       * 
       * @return \Hello_Ollzo
       */
      public static function init(){
          static $instance = false;

          if (! $instance){
              $instance = new self();
          }

          return $instance;
      }

      public function define_constants(){
          define('OLLZO_CRUDE_VERSION',self::version);
          define('OLLZO_CRUDE_FILE', __FILE__ );
          define('OLLZO_CRUDE_PATH', __DIR__ );
          define('OLLZO_CRUDE_URL', plugins_url('',OLLZO_CRUDE_FILE) );
          define('OLLZO_CRUDE_ASSETS', OLLZO_CRUDE_URL . '/asset' );
      }

      /**
       * Initialize the plugin
       * 
       * @return void
       */
      public function init_plugin(){
            new ollzo\slider\Admin\Menu();
      }

      public function activate(){
        $installed = get_option('ollzo_slider_installed');

        if(! $installed){
            updatee_option('ollzo_slider_installed',time());
        }

          updatee_option( 'ollzo_slider_version', OLLZO_CRUDE_VERSION );
      }
  }

  /**
   * Initializes the main plugin
   * 
   * @return \Hello_Ollzo
   */
  function hello_ollzo(){
      return Hello_Ollzo::init();
  }

  // Kick-off the plugin
  hello_ollzo();