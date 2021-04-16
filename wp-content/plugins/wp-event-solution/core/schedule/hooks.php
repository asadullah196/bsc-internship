<?php

namespace Etn\Core\Schedule;

use \Etn\Core\Schedule\Pages\Schedule_single_post;

defined( 'ABSPATH' ) || exit;

class Hooks {

    use \Etn\Traits\Singleton;

    public $cpt;
    public $action;
    public $base;
    public $schedule;
    public $settings;
    public $schedule_action;

    public $actionPost_type = ['etn-schedule'];

    public function Init() {
        $this->cpt      = new Cpt();
        $this->action   = new Action();
        $this->settings = new Settings( 'etn', '1.0' );

        // custom post meta
        $_metabox = new \Etn\Core\Metaboxs\Schedule_meta();

        add_action( 'add_meta_boxes', [$_metabox, 'register_meta_boxes'] );
        add_action( 'save_post', [$_metabox, 'save_meta_box_data'] );

        $this->add_single_page_template();

        //Add column
        add_filter('manage_etn-schedule_posts_columns', [$this, 'schedule_column_headers']);
        add_action('manage_etn-schedule_posts_custom_column', [$this, 'schedule_column_data'], 10, 2);
        
        add_filter( "manage_edit-etn_speaker_category_columns", [$this, 'category_column_header'], 10);
        add_action( "manage_etn_speaker_category_custom_column", [$this, 'category_column_content'], 10, 3);
    }
    
    
    function category_column_header($columns) {
        $new_item["id"] = esc_html__("Id", "eventin");
        $new_array = array_slice($columns, 0, 1, true) + $new_item + array_slice($columns, 1, count($columns)-1, true);
        return $new_array;
    }

    function category_column_content($content, $column_name, $term_id){
        return $term_id;
    }

    /**
     * Column name
     */
    public function schedule_column_headers( $columns ) {
        $new_item["id"] = esc_html__("Id", "eventin");
        $new_array = array_slice($columns, 0, 1, true) + $new_item + array_slice($columns, 1, count($columns)-1, true);
        return $new_array;
    }

    /**
     * Return row
     */
    public function schedule_column_data( $column, $post_id ) {
        switch ( $column ) {
        case 'id':
            echo intval( $post_id );
            break;
        }

    }

    function add_single_page_template() {
        $page = new Schedule_single_post();
    }
}
