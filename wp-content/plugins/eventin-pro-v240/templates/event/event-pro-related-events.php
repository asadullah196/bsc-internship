<?php

defined( 'ABSPATH' ) || exit;

$etn_terms    = wp_get_post_terms( $single_event_id, 'etn_tags' );
$etn_term_ids = array();

if ($etn_terms) {
    foreach ($etn_terms as $terms) {
        array_push($etn_term_ids, $terms->term_id);
    }
}

$event_options  = get_option("etn_event_options");
$date_options   = \Etn_Pro\Utils\Helper::get_date_formats();
$data           = \Etn_Pro\Utils\Helper::post_data_query('etn', null, null, $etn_term_ids, "etn_tags", null, array( $single_event_id ) );


if (isset( $data ) && !empty( $data )) {
    ?>
    <div class="etn-widget etn-event-related-post etn-event-related-style-1">
        <h3 class="etn-widget-title etn-title">
        
            <?php 
                $related_events_title = apply_filters( 'etn_event_related_event_title', esc_html__('Related Events',  'eventin-pro' ) ); 
                echo \Etn\Utils\Helper::render( $related_events_title ); 
            ?>
            
        </h3>
        <div class="etn-related-event-wrap">
            <?php
            foreach ($data as $value) {
                $start_date  = strtotime( get_post_meta( $value->ID, 'etn_start_date', true ) );
                $start_date  = (isset($event_options["date_format"]) && $event_options["date_format"] !== '') ? date_i18n( $date_options[$event_options["date_format"]], $start_date ) : date_i18n('d/m/Y', $start_date);
                $related_event_location = get_post_meta( $value->ID, 'etn_event_location', true);
                ?>
                <div class="etn-event-item">
                    <div class="etn-event-date">
                        <?php echo esc_html($start_date); ?>
                    </div>
                    <div class="etn-event-content">
                        <h5 class="etn-title etn-event-title"><a href="<?php echo esc_url( get_the_permalink( $value->ID ) ); ?>"> <?php echo esc_html(get_the_title( $value->ID  )); ?></a> </h5>
                        <?php if (isset($related_event_location) && $related_event_location != '') { ?>
                            <div class="etn-event-location">
                                <?php echo esc_html($related_event_location); ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php
            }  ?>
        </div>
    </div>
    <?php 
} 
?>