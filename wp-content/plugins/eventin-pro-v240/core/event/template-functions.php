<?php

use Etn_Pro\Utils\Helper;


// Start - functions required for both event template-two and template-three

if ( !function_exists( 'etn_pro_after_single_event_content_faq' ) ) {

    /**
     * Show FAQ after single event content
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_pro_after_single_event_content_faq( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ( ETN_EVENT_TEMPLATE_TWO_ID == get_the_ID(  ) || ETN_EVENT_TEMPLATE_THREE_ID == get_the_ID(  ) )) ){
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
            // faq start
            $event_options = get_option( "etn_event_options" );
    
            if ( !isset( $event_options["hide_faq_from_details"] ) ) {
                $default_faq_view = "";
                $faq_view         = apply_filters( "etn_faq_view", $default_faq_view, $single_event_id );
    
                if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . $faq_view ) ) {
                    require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . $faq_view;
                } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . $faq_view ) ) {
                    require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . $faq_view;
                } else if ( file_exists( ETN_PRO_PLUGIN_TEMPLATE_DIR . $faq_view ) ) {
                    include_once ETN_PRO_PLUGIN_TEMPLATE_DIR . $faq_view;
                }
    
            }
    
            // faq end
        }
    }

}
if ( !function_exists( 'etn_pro_before_single_event_content_title_show_categories' ) ) {

    /**
     * Show category list before single event content
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_pro_before_single_event_content_title_show_categories( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ( ETN_EVENT_TEMPLATE_TWO_ID == get_the_ID(  ) || ETN_EVENT_TEMPLATE_THREE_ID == get_the_ID(  ) )) ){
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
    
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-category-list.php' ) ) {
                require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-category-list.php';
            } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-category-list.php' ) ) {
                require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-category-list.php';
            } else {
                require_once ETN_PRO_PLUGIN_TEMPLATE_DIR . 'event/event-two-category-list.php';
            }
        }

    }

}
if ( !function_exists( 'etn_pro_after_single_event_content_body_show_schedules' ) ) {

    /**
     * Show schedule tabs after single event content
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_pro_after_single_event_content_body_show_schedules( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ( ETN_EVENT_TEMPLATE_TWO_ID == get_the_ID(  ) || ETN_EVENT_TEMPLATE_THREE_ID == get_the_ID(  ) )) ){
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
    
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-schedule-tabs.php' ) ) {
                require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-schedule-tabs.php';
            } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-schedule-tabs.php' ) ) {
                require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-schedule-tabs.php';
            } else {
                require_once ETN_PRO_PLUGIN_TEMPLATE_DIR . 'event/event-pro-schedule-tabs.php';
            }
        }

    }

}
if ( !function_exists( 'etn_pro_after_single_event_meta_related_events' ) ) {

    /**
     * Show related events on single event page
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_pro_after_single_event_meta_related_events( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ( ETN_EVENT_TEMPLATE_TWO_ID == get_the_ID(  ) || ETN_EVENT_TEMPLATE_THREE_ID == get_the_ID(  ) )) ){
            $event_options = get_option( "etn_event_options" );
    
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
    
            // related post start
            if ( !isset( $event_options["hide_related_event_from_details"] ) ) {
    
                if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-related-events.php' ) ) {
                    require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-related-events.php';
                } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-related-events.php' ) ) {
                    require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-related-events.php';
                } else {
                    require_once ETN_PRO_PLUGIN_TEMPLATE_DIR . 'event/event-pro-related-events.php';
                }
    
            }
    
            // related events end
        }
    }

}
if ( !function_exists( 'etn_pro_single_event_meta_details' ) ) {

    /**
     * Show single event meta details
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_pro_single_event_meta_details( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ( ETN_EVENT_TEMPLATE_TWO_ID == get_the_ID(  ) || ETN_EVENT_TEMPLATE_THREE_ID == get_the_ID(  ) )) ){
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
            $event_options   = get_option( "etn_event_options" );
            $data            = Helper::single_template_options( $single_event_id );
    
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-meta-details.php' ) ) {
                require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-meta-details.php';
            } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-meta-details.php' ) ) {
                require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-meta-details.php';
            } else {
                require_once ETN_PRO_PLUGIN_TEMPLATE_DIR . 'event/event-pro-meta-details.php';
            }
        }

    }

}
if ( !function_exists( 'etn_pro_after_single_event_content_body_show_tags' ) ) {

    /**
     * Show tag list after single event content
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_pro_after_single_event_content_body_show_tags( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ( ETN_EVENT_TEMPLATE_TWO_ID == get_the_ID(  ) || ETN_EVENT_TEMPLATE_THREE_ID == get_the_ID(  ) )) ){
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
    
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-tag-list.php' ) ) {
                require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-tag-list.php';
            } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-tag-list.php' ) ) {
                require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-tag-list.php';
            } else {
                require_once ETN_PRO_PLUGIN_TEMPLATE_DIR . 'event/event-two-tag-list.php';
            }
        }

    }

}
// End - functions required for both event template-two and template-three


// Start - functions required for event template-two
if ( !function_exists( 'etn_pro_before_single_event_two_details_show_banner_module' ) ) {


    /**
     * Show banner module before single event content
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_pro_before_single_event_two_details_show_banner_module( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_TWO_ID == get_the_ID(  ) ) ){
    
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
    
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-banner-module.php' ) ) {
                require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-banner-module.php';
            } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-banner-module.php' ) ) {
                require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-banner-module.php';
            }  else {
                require_once ETN_PRO_PLUGIN_TEMPLATE_DIR . 'event/event-two-banner-module.php';
            }
        }

    }

}
if ( !function_exists( 'etn_pro_before_single_event_two_details_show_location_and_counter' ) ) {

    /**
     * Show location and counter before single event template two
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_pro_before_single_event_two_details_show_location_and_counter( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_TWO_ID == get_the_ID(  ) ) ){
    
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
            $event_options      = get_option( "etn_event_options" );
            $data               = Helper::single_template_options( $single_event_id );
            $event_start_date   = isset( $data['event_start_date'] ) ? $data['event_start_date'] : '';
            $event_end_date     = isset( $data['event_end_date'] ) ? $data['event_end_date'] : '';
            $event_start_time   = isset( $data['event_start_time'] ) ? $data['event_start_time'] : '';
            $etn_event_location = isset( $data['etn_event_location'] ) ? $data['etn_event_location'] : '';
            ?>
            <!-- counter area -->
            <div class="etn-event-header etn-event-single2">
                <div class="etn-container">
                    <div class="etn-row">
                        <div class="etn-col-lg-7 etn-align-self-center">
                            <?php

            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-location-details.php' ) ) {
                require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-location-details.php';
            } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-location-details.php' ) ) {
                require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-two-location-details.php';
            } else {
                require_once ETN_PRO_PLUGIN_TEMPLATE_DIR . 'event/event-two-location-details.php';
            }

            ?>
                        </div>
                        <div class="etn-col-lg-5">
                            <?php

            if ( !isset( $event_options["checked_hide_countdown_from_details"] ) ) {
                Helper::countdown_markup( get_post_meta( $single_event_id, 'etn_start_date', true ), $event_start_time );
            }

            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

}
if ( !function_exists( 'etn_pro_after_single_event_two_content_organizer' ) ) {

    /**
     * Show organizer after single event content
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_pro_after_single_event_two_content_organizer( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_TWO_ID == get_the_ID(  ) ) ){

            // etn-organizer start
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
            $event_options   = get_option( "etn_event_options" );
    
            if ( !isset( $event_options["etn_hide_organizers_from_details"] ) ) {
    
                $etn_organizer_events = get_post_meta( $single_event_id, 'etn_event_organizer', true );
                $etn_organizer_events = !empty( $etn_organizer_events ) ? $etn_organizer_events : '';
    
                if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-organizers.php' ) ) {
                    require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-organizers.php';
                } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-organizers.php' ) ) {
                    require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-organizers.php';
                } else {
                    echo Helper::single_template_organizer( $etn_organizer_events );
                }
    
            }
    
            // etn-organizer end
        }

    }

}
// End - functions required for event template-two


// Start - functions required for event template-three
if ( !function_exists( 'etn_pro_before_single_event_three_details_show_banner_module' ) ) {

    /**
     * Show banner module on single event template three
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_pro_before_single_event_three_details_show_banner_module( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_THREE_ID == get_the_ID(  ) ) ){
    
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
    
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-three-banner-module.php' ) ) {
                require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-three-banner-module.php';
            } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-three-banner-module.php' ) ) {
                require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-three-banner-module.php';
            } else {
                require_once ETN_PRO_PLUGIN_TEMPLATE_DIR . 'event/event-three-banner-module.php';
            }
        }

    }

}
if ( !function_exists( 'etn_pro_after_single_event_three_content_title_show_counter' ) ) {

    /**
     * Show counter after event title on single event template three
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_pro_after_single_event_three_content_title_show_counter( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_THREE_ID == get_the_ID(  ) ) ){
    
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
            $event_options   = get_option( "etn_event_options" );
    
            $data             = Helper::single_template_options( $single_event_id );
            $event_start_time = isset( $data['event_start_time'] ) ? $data['event_start_time'] : '';
    
            if ( !isset( $event_options["checked_hide_countdown_from_details"] ) ) {
                Helper::countdown_markup( get_post_meta( $single_event_id, 'etn_start_date', true ), $event_start_time );
            }
        }

    }

}
if ( !function_exists( 'etn_pro_after_single_event_three_content_title_show_meta' ) ) {

    /**
     * Show event location details after event title
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_pro_after_single_event_three_content_title_show_meta( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_THREE_ID == get_the_ID(  ) ) ){
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
    
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-three-location-details.php' ) ) {
                require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-three-location-details.php';
            } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-three-location-details.php' ) ) {
                require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-three-location-details.php';
            } else {
                require_once ETN_PRO_PLUGIN_TEMPLATE_DIR . 'event/event-three-location-details.php';
            }
        }

    }

}
if ( !function_exists( 'etn_pro_after_single_event_three_content_organizer' ) ) {

    /**
     * Show organizer after single event content
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_pro_after_single_event_three_content_organizer( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_THREE_ID == get_the_ID(  ) ) ){

            // etn-organizer start
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
            $event_options   = get_option( "etn_event_options" );
    
            if ( !isset( $event_options["etn_hide_organizers_from_details"] ) ) {
    
                $etn_organizer_events = get_post_meta( $single_event_id, 'etn_event_organizer', true );
                $etn_organizer_events = !empty( $etn_organizer_events ) ? $etn_organizer_events : '';
    
                if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-organizers.php' ) ) {
                    require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-organizers.php';
                } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-organizers.php' ) ) {
                    require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-pro-organizers.php';
                } else {
                    echo Helper::single_template_organizer( $etn_organizer_events );
                }
    
            }
    
            // etn-organizer end
        }

    }

}
// End - functions required for event template-three
