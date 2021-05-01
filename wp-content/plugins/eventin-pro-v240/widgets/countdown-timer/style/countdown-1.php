<?php
    if ( $show_event_title == "yes" ) {
        ?>
        <h2 class="event-title">
            <?php echo esc_html( get_the_title( $event_id ) ); ?>
        </h2>
        <?php
    }
    $view = ETN_PRO_PLUGIN_TEMPLATE_DIR . "/event/event-pro-countdown.php";
    if( file_exists( $view ) ){
        include $view;
    }
?>
