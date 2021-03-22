<?php

namespace Etn\Core\Shortcodes;

defined( 'ABSPATH' ) || exit;

class Hooks {

    use \Etn\Traits\Singleton;

    public function Init() {
        //[events limit='1' event_cat_ids='1,2' event_tag_ids='1,2' /]
        add_shortcode( "events", [$this, "etn_events_widget"] );

        //[speakers cat_id='19' limit='3'/]
        add_shortcode( "speakers", [$this, "etn_speakers_widget"] );

        //[schedules ids ='18,19'/]
        add_shortcode( "schedules", [$this, "etn_schedules_widget"] );

        //[etn_zoom_api_link meeting_id ='123456789' link_only='no']
        add_shortcode( "etn_zoom_api_link", [$this, "etn_zoom_api_link"] );
    }

    /**
     * Events shortcode
     */
    public function etn_events_widget( $attributes ) {

        $event_cat = null;
        $event_tag = null;

        if ( isset( $attributes['event_cat_ids'] ) && $attributes['event_cat_ids'] !== '' ) {
            $event_cat = explode( ',', $attributes['event_cat_ids'] );
        }

        if ( isset( $attributes['event_tag_ids'] ) && $attributes['event_tag_ids'] !== '' ) {
            $event_tag = explode( ',', $attributes['event_tag_ids'] );
        }

        $event_count    = isset( $attributes["limit"] ) && is_numeric( $attributes["limit"] ) && is_numeric( $attributes["limit"] ) <= 3 ? intval( $attributes["limit"] ) : 3;
        $order          = !empty( $attributes["order"] ) ? $attributes["order"] : 'DESC';
        $etn_desc_limit = 20;
        $etn_event_col  = 4;

        $post_attributes    = ['title', 'ID', 'name', 'post_date'];
        $orderby            = !empty( $attributes["orderby"] ) ? $attributes["orderby"] : 'title';
        $orderby_meta       = in_array($orderby, $post_attributes) ? false : 'meta_value';

        ob_start();

        if ( file_exists( ETN_WIDGETS . "events/style/event-1.php" ) ) {
            include ETN_WIDGETS . "events/style/event-1.php";
        }

        return ob_get_clean();
    }

    /**
     * Speakers shortcode
     */
    public function etn_speakers_widget( $attributes ) {

        $speakers_category  = isset( $attributes["cat_id"] ) && ( "" != $attributes["cat_id"] ) ? explode( ',', $attributes["cat_id"] ) : [];
        $etn_speaker_count  = isset( $attributes["limit"] ) && is_numeric( $attributes["limit"] ) ? $attributes["limit"] : 3;
        $etn_speaker_order  = !empty( $attributes["order"] ) ? $attributes["order"] : 'DESC';
        $etn_speaker_col    = 4;
        
        $post_attributes    = ['title', 'ID', 'name', 'post_date'];
        $orderby            = !empty( $attributes["orderby"] ) ? $attributes["orderby"] : 'title';
        $orderby_meta       = in_array($orderby, $post_attributes) ? false : 'meta_value';
        
        ob_start();

        if ( file_exists( ETN_WIDGETS . "speakers/style/speaker-2.php" ) ) {
            include ETN_WIDGETS . "speakers/style/speaker-2.php";
        }

        return ob_get_clean();
    }

    /**
     * Schedule shortcode
     */
    public function etn_schedules_widget( $attributes ) {
        $schedule_ids     = is_array( $attributes ) && isset( $attributes["ids"] ) ? $attributes["ids"] : "";
        $etn_schedule_ids = explode( ",", $schedule_ids );
        $order            = isset( $attributes["order"] ) ? $attributes["order"] : 'asc';

        ob_start();

        if ( file_exists( ETN_WIDGETS . "schedule/style/schedule-1.php" ) ) {
            include ETN_WIDGETS . "schedule/style/schedule-1.php";
        }

        return ob_get_clean();
    }

    /**
     * Zoom meeting info function
     */
    public function etn_zoom_api_link( $atts, $content ) {
        extract( shortcode_atts( ['meeting_id' => 'javascript:void(0);', 'link_only' => 'no'], $atts ) );

        ob_start();

        if ( empty( $meeting_id ) ) {
            ?>
            <div class=""><?php echo esc_html__( 'No meeting id found', "eventin" ) ?></div>
            <?php
        } else {
            $zoom_meeting = $this->fetch_meeting( $meeting_id );
            include ETN_CORE . 'zoom-meeting/template/shortcode/zoom_meeting.php';
        }

        return ob_get_clean();
    }

    /**
     * fetch meeting info function
     */
    private function fetch_meeting( $meeting_id ) {
        $meeting_info = \Etn\Core\Zoom_Meeting\Api_Handlers::instance()->meeting_info( $meeting_id );
        if ( count( $meeting_info ) === 0 ) {
            return false;
        }

        return $meeting_info;
    }

}
