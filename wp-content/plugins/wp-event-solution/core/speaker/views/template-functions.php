<?php
defined( 'ABSPATH' ) || exit;

/********************
    Speaker one start
 ********************/


if ( !function_exists( 'speaker_designation' ) ) {
    /**
     * Designation
     */
    function speaker_designation() {
        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE === true && ( ETN_SPEAKER_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_SPEAKER_TEMPLATE_THREE_ID != get_the_ID(  ) ) ) ){
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-designation.php' ) ) {
                require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-designation.php';
            } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-designation.php' ) ) {
                require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-designation.php';
            } else {
                require_once ETN_PLUGIN_TEMPLATE_DIR . 'speaker/speaker-designation.php';
            }
        }

    }

}

if ( !function_exists( 'speaker_summary' ) ) {
    /**
     * Summary
     */
    function speaker_summary() {
        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE === true && ( ETN_SPEAKER_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_SPEAKER_TEMPLATE_THREE_ID != get_the_ID(  ) ) ) ){
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-summary.php' ) ) {
                require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-summary.php';
            } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-summary.php' ) ) {
                require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-summary.php';
            } else {
                require_once ETN_PLUGIN_TEMPLATE_DIR . 'speaker/speaker-summary.php';
            }
        }

    }

}

if ( !function_exists( 'speaker_socials' ) ) {
    /**
     * Socials
     */
    function speaker_socials() {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE === true && ( ETN_SPEAKER_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_SPEAKER_TEMPLATE_THREE_ID != get_the_ID(  ) ) ) ){
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-socials.php' ) ) {
                require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-socials.php';
            } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-socials.php' ) ) {
                require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-socials.php';
            } else {
                require_once ETN_PLUGIN_TEMPLATE_DIR . 'speaker/speaker-socials.php';
            }
        }

    }
}

/**
 * Speaker social 2 style
 */
if ( !function_exists( 'speaker_socials_two' ) ) {
    /**
     * Socials
     */
    function speaker_socials_two() {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE === true && ( ETN_SPEAKER_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_SPEAKER_TEMPLATE_THREE_ID != get_the_ID(  ) ) ) ){
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-socials-two.php' ) ) {
                require_once get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-socials-two.php';
            } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-socials-two.php' ) ) {
                require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-socials-two.php';
            } else {
                require_once ETN_PLUGIN_TEMPLATE_DIR . 'speaker/speaker-socials-two.php';
            }
        }

    }
}

if ( !function_exists( 'schedule_time' ) ) {
    /**
     * Schedule time
     */
    function schedule_time( $start, $end ) {
        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE === true && ( ETN_SPEAKER_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_SPEAKER_TEMPLATE_THREE_ID != get_the_ID(  ) ) ) ){
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/schedule-time.php' ) ) {
                require get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/schedule-time.php';
            } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/schedule-time.php' ) ) {
                require get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/schedule-time.php';
            } else {
                require ETN_PLUGIN_TEMPLATE_DIR . 'speaker/schedule-time.php';
            }
        }

    }

}

if ( !function_exists( 'schedule_locations' ) ) {
    /**
     * Schedule location
     */
    function schedule_locations( $etn_shedule_room ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE === true && ( ETN_SPEAKER_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_SPEAKER_TEMPLATE_THREE_ID != get_the_ID(  ) ) ) ){
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/schedule-locations.php' ) ) {
                require get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/schedule-locations.php';
            } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/schedule-locations.php' ) ) {
                require get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/schedule-locations.php';
            } else {
                require ETN_PLUGIN_TEMPLATE_DIR . 'speaker/schedule-locations.php';
            }
        }

    }

}

if ( !function_exists( 'speaker_topic' ) ) {
    /**
     * Schedule topic
     */
    function speaker_topic( $topic ) {
        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE === true && ( ETN_SPEAKER_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_SPEAKER_TEMPLATE_THREE_ID != get_the_ID(  ) ) ) ){
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/schedule-topic.php' ) ) {
                require get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/schedule-topic.php';
            } elseif ( file_exists( get_template_directory(  ) . ETN_THEME_TEMPLATE_DIR . 'speaker/schedule-topic.php' ) ) {
                require get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/schedule-topic.php';
            } else {
                require ETN_PLUGIN_TEMPLATE_DIR . 'speaker/schedule-topic.php';
            }
        }

    }

}

if ( !function_exists( 'speaker_objective' ) ) {
    /**
     * Schedule objective
     */
    function speaker_objective( $objective ) {

        if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE === true && ( ETN_SPEAKER_TEMPLATE_TWO_ID != get_the_ID(  ) && ETN_SPEAKER_TEMPLATE_THREE_ID != get_the_ID(  ) ) ) ){
            
            if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-objective.php' ) ) {
                require get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-objective.php';
            } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-objective.php' ) ) {
                require_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/speaker-objective.php';
            } else {
                require ETN_PLUGIN_TEMPLATE_DIR . 'speaker/speaker-objective.php';
            }
        }

    }

}

/* **********************
*  Speaker one end
************************/

/**********
 * Default hooks required for all templates
 **********/

if ( !function_exists( 'etn_single_speaker_template_select' ) ) {
    function etn_single_speaker_template_select() {

        //$settings =  \Etn\Core\Settings\Settings::instance()->get_settings_option();
       // $default_template_name              = isset( $settings['speaker_template'] ) ? $settings['speaker_template'] : "";

        /**
         * Use them to check output
         */
        //print_r(); - direct print
        //var_dump(); - Array

        //$default_template_name = "speaker-two";

        $settings              = \Etn\Core\Settings\Settings::instance()->get_settings_option();
        $template_name         = !empty( $settings['speaker_template'] ) ? $settings['speaker_template'] : $default_template_name;
        $default_template_name         = !empty( $settings['speaker_template'] ) ? $settings['speaker_template'] : $default_template_name;
        
        if( ETN_DEMO_SITE === true ) {

            switch( get_the_ID() ){
                case ETN_SPEAKER_TEMPLATE_ONE_ID :
                    $single_template_path = ETN_PLUGIN_TEMPLATE_DIR . "speaker-one.php";
                    break;
                case ETN_SPEAKER_TEMPLATE_TWO_ID :
                    $single_template_path = ETN_PRO_PLUGIN_TEMPLATE_DIR . "speaker-two.php";
                    break;
                case ETN_SPEAKER_TEMPLATE_THREE_ID :
                    $single_template_path = ETN_PRO_PLUGIN_TEMPLATE_DIR . "speaker-three.php";
                    break;
                default:
                    $single_template_path = \Etn\Utils\Helper::prepare_speaker_template_path( $default_template_name, $template_name );
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
            } else if ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . $template_name . '.php' ) ) {
                include_once get_template_directory() . ETN_THEME_TEMPLATE_DIR . $template_name . '.php';
            } else {
    
                // check if multi-template settings exists
                $single_template_path = \Etn\Utils\Helper::prepare_speaker_template_path( $default_template_name, $template_name );
    
                if ( file_exists( $single_template_path ) ) {
                    include_once $single_template_path;
                }
    
            }
        }

    }

}

if ( !function_exists( 'etn_before_single_speaker_content' ) ) {
    /**
     * Speaker single page before
     */
    function etn_before_single_speaker_content() {
        $options       = get_option( 'etn_event_general_options' );
        $container_cls = isset( $options['single_post_container_width_cls'] ) ? $options['single_post_container_width_cls'] : '';
        ?>
        <div class="etn-speaker-page-container  <?php echo esc_attr( $container_cls ); ?>">
            <div class="etn-container">
        <?php
    }

}

if ( !function_exists( 'etn_after_single_speaker_content' ) ) {

    /**
     * Speaker single page after
     */
    function etn_after_single_speaker_content() {
        ?>
            </div>
        </div>
        <?php
    }

}

if ( !function_exists( 'speaker_main_content_before' ) ) {
    /**
     * Speaker main wrapper  before
     */
    function speaker_main_content_before() {
        return;
    }

}

if ( !function_exists( 'speaker_title_before' ) ) {
    /**
     * Speaker title  before
     */
    function speaker_title_before() {
        return;
    }

}

if ( !function_exists( 'speaker_details_before' ) ) {
    /**
     * Speaker details  before
     */
    function speaker_details_before() {
        return;
    }

}

if ( !function_exists( 'speaker_title_after' ) ) {
    /**
     * Speaker title  after
     */
    function speaker_title_after() {
        return;
    }

}

if ( !function_exists( 'speaker_details_after' ) ) {
    /**
     * Speaker details after
     */
    function speaker_details_after() {
        return;
    }

}

if ( !function_exists( 'speaker_main_content_after' ) ) {
    /**
     * Speaker main wrapper  after
     */
    function speaker_main_content_after() {
        return;
    }

}

if( !function_exists('etn_before_speaker_archive_content_show_thumbnail') ){

    function etn_before_speaker_archive_content_show_thumbnail( $single_event_id ){
        $single_event_id = !empty( $single_event_id ) ? $single_event_id : get_the_ID();
        if ( file_exists( get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/archive/thumbnail-content.php' ) ) {
            include get_stylesheet_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/archive/thumbnail-content.php';
        } elseif ( file_exists( get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/archive/thumbnail-content.php' ) ) {
            include get_template_directory() . ETN_THEME_TEMPLATE_DIR . 'speaker/archive/thumbnail-content.php';
        } else {
            include ETN_PLUGIN_TEMPLATE_DIR . 'speaker/archive/thumbnail-content.php';
        }
    }
}