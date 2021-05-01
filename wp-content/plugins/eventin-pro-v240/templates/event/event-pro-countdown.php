<?php

defined( 'ABSPATH' ) || exit;

?>

<div class="count_down_block">
    <div class="etn-event-countdown-wrap etn-countdown1 etn-countdown-parent" 
        data-start-date="<?php echo esc_attr( $counter_start_time ); ?>"
        data-date-texts='<?php echo json_encode( $date_texts );?>'>
        <div class="etn-count-item etn-days">
            <span class="day-count days"></span>
            <span class="text days_text">  <?php echo esc_html__( $countdown_day, "eventin-pro"); ?></span>
        </div>
        <?php if ( $show_seperate_dot ){ ?>
        <span class="date-seperate"> : </span>
        <?php } ?>
        <div class="etn-count-item etn-hours">
            <span class="hr-count hours"></span>
            <span class="text hours_text"><?php echo esc_html__( $countdown_hr, "eventin-pro" ); ?></span>
        </div>
        <?php if ( $show_seperate_dot ){ ?>
        <span class="date-seperate"> : </span>
        <?php } ?>
        <div class="etn-count-item etn-minutes">
            <span class="min-count minutes"></span>
            <span class="text minutes_text"> <?php echo esc_html__( $countdown_min, "eventin-pro" ); ?></span>
        </div>
        <?php if ( $show_seperate_dot ){ ?>
        <span class="date-seperate"> : </span>
        <?php } ?>
        <div class="etn-count-item etn-seconds">
            <span class="sec-count seconds"></span>
            <span class="text seconds_text"> <?php echo esc_html__( $countdown_sec, "eventin-pro" ); ?></span>
        </div>
    </div>
</div>