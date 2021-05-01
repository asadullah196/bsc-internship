<?php
defined( 'ABSPATH' ) || exit;

use \Etn_Pro\Utils\Helper;

if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_SPEAKER_TEMPLATE_THREE_ID == get_the_ID(  ) ) ){
    ?>
    <div class="etn-single-speaker-wrapper etn-speaker-details3">
        <div class="etn-speaker-details-info-wrap">
            <div class="etn-row">
                <div class="etn-col-lg-4">
                    <?php 
                    $speaker_avatar = apply_filters("etn/speakers/avatar", ETN_ASSETS . "images/avatar.jpg");
                    $speaker_thumbnail = has_post_thumbnail() ? get_the_post_thumbnail_url() : $speaker_avatar;
                    ?>
                    <div class="etn-speaker-thumb">
                        <img src="<?php echo esc_url( $speaker_thumbnail ); ?>" alt="<?php the_title_attribute(); ?>" />
                    </div>
                    <div class="speaker-title-info">
                        <h3 class="etn-title etn-speaker-name">
                            <?php echo esc_html( apply_filters('etn_speaker_title', get_the_title()) ); ?> 
                        </h3>
                        <?php
                            /**
                            * Speaker designation hook.
                            *
                            * @hooked speaker_three_designation - 10
                            */
                            do_action('etn_speaker_three_designation');
                        ?>
                    </div>
                    <div class="etn-speaker-info">
                        <?php
                            /**
                            * Speaker meta hook.
                            *
                            * @hooked speaker_three_meta - 11
                            */
                            do_action('etn_speaker_three_meta');
                            /**
                            * Speaker meta hook.
                            *
                            * @hooked speaker_three_social - 12
                            */
                            do_action('etn_speaker_three_social');
                        ?>
                    </div>
                </div>
                <div class="etn-col-lg-8">
                    <?php
                        /**
                        * Speaker summary hook.
                        *
                        * @hooked speaker_three_summary - 13
                        */
                        do_action('etn_speaker_three_summary');

                        /**
                        * Speaker summary hook.
                        *
                        * @hooked speaker_three_details_before - 15
                        */
                        do_action('etn_speaker_three_details_before');
                    ?>
                    <div class="schedule-list-1">
                        <?php
                        /**
                        * Speaker details header hook.
                        *
                        * @hooked schedule_three_header - 16
                        */
                        do_action('etn_schedule_three_header');

                        ?>
                        <div class="etn-row">
                            <?php
                            $speaker_id = get_the_id();
                            $orgs = Helper::speaker_sessions( $speaker_id );
                            if( is_array( $orgs ) && !empty( $orgs ) ):
                            foreach ($orgs as $org) {
                                $etn_schedule_meta_value = unserialize($org['meta_value']);
                                if( is_array( $etn_schedule_meta_value ) && !empty( $etn_schedule_meta_value )){

                                    foreach ($etn_schedule_meta_value as $single_meta) {

                                        $etn_schedule_speaker = !empty( $single_meta['etn_shedule_speaker'] ) ? $single_meta['etn_shedule_speaker'] : [];
                                        
                                        if( in_array( $speaker_id , $etn_schedule_speaker ) ) :
                                            ?>
                                            <div class="etn-col-lg-6">
                                                <div class="etn-schedule-wrap">
                                                    <div class="etn-single-schedule-item">
                                                        <?php
                                                            /**
                                                            * Speaker session time hook.
                                                            *
                                                            * @hooked schedule_three_session_time - 17
                                                            */
                                                            do_action('etn_schedule_three_session_time', $single_meta["etn_shedule_start_time"], $single_meta["etn_shedule_end_time"]);
                                                        ?>
                                                        <div class="etn-schedule-content">
                                                            <?php
                                                            /**
                                                            * Speaker session topic hook.
                                                            *
                                                            * @hooked schedule_three_session_topic - 18
                                                            */
                                                            do_action('etn_schedule_three_session_topic', $single_meta["etn_schedule_topic"]  );
        
                                                            /**
                                                            * Speaker session topic hook.
                                                            *
                                                            * @hooked schedule_three_session_location - 19
                                                            */
                                                            do_action('etn_schedule_three_session_location', $single_meta["etn_shedule_room"]  );
        
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        endif;
                                    }

                                }
                            }
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- schedule list -->
    </div>
    <?php 
} 
?>