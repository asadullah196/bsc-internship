<?php

defined( 'ABSPATH' ) || exit;

use Etn_Pro\Utils\Helper;

$event_options          = get_option("etn_event_options");
$data                   = Helper::single_template_options( $single_event_id );
$event_start_date       = isset( $data['event_start_date']) ? $data['event_start_date'] : '';
$event_end_date         = isset( $data['event_end_date']) ? $data['event_end_date'] : '';
$event_start_time       = isset( $data['event_start_time']) ? $data['event_start_time'] : '';
$event_end_time         = isset( $data['event_end_time']) ? $data['event_end_time'] : '';
$etn_deadline_value     = isset( $data['etn_deadline_value']) ? $data['etn_deadline_value'] : '';
$etn_event_location     = isset( $data['etn_event_location']) ? $data['etn_event_location'] : '';
?>
<ul class="list-unstyled etn-event-date-meta">
    <?php if (!isset($event_options["etn_hide_time_from_details"])) { ?>
        <li>
            <i class="far fa-calendar-alt"></i> <?php echo esc_html($event_start_date . " - " . $event_end_date); ?>
        </li>
    <?php } ?>
    <li>
        <?php
        if (!isset($event_options["etn_hide_location_from_details"])) { ?>
            <i class="fas fa-map-marker-alt"></i>
        <?php
            echo esc_html($etn_event_location);
        }
        ?>
    </li>
</ul>