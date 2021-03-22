<?php get_header();

//check if single page template is overriden from theme
//if overriden, then the overriden template has higher priority
if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'single-speaker.php' ) ) {
    require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'single-speaker.php';
} elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'single-speaker.php' ) ) {
    require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'single-speaker.php';
} else if ( file_exists( ETN_PLUGIN_TEMPLATE_DIR . 'single-speaker.php' ) ) {
    require_once ETN_PLUGIN_TEMPLATE_DIR . 'single-speaker.php';
}

get_footer();
