<?php

use \Etn\Utils\Helper;

defined( 'ABSPATH' ) || exit;

$event_options  = get_option("etn_event_options");
$data           = Helper::single_template_options( $single_event_id );
?>
<div class="etn-event-meta-info etn-widget">
    <ul>
        <li>
            <span> <?php echo esc_html__('Date : ', "eventin"); ?></span>
            <?php echo esc_html($data['event_start_date'] . " - " . $data['event_end_date']); ?>
        </li>
        
        <?php
        if ( !isset($event_options["etn_hide_time_from_details"]) ) {
            ?>
            <li>
                <span><?php echo esc_html__('Time : ', "eventin"); ?></span>
                <?php echo esc_html($data['event_start_time'] . " - " . $data['event_end_time']); ?>
            </li>
            <?php
        }
        ?>
        <li>
            <span><?php echo esc_html__('Registration Deadline : ', "eventin"); ?></span>
            <?php echo esc_html($data['etn_deadline_value']); ?>
        </li>
        <?php
        if ( !isset($event_options["etn_hide_location_from_details"]) ) {
            ?>
            <li>
                <span><?php echo esc_html__('Venue : ', "eventin") ?></span>
                <?php echo esc_html($data['etn_event_location']);  ?>
            </li>
            <?php 
        } 
        ?>
    </ul>
    <?php
    ?>
</div> 