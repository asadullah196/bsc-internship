<?php

namespace ollzo\slider\Frontend;

/**
 * Shortcode handler class
 */
class Shortcode{

    /**
     * Initializes the class
     */
    function __construct(){
        add_shortcode('ollzo-slider',[$this, 'render_shortcode']);
    }
    /**
     * Shortcode handler class
     * 
     * @param array $atts
     * @param string $content 
     * 
     * @return string
     */
    public function render_shortcode ( $atts, $content = ''){
        return 'Hello from Ollzo';
    }
}
