<?php

use \Etn_Pro\Utils\Helper;

if ( !empty( $schedule_id ) ) {

    $schedule = get_post( $schedule_id );
    if ( !empty( $schedule ) && is_object( $schedule ) && "etn-schedule" === $schedule->post_type) {
        ?>
        <!-- schedule tab start -->
        <div class="schedule-list-wrapper schedule-list-1">
            <div class='etn-schedule-wrap'>
                <?php
                $event_options                                                      = get_option( "etn_event_options" );
                $event_options["time_format"] == '' ? $event_options["time_format"] = '12' : $event_options["time_format"];
                $etn_sched_time_format                                              = $event_options["time_format"] == '24' ? "H:i" : "h:i a";
                $schedule_meta                                                      = get_post_meta( $schedule->ID );
                $schedule_title                                                     = $schedule_meta['etn_schedule_title'][0];
                $schedule_date                                                      = strtotime( $schedule_meta['etn_schedule_date'][0] );
                $schedule_topics                                                    = unserialize( $schedule_meta['etn_schedule_topics'][0] );
                $schedule_date                                                      = date_i18n( "d M Y", $schedule_date );
                ?>
                <div class="schedule-header">
                    <span class="schedule-head-title"> <?php echo esc_html( $schedule_title ); ?></span>
                    <span class="schedule-head-date"><?php echo esc_html( $schedule_date ); ?></span>
                </div>
                <!-- start repeatable item -->
                <?php
                foreach ( $schedule_topics as $topic ){
                    $etn_schedule_topic      = ( isset( $topic['etn_schedule_topic'] ) ? $topic['etn_schedule_topic'] : '' );
                    $etn_schedule_start_time = date_i18n( $etn_sched_time_format, strtotime( $topic['etn_shedule_start_time'] ) );
                    $etn_schedule_end_time   = date_i18n( $etn_sched_time_format, strtotime( $topic['etn_shedule_end_time'] ) );
                    $etn_schedule_room       = ( isset( $topic['etn_shedule_room'] ) ? $topic['etn_shedule_room'] : '' );
                    $etn_schedule_objective  = ( isset( $topic['etn_shedule_objective'] ) ? $topic['etn_shedule_objective'] : '' );
                    $etn_schedule_speaker    = ( isset( $topic['etn_shedule_speaker'] ) ? $topic['etn_shedule_speaker'] : [] );
                    ?>
                    <div class='etn-single-schedule-item'>
                        <div class='etn-schedule-info'>
                            <?php
                            if ( $show_time_duration == 'yes' ) {
                                ?>
                                <span class='etn-schedule-time'><?php echo esc_html( $etn_schedule_start_time ) . " - " . esc_html( $etn_schedule_end_time ); ?></span>
                                <?php 
                                }
                            ?>
                        </div>
                        <div class='etn-schedule-content'>
                            <h4 class='etn-title'><?php echo esc_html( $etn_schedule_topic ); ?></h4>
                            <?php
                            if ( $show_location == 'yes' && !empty( $etn_schedule_room ) ) {
                                ?>
                                <span class='etn-schedule-location'>
                                    <i class='fas fa-map-marker-alt'></i>
                                    <?php echo esc_html( $etn_schedule_room ); ?>
                                </span>
                                <?php
                            }
                            if ( $show_desc == 'yes' ){
                                ?>
                                <p><?php echo Helper::render( $etn_schedule_objective ); ?></p>
                                <?php 
                            }
                            ?>
                        </div>
                        <?php
                        if ( $show_speaker == 'yes' ) { ?>
                            <div class='etn-schedule-speaker'>
                                <?php
                                $speaker_avatar = apply_filters( "etn/speakers/avatar", ETN_ASSETS . "images/avatar.jpg" );
                                if ( count( $etn_schedule_speaker ) > 0 && is_array( $etn_schedule_speaker ) ) {
                                    foreach ( $etn_schedule_speaker as $key => $value ) {
                                        $speaker_thumbnail           = !empty( get_the_post_thumbnail_url( $value ) ) ? get_the_post_thumbnail_url( $value ) : $speaker_avatar;
                                        $etn_schedule_single_speaker = get_post( $value );
                                        $speaker_designation         = get_post_meta( $etn_schedule_single_speaker->ID, 'etn_speaker_designation', true );
                                        $etn_speaker_permalink       = get_post_permalink( $value );
                                        $speaker_title               = $etn_schedule_single_speaker->post_title;
                                        ?>
                                        <a href='<?php echo esc_url( $etn_speaker_permalink ); ?>'>
                                            <div class='etn-schedule-single-speaker'>
                                                <img src='<?php echo esc_url( $speaker_thumbnail ); ?>' alt='<?php echo esc_attr( $speaker_title ); ?>'>
                                                <div class="speaker-info">
                                                    <strong class='etn-schedule-speaker-title'><?php echo esc_html( $speaker_title ); ?></strong>
                                                    <span class='etn-schedule-speaker-designation'><?php echo Helper::kses( $speaker_designation ); ?></span>
                                                </div>
                                            </div>
                                        </a>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <?php 
                        }
                        ?>
                    </div>
                    <?php 
                }
                ?>
                <!-- end repeatable item -->
            </div>
        </div>
        <?php 
    }

}
?>
<!-- schedule tab end -->