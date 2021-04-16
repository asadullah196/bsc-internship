

<?php
if (!defined('ABSPATH')) exit;
?>

<?php get_header(); ?>

<?php
//check if single page template is overriden from theme
//if overriden, then the overriden template has higher priority
if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'archive-event.php' ) ) {
    require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'archive-event.php';
} else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'archive-event.php' ) ) {
    require_once  get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'archive-event.php';
} else if( file_exists( ETN_PLUGIN_TEMPLATE_DIR . 'archive-event.php' ) ){
    include_once ETN_PLUGIN_TEMPLATE_DIR . 'archive-event.php';
}
?>

<?php get_footer(); ?>