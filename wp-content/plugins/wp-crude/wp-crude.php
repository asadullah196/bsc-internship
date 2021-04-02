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

 if (! define('ABSPATH')){
     exit; 
 }

 /**
  * The main plugin class
  */
  final class Hello_Ollzo{

    /**
     * Class constructor
     */
      private function __construct(){

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
  }

  /**
   * Initializes the main plugin
   * 
   * @return \Hello_Ollzo
   */
  function hello_ollzo(){
      return Hello_Ollzo::init();
  }