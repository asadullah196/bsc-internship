<?php
use Etn\Utils\Helper;

$etn_left_tickets     = !empty( $data['etn_left_tickets'] ) ? $data['etn_left_tickets'] : 0;
$etn_ticket_unlimited = ( isset( $data['etn_ticket_unlimited'] ) && $data['etn_ticket_unlimited'] == "no" ) ? true : false;
$etn_ticket_price     = isset( $data['etn_ticket_price'] ) ? $data['etn_ticket_price'] : '';
$ticket_qty           = get_post_meta( $single_event_id, "etn_sold_tickets", true );
$total_sold_ticket    = isset( $ticket_qty ) ? intval( $ticket_qty ) : 0;
$is_zoom_event        = get_post_meta( $single_event_id, 'etn_zoom_event', true );
$event_options        = !empty( $data['event_options'] ) ? $data['event_options'] : [];
$event_title          = get_the_title( $single_event_id );
?>

<div class="etn-widget etn-ticket-widget">
    <?php

if ( $etn_left_tickets > 0 ) {
    ?>
    <h4 class="etn-widget-title etn-title etn-form-title"> 
        <?php 
        $attendee_form_title = apply_filters( 'etn_event_purchase_form_title', esc_html__( "Registration Form", "eventin" ) );
        echo esc_html( $attendee_form_title ); ?> 
    </h4>
    <?php

    $settings            = Helper::get_settings();
    $attendee_reg_enable = !empty( $settings["attendee_registration"] ) ? true : false;

    if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/purchase-form/template/form-template.php' ) ) {
        $purchase_form_template = get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/purchase-form/template/form-template.php';
    } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/purchase-form/template/form-template.php' ) ) {
        $purchase_form_template = get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/purchase-form/template/form-template.php';
    } else {
        $purchase_form_template = ETN_PLUGIN_TEMPLATE_DIR . "event/purchase-form/template/form-template.php";
    }

    $form_template = apply_filters( "etn/purchase_form_template", $purchase_form_template );

    if ( file_exists( $form_template ) ) {
        include $form_template;
    }

} else {
    ?>
    <h6><?php echo esc_html__( 'No Tickets Available!!', "eventin" ); ?></h6>
    <?php
}

// show if this is a zoom event
if ( isset( $is_zoom_event ) && "on" == $is_zoom_event ) {
    ?>
    <div class="etn-zoom-event-notice">
        <?php echo esc_html__( "[Note: This event will be held on zoom. Attendee will get zoom meeting URL through email]", "eventin" ); ?>
    </div>
    <?php
}

?>
</div>