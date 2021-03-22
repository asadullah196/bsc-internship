<?php
defined( 'ABSPATH' ) || exit;

$event_options      = get_option( "etn_event_options" );
$event_time_format  = empty( $event_options["time_format"] ) ? '12' : $event_options["time_format"];
$start         = ( $event_time_format == '24' ) ? date_i18n( 'H:i', strtotime($start) ) : date_i18n( 'h:i a', strtotime($start) );
$end           = ( $event_time_format == '24' ) ? date_i18n( 'H:i', strtotime($end) ) : date_i18n( 'h:i a', strtotime($end) );

$dash_sign	= ( !empty( $start ) && !empty( $end ) ) ? "-" : "";
?>
<div class="etn-schedule-info">
    <span class="etn-schedule-time"><?php echo  esc_html( $start ) .  esc_html(  $dash_sign ) .  esc_html( $end ); ?></span>
</div>