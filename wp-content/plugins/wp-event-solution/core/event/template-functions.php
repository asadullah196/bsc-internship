<?php

use \Etn\Utils\Helper;

defined( 'ABSPATH' ) || exit;


if ( !function_exists( 'etn_before_single_event_content_title_show_meta' ) ) {

    /**
     * Show data before event title section
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_before_single_event_content_title_show_meta( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_EVENT_TEMPLATE_THREE_ID != get_the_ID(  )) ){
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
    
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/category-list.php' ) ) {
                include_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/category-list.php';
            } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/category-list.php' ) ) {
                include_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/category-list.php';
            }else {
                include_once ETN_PLUGIN_TEMPLATE_DIR . 'event/category-list.php';
            }
        }

    }

}

if ( !function_exists( 'etn_after_single_event_content_body_show_meta' ) ) {

    /**
     * Show data after event content section
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_after_single_event_content_body_show_meta( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_EVENT_TEMPLATE_THREE_ID != get_the_ID(  )) ){
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
    
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/tag-list.php' ) ) {
                include_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/tag-list.php';
            } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/tag-list.php' ) ) {
                include_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/tag-list.php';
            } else {
                include_once ETN_PLUGIN_TEMPLATE_DIR . 'event/tag-list.php';
            }
        }

    }

}

if ( !function_exists( 'etn_single_event_meta_details' ) ) {
    /**
     * Show data inside event meta section
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_single_event_meta_details( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_EVENT_TEMPLATE_THREE_ID != get_the_ID(  )) ){
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
    
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-sidebar-meta-free.php' ) ) {
                include_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-sidebar-meta-free.php';
            } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-sidebar-meta-free.php' ) ) {
                include_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/event-sidebar-meta-free.php';
            } else {
                include_once ETN_PLUGIN_TEMPLATE_DIR . 'event/event-sidebar-meta-free.php';
            }
        }

    }

}

if ( !function_exists( 'etn_after_single_event_container_related_events' ) ) {

    /**
     * Show data after event container section
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_after_single_event_container_related_events( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_EVENT_TEMPLATE_THREE_ID != get_the_ID(  )) ){
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
            $event_options   = get_option( "etn_event_options" );
    
            if ( !isset( $event_options["hide_related_event_from_details"] ) ) {
    
                // related events start
                Helper::related_events_widget( $single_event_id );
                // related events end
            }
        }

    }

}

if ( !function_exists( 'etn_after_single_event_content_schedule' ) ) {

    /**
     * Show data after event content section
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_after_single_event_content_schedule( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_EVENT_TEMPLATE_THREE_ID != get_the_ID(  )) ){
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
            $event_options   = get_option( "etn_event_options" );
    
            if ( !isset( $event_options["etn_hide_schedule_from_details"] ) ) {
    
                if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/schedule-list.php' ) ) {
                    include_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/schedule-list.php';
                } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/schedule-list.php' ) ) {
                    include_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/schedule-list.php';
                } else {
                    include_once ETN_PLUGIN_TEMPLATE_DIR . 'event/schedule-list.php';
                }
    
            }
        }

    }

}

if ( !function_exists( 'etn_after_single_event_content_faq' ) ) {

    /**
     * Show data after event content section
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_after_single_event_content_faq( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_EVENT_TEMPLATE_THREE_ID != get_the_ID(  )) ){
            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
            $event_options    = get_option( "etn_event_options" );
            $default_faq_view = "";
            $faq_view         = apply_filters( "etn_faq_view", $default_faq_view, $single_event_id );
    
            if ( is_file( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . $faq_view ) && file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . $faq_view ) ) {
                include get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . $faq_view;
            } elseif ( is_file( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . $faq_view ) && file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . $faq_view ) ) {
                include get_template_directory() . ETN_THEME_TEMPLATE_DIR . $faq_view;
            } elseif ( defined( 'ETN_PRO_PLUGIN_TEMPLATE_DIR' ) && is_file( ETN_PRO_PLUGIN_TEMPLATE_DIR . $faq_view ) && file_exists( ETN_PRO_PLUGIN_TEMPLATE_DIR . $faq_view ) ) {
                include ETN_PRO_PLUGIN_TEMPLATE_DIR . $faq_view;
            }
        }

    }

}

if ( !function_exists( 'etn_after_single_event_meta_organizers' ) ) {
    /**
     * Show data after event meta section
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_after_single_event_meta_organizers( $single_event_id ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_EVENT_TEMPLATE_THREE_ID != get_the_ID(  )) ){

            $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
            $event_options        = get_option( "etn_event_options" );
            $etn_organizer_events = get_post_meta( $single_event_id, 'etn_event_organizer', true );
    
            // show event organizers
            if ( !isset( $event_options["etn_hide_organizers_from_details"] ) ) {
                Helper::single_template_organizer_free( $etn_organizer_events );
                //  etn widget end
            }
        }

    }

}

if ( !function_exists( 'etn_after_single_event_meta_ticket_form' ) ) {
    /**
     * Show data after event meta section
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_after_single_event_meta_ticket_form( $single_event_id ) {

        $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
        $event_options   = get_option( "etn_event_options" );

        // if active woocmmerce and has ticket , show registation form
        if ( isset( $event_options["sell_tickets"] ) && is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
            Helper::woocommerce_ticket_widget( $single_event_id );
        }

    }

}

if ( !function_exists( 'etn_after_single_event_meta_attendee_list' ) ) {
    /**
     * Show data after event meta section
     *
     * @param [type] $single_event_id
     * @return void
     */
    function etn_after_single_event_meta_attendee_list( $single_event_id ) {

        $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();

        if ( !empty( \Etn\Utils\Helper::get_option( "attendee_registration" ) ) && !empty( get_post_meta( $single_event_id, "attende_page_link", true ) ) ) {
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/attendee-list-button.php' ) ) {
                include_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/attendee-list-button.php';
            } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/attendee-list-button.php' ) ) {
                include_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/attendee-list-button.php';
            } else {
                include_once ETN_PLUGIN_TEMPLATE_DIR . 'event/attendee-list-button.php';
            }

        }

    }

}



/**************************************************
 * Start - Default hooks required for all templates
 *************************************************/

if ( !function_exists( 'etn_single_event_template_select' ) ) {

    /**
     * Decide which template to show and the content that carries all the template hooks
     *
     * @return void
     */
    function etn_single_event_template_select() {
        $default_template_name = "event-one";
        $template_name         = !empty( \Etn\Core\Settings\Settings::instance()->get_settings_option()['event_template'] ) ? \Etn\Core\Settings\Settings::instance()->get_settings_option()['event_template'] : $default_template_name;

        if( ETN_DEMO_SITE === true ) {

            switch( get_the_ID() ){
                case ETN_EVENT_TEMPLATE_ONE_ID :
                    $single_template_path = ETN_PLUGIN_TEMPLATE_DIR . "event-one.php";
                    break;
                case ETN_EVENT_TEMPLATE_TWO_ID :
                    $single_template_path = ETN_PRO_PLUGIN_TEMPLATE_DIR . "event-two.php";
                    break;
                case ETN_EVENT_TEMPLATE_THREE_ID :
                    $single_template_path = ETN_PRO_PLUGIN_TEMPLATE_DIR . "event-three.php";
                    break;
                default:
                    $single_template_path = \Etn\Utils\Helper::prepare_event_template_path( $default_template_name, $template_name );
                    break;
            }

            if ( file_exists( $single_template_path ) ) {
                include_once $single_template_path;
            }

        } else {

            //check if single page template is overriden from theme
            //if overriden, then the overriden template has higher priority
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . $template_name . '.php' ) ) {
                include_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . $template_name . '.php';
            } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . $template_name . '.php' ) ) {
                include_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . $template_name . '.php';
            } else {

                // check if multi-template settings exists
                $single_template_path = \Etn\Utils\Helper::prepare_event_template_path( $default_template_name, $template_name );

                if ( file_exists( $single_template_path ) ) {
                    include_once $single_template_path;
                }

            }
        }
    }

}

if ( !function_exists( 'etn_before_single_event_content' ) ) {

    /**
     * add parent markup before content
     *
     * @return void
     */
    function etn_before_single_event_content() {

        $options       = get_option( 'etn_event_general_options' );
        $settings      = \Etn\Core\Settings\Settings::instance()->get_settings_option();
        $container_cls = isset( $options['single_post_container_width_cls'] ) ? $options['single_post_container_width_cls'] : '';
        $template_name = isset( $settings['event_template'] ) && !is_null( $settings['event_template'] ) && !empty( $settings['event_template'] ) ? $settings['event_template'] : "";
        ?>
        <div class="etn-es-events-page-container <?php echo esc_attr( $container_cls . " " . $template_name ); ?>">
        <?php
    }

}

if ( !function_exists( 'etn_after_single_event_content' ) ) {

    /**
     * close parent markup before content
     *
     * @return void
     */
    function etn_after_single_event_content() {
        ?>
        </div>
        <?php
    }

}

if ( !function_exists( 'etn_before_single_event_details' ) ) {

    function etn_before_single_event_details( $single_event_id ) {
        return;
    }

}

if ( !function_exists( 'etn_before_single_event_container' ) ) {

    function etn_before_single_event_container( $single_event_id ) {
        return;
    }

}

if ( !function_exists( 'etn_before_single_event_content_wrap' ) ) {

    function etn_before_single_event_content_wrap( $single_event_id ) {
        return;
    }

}

if ( !function_exists( 'etn_after_single_event_content_title' ) ) {

    function etn_after_single_event_content_title( $single_event_id ) {
        return;
    }

}

if ( !function_exists( 'etn_before_single_event_content_body' ) ) {

    function etn_before_single_event_content_body( $single_event_id ) {
        return;
    }

}

if ( !function_exists( 'etn_before_single_event_meta' ) ) {

    function etn_before_single_event_meta( $single_event_id ) {
        return;
    }

}

if ( !function_exists( 'etn_after_single_event_details' ) ) {

    function etn_after_single_event_details( $single_event_id ) {
        return;
    }

}

/**
 * End - Default hooks required for all templates
 */



/**
 * Start - Event archive hooks
*/

if( !function_exists('etn_after_event_archive_content_show_footer') ){

    function etn_after_event_archive_content_show_footer( $single_event_id ) {
        $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
        if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/footer-content.php' ) ) {
            include get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/footer-content.php';
        } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/footer-content.php' ) ) {
            include get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/footer-content.php';
        } else {
            include ETN_PLUGIN_TEMPLATE_DIR . 'event/archive/footer-content.php';
        }
    }
}

if( !function_exists('etn_before_event_archive_content_show_thumbnail') ){ 

    function etn_before_event_archive_content_show_thumbnail( $single_event_id ){
        $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
        if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/thumbnail-content.php' ) ) {
            include get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/thumbnail-content.php';
        } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/thumbnail-content.php' ) ) {
            include get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/thumbnail-content.php';
        } else {
            include ETN_PLUGIN_TEMPLATE_DIR . 'event/archive/thumbnail-content.php';
        }
    }
}

if( !function_exists('etn_after_event_archive_title_show_excerpt') ){
    
    function etn_after_event_archive_title_show_excerpt( $single_event_id ){
        $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
        if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/excerpt-content.php' ) ) {
            include get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/excerpt-content.php';
        } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/excerpt-content.php' ) ) {
            include get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/excerpt-content.php';
        } else {
            include ETN_PLUGIN_TEMPLATE_DIR . 'event/archive/excerpt-content.php';
        }
    }
}

if( !function_exists('etn_before_event_archive_title_show_location') ){

    function etn_before_event_archive_title_show_location( $single_event_id ){
        $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
        if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/location-content.php' ) ) {
            include get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/location-content.php';
        } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/location-content.php' ) ) {
            include get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'event/archive/location-content.php';
        } else {
            include ETN_PLUGIN_TEMPLATE_DIR . 'event/archive/location-content.php';
        }

    }
}

/**
 * End - event archive hooks
 */
