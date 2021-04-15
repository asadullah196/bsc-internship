<?php

namespace weDevs\Academy\Frontend;

/**
 * Shortcode handler class
 */
class Shortcode {
    
    /**
     * Initializes the class
     */
    function __construct() {
        add_shortcode ( 'wedevs-academy', [$this, 'render_shortcode']);
    }

    /**
     * Shortcode handle class
     * 
     * @return array $atts
     * @return string $content
     * 
     * @return string
     */
    public function render_shortcode( $atts, $content = '') {
        return 'Hello Galib, I am your shortcode';
    }
}