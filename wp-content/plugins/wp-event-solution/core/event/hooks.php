<?php

namespace Etn\Core\Event;

use \Etn\Core\Event\Pages\Event_single_post;

defined( 'ABSPATH' ) || exit;

class Hooks {

    use \Etn\Traits\Singleton;

    public $cpt;
    public $action;
    public $base;
    public $category;
    public $tags;
    public $event;
    public $settings;

    public $actionPost_type = ['etn'];

    public function Init() {

        $this->cpt      = new Cpt();
        $this->category = new Category();
        $this->tags     = new Tags();
        $this->action   = new Action();

        $this->add_metaboxes();
        $this->add_menu();
        $this->add_single_page_template();
        $this->initialize_template_hooks();
        $this->prepare_post_taxonomy_columns();
        
        add_filter( "etn_form_submit_visibility", [$this, "form_submit_visibility"], 10, 2 );
    }

    public function add_metaboxes() {
        
        // custom post meta
        $event_metabox = new \Etn\Core\Metaboxs\Event_meta();
        add_action( 'add_meta_boxes', [$event_metabox, 'register_meta_boxes'] );
        add_action( 'save_post', [$event_metabox, 'save_meta_box_data'] );
    }

    public function initialize_template_hooks() {
        include_once ETN_DIR . '/core/event/template-hooks.php';
        include_once ETN_DIR . '/core/event/template-functions.php';
    }

    public function prepare_post_taxonomy_columns() {
        //Add column
        add_filter( 'manage_etn_posts_columns', [$this, 'event_column_headers'] );
        add_action( 'manage_etn_posts_custom_column', [$this, 'event_column_data'], 10, 2 );

        add_filter( "manage_edit-etn_category_columns", [$this, 'category_column_header'], 10 );
        add_action( "manage_etn_category_custom_column", [$this, 'category_column_content'], 10, 3 );

        add_filter( "manage_edit-etn_tags_columns", [$this, 'category_column_header'], 10 );
        add_action( "manage_etn_tags_custom_column", [$this, 'category_column_content'], 10, 3 );
    }

    function category_column_header( $columns ) {
        $new_item["id"] = esc_html__( "Id", "eventin" );
        $new_array      = array_slice( $columns, 0, 1, true ) + $new_item + array_slice( $columns, 1, count( $columns ) - 1, true );
        return $new_array;
    }

    function category_column_content( $content, $column_name, $term_id ) {
        return $term_id;
    }

    function add_menu() {
        $this->category->menu();
        $this->tags->menu();
    }

    function add_single_page_template() {
        $page = new Event_single_post();
    }

    /**
     * Column name
     */
    public function event_column_headers( $columns ) {
        $new_item["id"] = esc_html__( "Id", "eventin" );
        $new_array      = array_slice( $columns, 0, 1, true ) + $new_item + array_slice( $columns, 1, count( $columns ) - 1, true );
        return $new_array;
    }

    /**
     * Return row
     */
    public function event_column_data( $column, $post_id ) {

        switch ( $column ) {
        case 'id':
            echo intval( $post_id );
            break;
        }

    }

    
    /**
     * set form submission button visibility
     *
     * @param [type] $visible
     * @param [type] $post_id
     * @return void
     */
    public function form_submit_visibility( $visible, $post_id ) {

        //get disable option setting from db
        $settings                        = \Etn\Core\Settings\Settings::instance()->get_settings_option();
        $disable_registration_if_expired = isset( $settings['disable_registration_if_expired'] ) ? true : false;
        $is_visible                      = true;

        //get expiry date condition from db
        $selected_expiry_point  = (isset($settings['expiry_point']) && "" != $settings['expiry_point']) ? $settings['expiry_point'] : "start";
        $event_expire_date_time = "";

        if ( $selected_expiry_point == "start" ) {
            //event start date-time
            $event_expire_date      = !empty( get_post_meta( $post_id, "etn_start_date", true ) ) && !is_null( get_post_meta( $post_id, "etn_start_date", true ) ) ? get_post_meta( $post_id, "etn_start_date", true ) : "";
            $event_expire_time      = !empty( get_post_meta( $post_id, "etn_start_time", true ) ) && !is_null( get_post_meta( $post_id, "etn_start_time", true ) ) ? get_post_meta( $post_id, "etn_start_time", true ) : "";
            $event_expire_date_time = trim( $event_expire_date . " " . $event_expire_time );
        } elseif ( $selected_expiry_point == "end" ) {
            //event end date-time
            $event_expire_date      = !empty( get_post_meta( $post_id, "etn_end_date", true ) ) && !is_null( get_post_meta( $post_id, "etn_end_date", true ) ) ? get_post_meta( $post_id, "etn_end_date", true ) : "";
            $event_expire_time      = !empty( get_post_meta( $post_id, "etn_end_time", true ) ) && !is_null( get_post_meta( $post_id, "etn_end_time", true ) ) ? get_post_meta( $post_id, "etn_end_time", true ) : "";
            $event_expire_date_time = trim( $event_expire_date . " " . $event_expire_time );
        }

        // if disable option is on and expire date has passed
        //  then do not show form submit button
        if ( !$disable_registration_if_expired || ( "" == $event_expire_date_time ) ) {
            $is_visible = true;
        } else {
            $current_time = time();
            $expire_time  = strtotime( $event_expire_date_time );
            if ( $current_time > $expire_time ) {
                $is_visible = false;
            } else {
                $is_visible = true;
            }
        }

        return $is_visible;

    }

}
