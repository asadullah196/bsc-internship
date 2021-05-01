<?php
defined( 'ABSPATH' ) || exit;

if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_SPEAKER_TEMPLATE_TWO_ID == get_the_ID(  ) ) ){
    ?>
    <div class="etn-single-speaker-wrapper etn-speaker-details2">
        <div class="etn-speaker-details-info-wrap">
            <div class="etn-row">
                <?php 
                $speaker_avatar = apply_filters("etn/speakers/avatar", ETN_ASSETS . "images/avatar.jpg");
                $speaker_thumbnail = has_post_thumbnail() ? get_the_post_thumbnail_url() : $speaker_avatar;
                ?>
                <div class="etn-col-md-4">
                    <div class="etn-speaker-thumb">
                        <img src="<?php echo esc_url( $speaker_thumbnail ); ?>" alt="<?php the_title_attribute(); ?>" />
                    </div>
                </div>
                <div class="etn-col-md-8">
                    <div class="etn-speaker-info">
                        <div class="etn-speaker-entry-header">
                            <div class="etn-speaker-title-info">
                                <?php
                                    /**
                                    * Speaker comapny title hook.
                                    *
                                    * @hooked speaker_two_company - 10
                                    */
                                    do_action('etn_speaker_two_company');
                                ?>
                                <h3 class="etn-title etn-speaker-name"> 
                                    <?php echo esc_html( apply_filters('etn_speaker_title', get_the_title()) ); ?> 
                                </h3>
                                <?php
                                    /**
                                    * Speaker designation hook.
                                    *
                                    * @hooked speaker_two_designation - 11
                                    */
                                    do_action('etn_speaker_two_designation');

                                    /**
                                    * Speaker meta hook.
                                    *
                                    * @hooked speaker_two_meta - 12
                                    */
                                    do_action('etn_speaker_two_meta');
                                ?>
                            </div>
                            <?php

                                /**
                                * Speaker social hook.
                                *
                                * @hooked speaker_two_social - 13
                                */
                                do_action('etn_speaker_two_social');
                            ?>
                        </div>
                        <?php
                            /**
                            * Speaker sessions title hook.
                            *
                            * @hooked speaker_two_summary - 14
                            */
                            do_action('etn_speaker_two_summary');
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- schedule list -->
        <div class="schedule-list-1">
            <?php
                /**
                * Speaker sessions title hook.
                *
                * @hooked speaker_sessions_title - 15
                */
                do_action('etn_speaker_two_sessions_title');
            ?>
            <div class="etn-row">
                <?php
                $orgs = \Etn_Pro\Utils\Helper::speaker_sessions( get_the_id() );
                if (count( $orgs ) > 0) {
                    foreach ($orgs as $org) {

                        /**
                        * Speaker sessions before hook.
                        *
                        * @hooked etn_speaker_two_sessions_details_before - 16
                        */

                        do_action( 'etn_speaker_two_sessions_details_before' );

                        /**
                        * Speaker sessions details hook.
                        *
                        * @hooked speaker_sessions_details - 17
                        */

                        do_action('etn_speaker_two_sessions_details' , $org );

                        
                        /**
                        * Inside Speaker sessions details action.
                        * etn_schedule_two_header -18
                        * @hooked schedule_two_header
                        * etn_schedule_session_time - 19
                        * @hooked schedule_session_time 
                        * etn_schedule_session_title - 20
                        * @hooked schedule_session_title 
                        * etn_schedule_session_location - 21
                        * @hooked schedule_session_location 
                        */

                        /**
                        * Speaker sessions details after hook.
                        *
                        * etn_speaker_two_sessions_details_after  - 22
                        * @hooked speaker_sessions_details_after
                        */

                        do_action( 'etn_speaker_two_sessions_details_after' );  
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}
