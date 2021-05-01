<?php

namespace Etn_Pro\Core\Shortcodes;

use Etn_Pro\Utils\Helper;

defined( 'ABSPATH' ) || exit;

class Hooks {

    use \Etn\Traits\Singleton;

    /**
     * Call hooks function
     *
     * @return void
     */
    public function init() {
        //[etn_pro_organizers cat_id='19' order='asc' limit='3' url='yes' logo='yes' /]
        add_shortcode( "etn_pro_organizers", [$this, "organizers_widget"] );

        // [speakers_classic speaker_count ="10" speaker_order="DESC" speakers_category ="2" show_designation="yes" show_social ="yes" ]
        add_shortcode( "etn_pro_speakers_classic", [$this, "speakers_classic"] );
        add_shortcode( "etn_pro_speakers_standard", [$this, "speakers_standard"] );
        add_shortcode( "etn_pro_speakers_sliders", [$this, "speakers_sliders"] );

        // [etn_pro_events_classic event_count ="10" order="DESC" desc_limit="yes" ]
        add_shortcode( "etn_pro_events_classic", [$this, "events_classic"] );
        add_shortcode( "etn_pro_events_standard", [$this, "events_standard"] );
        add_shortcode( "etn_pro_events_sliders", [$this, "events_sliders"] );

        // [etn_pro_countdown event_id="18"/]
        add_shortcode( "etn_pro_countdown", [$this, "event_countdown"] );

        // [etn_pro_schedules_tab ids="16,33" order='asc'/]
        add_shortcode( "etn_pro_schedules_tab", [$this, "schedules_tab"] );

        // [etn_pro_schedules_list id="16" /]
        add_shortcode( "etn_pro_schedules_list", [$this, "schedules_list"] );

        // [etn_pro_ticket_form id="16" show_title="yes" /]
        add_shortcode( "etn_pro_ticket_form", [$this, "event_ticket_form"] );

        // [etn_pro_related_events id="16" /]
        add_shortcode( "etn_pro_related_events", [$this, "related_events"] );

        // [etn_pro_attendee_list id="16" /]
        add_shortcode( "etn_pro_attendee_list", [$this, "attendee_list"] );
    }

    /**
     * Ogranizer list function
     */
    public function organizers_widget( $attributes ) {
        $category_id              = isset( $attributes["cat_id"] ) && ( "" != $attributes["cat_id"] ) ? explode( ',', $attributes["cat_id"] ) : [];
        $etn_speaker_count        = isset( $attributes["limit"] ) && is_numeric( $attributes["limit"] ) ? intval( $attributes["limit"] ) : 3;
        $etn_speaker_order        = !empty( $attributes["order"] ) ? $attributes["order"] : 'DESC';

        // etn_speaker_order
        // sorting order 
        
        $post_attributes    = ['title', 'ID', 'name', 'post_date'];
        $orderby            = !empty( $attributes["orderby"] ) ? $attributes["orderby"] : 'title';
        $orderby_meta       = in_array($orderby, $post_attributes) ? false : 'meta_value';
    
        $show_url                 = isset( $attributes["url"] )  && ( "" != $attributes["url"] ) ? $attributes["url"] : 'yes';
        $etn_speaker_company_logo = isset( $attributes["logo"] ) && ( "" != $attributes["logo"] ) ? $attributes["logo"] : 'yes';
        $etn_speaker_col          = 3;

        ob_start();

        if ( file_exists( ETN_PRO_DIR . "/widgets/organizers/style/organizer-2.php" ) ) {
            include ETN_PRO_DIR . "/widgets/organizers/style/organizer-2.php";
        }

        return ob_get_clean();
    }

    /**
     * Speaker classic style
     */
    public function speakers_classic( $atts ) {
        $atts = extract( shortcode_atts( [
            'style'             => 'style-2',
            'speaker_count'     => 6,
            'order'             => 'DESC',
            'orderby'           => 'title',
            'speaker_col'       => 4,
            'speakers_category' => '',
            'show_designation'  => 'yes',
            'show_social'       => 'yes',
        ], $atts ) );
             
        $speaker_order      = $order ;
        $post_attributes    = ['title', 'ID', 'name', 'post_date'];
        $orderby_meta       = in_array($orderby, $post_attributes) ? false : 'meta_value';
        

        if ( $speaker_col == 6 ) {
            $speaker_col = 2;
        } else if ( $speaker_col == 5 ) {
            $speaker_col = 2;
        } else if ( $speaker_col == 4 ) {
            $speaker_col = 3;
        } else if ( $speaker_col == 3 ) {
            $speaker_col = 4;
        } else if ( $speaker_col == 2 ) {
            $speaker_col = 6;
        } else if ( $speaker_col == 1 ) {
            $speaker_col = 12;
        }
        
        $categories_id = [];
        if ( $speakers_category !== '' ) {
            $categories_id = explode( ',', $speakers_category );
        }

        $file_name = "";

        switch ( $style ) {
            case "style-1":
                $file_name = "speaker-2";
                break;
            case "style-2":
                $file_name = "speaker-5";
                break;
            case "style-3":
                $file_name = "speaker-3";
                break;
            default:
                $file_name = "speaker-3";
        }

        ob_start();
        if ( ETN_PRO_DIR . "/widgets/speakers/style/$file_name.php" ) {
            include ETN_PRO_DIR . "/widgets/speakers/style/$file_name.php";
        }
        return ob_get_clean();
    }

    /**
     * Speaker standard style
     */
    public function speakers_standard( $atts ) {
        $atts = extract( shortcode_atts( [
            'speaker_count'     => 6,
            'order'             => 'DESC',
            'orderby'           => 'title',
            'speakers_category' => '',
            'show_designation'  => 'yes',
            'speaker_col'       => 4,
            'show_social'       => 'yes',
        ], $atts ) );

        $speaker_order      = $order ;
        $post_attributes    = ['title', 'ID', 'name', 'post_date'];
        $orderby_meta       = in_array($orderby, $post_attributes) ? false : 'meta_value';

        if ( $speaker_col == 6 ) {
            $speaker_col = 2;
        } else if ( $speaker_col == 5 ) {
            $speaker_col = 2;
        } else if ( $speaker_col == 4 ) {
            $speaker_col = 3;
        } else if ( $speaker_col == 3 ) {
            $speaker_col = 4;
        } else if ( $speaker_col == 2 ) {
            $speaker_col = 6;
        } else if ( $speaker_col == 1 ) {
            $speaker_col = 12;
        }

        $categories_id = [];
        if ( $speakers_category !== '' ) {
            $categories_id = explode( ',', $speakers_category );
        }

        ob_start();
        if ( file_exists( ETN_PRO_DIR . "/widgets/speakers/style/speaker-4.php" ) ) {
            include ETN_PRO_DIR . "/widgets/speakers/style/speaker-4.php";
        }
        return ob_get_clean();
    }

    /**
     * Speaker slider style
     */
    public function speakers_sliders( $atts ) {
        $atts = extract( shortcode_atts(
            [
                'style'            => 'style-1',
                'speaker_count'    => 6,
                'slider_count'     => 3,
                'order'            => 'DESC',
                'orderby'          => 'title',
                'categories_id'    => '',
                'spaceBetween'     => 30,
                'show_designation' => 'yes',
                'slider_nav_show'  => 'yes',
                'slider_dot_show'  => 'yes',
                'show_social'      => 'yes',
            ],
            $atts
        ) );

        $speaker_order      = $order ;
        $post_attributes    = ['title', 'ID', 'name', 'post_date'];
        $orderby_meta       = in_array($orderby, $post_attributes) ? false : 'meta_value';
        $speaker_category   = [];
        if ( $categories_id !== '' ) {
            $speaker_category = explode( ',', $categories_id );
        }

        $file_name = "";

        switch ( $style ) {
            case "style-1":
                $file_name = "speaker-1";
                break;
            case "style-2":
                $file_name = "speaker-2";
                break;
            case "style-3":
                $file_name = "speaker-3";
                break;
            case "style-4":
                $file_name = "speaker-4";
                break;
            case "style-5":
                $file_name = "speaker-5";
                break;
            default:
                $file_name = "speaker-1";
        }
        ob_start();
        ?>
        <div class='speaker_shortcode_slider'>
            <?php
            if ( file_exists( ETN_PRO_DIR . "/widgets/speakers-slider/style/$file_name.php" ) ) {
                include ETN_PRO_DIR . "/widgets/speakers-slider/style/$file_name.php";
            }
            ?>
        </div>
        <?php

        return ob_get_clean();
    }

    /**
     * Events standard style
     */
    public function events_standard( $atts ) {
        $atts = extract( shortcode_atts( [
            'event_count'         => 6,
            'event_col'           => 2,
            'event_cat_ids'       => '',
            'event_tag_ids'       => '',
            'order'               => 'DESC',
            'show_desc'           => 'yes',
            'show_category'       => 'yes',
            'show_attendee_count' => 'no',
            'show_btn'            => 'yes',
            'show_thumb'          => 'yes',
            'btn_text'            => 'Attend',
            'desc_limit'          => '25',
        ], $atts ) );

        $event_cat = [];
        $event_tag = [];

        if ( $event_cat_ids !== '' ) {
            $event_cat = explode( ',', $event_cat_ids );
        }

        if ( $event_tag_ids !== '' ) {
            $event_tag = explode( ',', $event_tag_ids );
        }

        if ( $event_col == 6 ) {
            $event_col = 2;
        } else if ( $event_col == 5 ) {
            $event_col = 2;
        } else if ( $event_col == 4 ) {
            $event_col = 3;
        } else if ( $event_col == 3 ) {
            $event_col = 4;
        } else if ( $event_col == 2 ) {
            $event_col = 6;
        } else if ( $event_col == 1 ) {
            $event_col = 12;
        }

        ob_start();

        include ETN_PRO_DIR . "/widgets/events-pro/style/event-2.php";

        return ob_get_clean();
    }

    /**
     * Events classic style
     */
    public function events_classic( $atts ) {

        $atts = extract( shortcode_atts( [
            'style'               => 'style-3',
            'event_count'         => 6,
            'event_col'           => 2,
            'event_cat_ids'       => '',
            'event_tag_ids'       => '',
            'order'               => 'DESC',
            'show_desc'           => 'yes',
            'show_category'       => 'yes',
            'show_attendee_count' => 'no',
            'show_btn'            => 'yes',
            'show_thumb'          => 'yes',
            'btn_text'            => 'Attend',
            'desc_limit'          => '25',
        ], $atts ) );

        $event_cat = [];
        $event_tag = [];

        if ( $event_cat_ids !== '' ) {
            $event_cat = explode( ',', $event_cat_ids );
        }

        if ( $event_tag_ids !== '' ) {
            $event_tag = explode( ',', $event_tag_ids );
        }

        if ( $event_col == 6 ) {
            $event_col = 2;
        } else if ( $event_col == 5 ) {
            $event_col = 2;
        } else if ( $event_col == 4 ) {
            $event_col = 3;
        } else if ( $event_col == 3 ) {
            $event_col = 4;
        } else if ( $event_col == 2 ) {
            $event_col = 6;
        } else if ( $event_col == 1 ) {
            $event_col = 12;
        }

        ob_start();
        $file_name = "";

        switch ( $style ) {
            case "style-1":
                $file_name = "event-1";
                break;
            case "style-2":
                $file_name = "event-4";
                break;
            case "style-3":
                $file_name = "event-3";
                break;
            default:
                $file_name = "event-3";
        }

        if ( file_exists( ETN_PRO_DIR . "/widgets/events-pro/style/$file_name.php" ) ) {
            include ETN_PRO_DIR . "/widgets/events-pro/style/$file_name.php";
        }

        return ob_get_clean();
    }

    /**
     * Events sliders
     */
    public function events_sliders( $atts ) {

        $atts = extract( shortcode_atts( [
            'style'               => 'event-1',
            'event_count'         => 6,
            'event_slider_count'  => 2,
            'event_cat_ids'       => '',
            'event_tag_ids'       => '',
            'order'               => 'DESC',
            'show_desc'           => 'yes',
            'show_category'       => 'yes',
            'show_attendee_count' => 'no',
            'show_btn'            => 'yes',
            'show_thumb'          => 'yes',
            'slider_nav_show'     => 'yes',
            'slider_dot_show'     => 'yes',
            'btn_text'            => 'Attend',
            'desc_limit'          => '25',
        ], $atts ) );

        $event_cat = [];
        $event_tag = [];

        if ( $event_cat_ids !== '' ) {
            $event_cat = explode( ',', $event_cat_ids );
        }

        if ( $event_tag_ids !== '' ) {
            $event_tag = explode( ',', $event_tag_ids );
        }

        $style = ( isset( $style ) && $style != '' ) ? $style : 'event-1';

        ob_start();

        ?>
        <div class="event-slider-shortcode">
            <?php include ETN_PRO_DIR . "/widgets/events-slider/style/{$style}.php";?>
        </div>
        <?php

        return ob_get_clean();
    }

    /**
     * Events countdown
     */
    public function event_countdown( $atts ) {

        $atts = extract( shortcode_atts( ['event_id' => 0], $atts ) );

        $etn_start_date   = get_post_meta( $event_id, 'etn_start_date', true );
        $event_start_time = get_post_meta( $event_id, 'etn_start_time', true );

        ob_start();
        ?>
        <h2 class="event-cowntdown-title"><?php echo esc_html( get_the_title( $event_id ) ); ?></h2>
        <?php
        Helper::countdown_markup( $etn_start_date, $event_start_time );
        return ob_get_clean();
    }

    /**
     * Events countdown
     */
    public function event_ticket_form( $atts ) {

        $atts = extract( shortcode_atts( ["id" => 0, "show_title" => "yes"], $atts ) );

        if ( class_exists( 'WooCommerce' ) ) {

            if ( function_exists( 'wc_print_notices' ) ) {
                wc_print_notices();
            }
        }

        ob_start();

        ?>
        <div class="etn-event-form-widget">
            <?php

            if ( isset( $show_title ) && $show_title == "yes" ) {
                ?>
                <div>
                    <h3 class="etn-event-form-widget-title"><?php echo esc_html( get_the_title( $id ) ); ?></h3>
                </div>
                <?php
            }

            if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
                Helper::woocommerce_ticket_widget( $id );
            }

            ?>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Events countdown
     */
    public function related_events( $atts ) {

        $atts = extract( shortcode_atts( ["id" => 0], $atts ) );
        ob_start();
        ?>
        <div class="etn-related-event-widget">
            <?php
            Helper::related_events_widget( $id );
            ?>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Schedule tab style
     */
    public function schedules_tab( $atts ) {

        $atts = extract( shortcode_atts( [
            'style'              => 'style-2',
            'ids'                => 16,
            'order'              => 'DESC',
            'show_time_duration' => 'yes',
            'show_location'      => 'yes',
            'show_speaker'       => 'yes',

        ], $atts ) );

        $schedule_ids = [];

        if ( $ids !== '' ) {
            $schedule_ids = explode( ',', $ids );
        }

        $widget_id     = uniqid();
        $event_options = get_option( "etn_event_options" );
        $col           = ( $show_speaker == 'yes' ) ? 'etn-col-lg-6' : 'etn-col-lg-9';

        ob_start();

        $file_name = "";

        switch ( $style ) {
        case "style-1":
            $file_name = "schedule-1";
            break;
        case "style-2":
            $file_name = "schedule-2";
            break;
        default:
            $file_name = "schedule-2";
        }

        if ( file_exists( ETN_PRO_DIR . "/widgets/schedule-tab/style/$file_name.php" ) ) {
            include ETN_PRO_DIR . "/widgets/schedule-tab/style/$file_name.php";
        }

        return ob_get_clean();
    }

    /**
     * Schedule tab style
     */
    public function schedules_list( $atts ) {
        $atts = extract( shortcode_atts( [
            'style'              => 'style-1',
            'id'                 => 16,
            'show_time_duration' => 'yes',
            'show_location'      => 'yes',
            'show_desc'          => 'yes',
            'show_speaker'       => 'yes',
        ], $atts ) );
        $col = ( $show_speaker == 'yes' ) ? 'etn-col-lg-6' : 'etn-col-lg-9';

        ob_start();
        $schedule_id = ( !empty( $id ) ) ? $id : '';

        $file_name = "";

        switch ( $style ) {
            case "style-1":
                $file_name = "schedule-1";
                break;
            case "style-2":
                $file_name = "schedule-2";
                break;
            default:
                $file_name = "schedule-1";
        }

        if ( file_exists( ETN_PRO_DIR . "/widgets/schedule-list/style/$file_name.php" ) ) {
            include ETN_PRO_DIR . "/widgets/schedule-list/style/$file_name.php";
        }

        return ob_get_clean();
    }

    /**
     * Events countdown
     */
    public function attendee_list( $atts ) {

        $atts = extract( shortcode_atts(
            [
                "id"          => 0,
                'show_avatar' => 'yes',
                'show_email'  => 'yes',
            ],
            $atts ) );
        ob_start();
        ?>
        <div class="etn-attendee-list-widget">
            <?php
            Helper::attendee_list_widget( $id, $show_avatar, $show_email );
            ?>
        </div>
        <?php
        return ob_get_clean();
    }

}
