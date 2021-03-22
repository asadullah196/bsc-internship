<?php

namespace Etn\Core\Schedule;

defined( 'ABSPATH' ) || exit;

class Category extends \Etn\Base\Taxonomy {

    // set custom post type name
    public function get_name() {
        return 'etn_schedule_category';
    }

    public function get_cpt() {
        return 'etn-schedule';
    }

    // Operation custom post type
    public function flush_rewrites() {
    }

    function taxonomy() {

        $labels = [
            'name'              => esc_html__(  'Category', 'eventin' ),
            'singular_name'     => esc_html__(  'Category', 'eventin' ),
            'search_items'      => esc_html__( 'Search Category', 'eventin' ),
            'all_items'         => esc_html__( 'All Category', 'eventin' ),
            'parent_item'       => esc_html__( 'Parent Category', 'eventin' ),
            'parent_item_colon' => esc_html__( 'Parent Category:', 'eventin' ),
            'edit_item'         => esc_html__( 'Edit Category', 'eventin' ),
            'update_item'       => esc_html__( 'Update Category', 'eventin' ),
            'add_new_item'      => esc_html__( 'Add New Category', 'eventin' ),
            'new_item_name'     => esc_html__( 'New Category Name', 'eventin' ),
            'menu_name'         => esc_html__( 'Category', 'eventin' ),
        ];

        $args = [
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_menu'      => 'etn-events-manager',
            'query_var'         => true,
            'show_in_rest'        => true,

            'rewrite'           => [ 'slug' => 'etn-schedule-category' ],
        ];

        return $args;
    }

    public function menu() {
        $parent = 'etn-events-manager';
        $name   = $this->get_name();
        $cpt    = $this->get_cpt();
        add_action( 'admin_menu', function () use ( $parent, $name, $cpt ) {
            add_submenu_page( $parent, esc_html__( 'Schedule categories', 'eventin' ), esc_html__( 'Schedule categories', 'eventin' ), 'edit_posts', 'edit-tags.php?taxonomy=' . $name . '&post_type=' . $cpt, false );
        } );
    }
}
