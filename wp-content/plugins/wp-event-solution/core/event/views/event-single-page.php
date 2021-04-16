<?php

$etn_show_event = true;
if( isset(  $_POST['ticket_purchase_next_step'] )  && ( $_POST['ticket_purchase_next_step'] !== "two" || $_POST['ticket_purchase_next_step'] !== "three" )){
	$etn_show_event = false;
}
?>

<?php
//check if it's called from form submission or from single page
if ( $etn_show_event === true ) {
	?>

	<?php get_header(); ?>

	<?php
	if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'single-event.php' ) ) {
		require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'single-event.php';
	} else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'single-event.php' ) ) {
		require_once  get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'single-event.php';
	} else if( file_exists( ETN_PLUGIN_TEMPLATE_DIR . 'single-event.php' ) ){
		include_once ETN_PLUGIN_TEMPLATE_DIR . 'single-event.php';
	}
	?>
	
	<?php get_footer(); ?>
	
	<?php
}
?>

