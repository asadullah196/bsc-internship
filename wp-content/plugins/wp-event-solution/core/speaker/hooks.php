<?php

namespace Etn\Core\Speaker;

use \Etn\Core\Speaker\Pages\Speaker_single_post;
use Etn\Core\Speaker\Views\Parts\TemplateHooks as PartsTemplateHooks;
use TemplateHooks;

defined( 'ABSPATH' ) || exit;

class Hooks {

    use \Etn\Traits\Singleton;

    public $cpt;
    public $action;
    public $base;
    public $speaker;
    public $category;
    public $settings;
    public $spaeker_action;

    public $actionPost_type = ['etn-speaker'];

    public function Init() {

        $this->cpt      = new Cpt();
        $this->action   = new Action();
        $this->settings = new Settings( 'etn', '1.0' );
        $this->category = new Category();
        // custom post meta

        $_metabox = new \Etn\Core\Metaboxs\Speaker_meta();

        add_action( 'add_meta_boxes', [$_metabox, 'register_meta_boxes'] );
        add_action( 'save_post', [$_metabox, 'save_meta_box_data'] );

        $this->add_menu();
        $this->add_single_page_template();
        add_action( 'init', [$this, 'add_default_speaker_categories'], 99999 );

        //Add column
        add_filter('manage_etn-speaker_posts_columns', [$this, 'speaker_column_headers']);
        add_action('manage_etn-speaker_posts_custom_column', [$this, 'speaker_column_data'], 10, 2);

        // Speaker single page template hooks
        $this->speaker_single_page_hooks();

    }

    /**
     * Speaker single page template hooks
     */
    public function speaker_single_page_hooks(){
        if ( file_exists(ETN_CORE ."speaker/views/template-hooks.php") ) {
             include_once ETN_CORE ."speaker/views/template-hooks.php";
        }
        if ( file_exists(ETN_CORE ."speaker/views/template-functions.php") ) {
            include_once ETN_CORE ."speaker/views/template-functions.php";
        }
    }

    public function add_menu() {
        $this->category->menu();
    }

    /**
     * Insert two categories of speaker cpt by default
     *
     * @return void
     */
    public function add_default_speaker_categories() {
        $org_term = term_exists( 'Organizer', 'etn_speaker_category' );

        if ( $org_term === null ) {
            wp_insert_term(
                'Organizer',
                'etn_speaker_category',
                [
                    'description' => 'Organizer of event',
                    'slug'        => 'organizer',
                    'parent'      => 0,
                ]
            );
        }

        $speaker_term = term_exists( 'Speaker', 'etn_speaker_category' );

        if ( $speaker_term === null ) {
            wp_insert_term(
                'Speaker',
                'etn_speaker_category',
                [
                    'description' => 'Speaker of schedule',
                    'slug'        => 'speaker',
                    'parent'      => 0,
                ]
            );
        }

    }

    public function add_single_page_template() {
        $page = new Speaker_single_post();
    }
    
    /**
     * Column name
     */
    public function speaker_column_headers( $columns ) {
        $new_item["id"] = esc_html__("Id", "eventin");
        $new_array = array_slice($columns, 0, 1, true) + $new_item + array_slice($columns, 1, count($columns)-1, true);
        return $new_array;
    }

    /**
     * Return row
     */
    public function speaker_column_data( $column, $post_id ) {
        switch ( $column ) {
        case 'id':
            echo intval( $post_id );
            break;
        }

    }
}
