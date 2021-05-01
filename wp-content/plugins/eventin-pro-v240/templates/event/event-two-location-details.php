<?php

defined( 'ABSPATH' ) || exit;

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