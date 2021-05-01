<?php

use \Etn\Utils\Helper;

defined( 'ABSPATH' ) || exit;

$event_options  = get_option("etn_event_options");
$data           = Helper::single_template_options( $single_event_id );
?>
<div class="etn-event-meta-info etn-widget">
    <ul>
        <?php if(!isset($event_options["etn_hide_date_from_details"])){
                $separate = (!empty($data['event_end_date'])) ? '-' : '';
            ?>
            <li>
                <span> <?php echo esc_html__('Date : ', "eventin"); ?></span>
                <?php echo esc_html($data['event_start_date'] . $separate . $data['event_end_date']); ?>
            </li>
        <?php } ?>
        <?php
        if ( !isset($event_options["etn_hide_time_from_details"]) ) {
            $separate = (!empty($data['event_end_time'])) ? '-' : '';

            ?>
            <li>
                <span><?php echo esc_html__('Time : ', "eventin"); ?></span>
                <?php echo esc_html($data['event_start_time'] . $separate . $data['event_end_time']); ?>
            </li>
            <?php
        }
        ?>
        <?php if(!empty($data['etn_deadline_value'])){ ?>
        <li>
            <span><?php echo esc_html__('Registration Deadline : ', "eventin"); ?></span>
            <?php echo esc_html($data['etn_deadline_value']); ?>
        </li>
        <?php } ?>
        <?php
        if ( !isset($event_options["etn_hide_location_from_details"]) && !empty($data['etn_event_location'])) {
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