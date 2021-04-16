<?php

namespace Etn\Core\Zoom_Meeting;

use Etn\Traits\Singleton;

defined('ABSPATH') || exit;

class Cpt extends \Etn\Base\Cpt{
    use Singleton;
    
    // set custom post type name
    public function get_name(){
        return 'etn-zoom-meeting';
    }
  
    // set custom post type options data
    public function post_type(){
        $options = $this->user_modifiable_option();
        $labels = array(
            'name'                  => esc_html_x('Zoom meeting', 'Post Type General Name', 'eventin'),
            'singular_name'         => $options['etn_zoom_meeting_singular_name'],
            'menu_name'             => esc_html__('Add new meeting', 'eventin'),
            'name_admin_bar'        => esc_html__('Zoom meeting', 'eventin'),
            'attributes'            => esc_html__('Zoom meeting Attributes', 'eventin'),
            'parent_item_colon'     => esc_html__('Parent Item:', 'eventin'),
            'all_items'             => $options['etn_zoom_meeting_all'],
            'add_new_item'          => esc_html__('Add new zoom meeting', 'eventin'),
            'add_new'               => esc_html__('Add New', 'eventin'),
            'new_item'              => esc_html__('New zoom meeting', 'eventin'),
            'edit_item'             => esc_html__('Edit zoom meeting', 'eventin'),
            'update_item'           => esc_html__('Update zoom meeting', 'eventin'),
            'view_item'             => esc_html__('View zoom meeting', 'eventin'),
            'view_items'            => esc_html__('View zoom meeting', 'eventin'),
            'search_items'          => esc_html__('Search zoom meeting', 'eventin'),
            'not_found'             => esc_html__('Not found', 'eventin'),
            'not_found_in_trash'    => esc_html__('Not found in Trash', 'eventin'),
            'featured_image'        => esc_html__('Featured Image', 'eventin'),
            'set_featured_image'    => esc_html__('Set featured image', 'eventin'),
            'remove_featured_image' => esc_html__('Remove featured image', 'eventin'),
            'use_featured_image'    => esc_html__('Use as featured image', 'eventin'),
            'insert_into_item'      => esc_html__('Insert into Zoom meeting', 'eventin'),
            'uploaded_to_this_item' => esc_html__('Uploaded to this Zoom meeting', 'eventin'),
            'items_list'            => esc_html__('Zoom meeting list', 'eventin'),
            'items_list_navigation' => esc_html__('Zoom meeting list navigation', 'eventin'),
            'filter_items_list'     => esc_html__('Filter froms list', 'eventin'),
        );
        $rewrite = array(
            'slug'                  => apply_filters('etn_zoom_meeting_slug', $options['etn_zoom_meeting_slug']),
            'with_front'            => true,
            'pages'                 => true,
            'feeds'                 => false,
        );
        $args = array(
            'label'                 => esc_html__('Zoom meeting', 'eventin'),
            'description'           => esc_html__('Zoom meeting', 'eventin'),
            'labels'                => $labels,
            'supports'              => array('title', 'editor', 'thumbnail'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => 'etn-events-manager',
            'menu_icon'             => 'dashicons-text-page',
            'menu_position'         => 1,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => true,
            'can_export'            => false,
            'has_archive'           => true,
            'publicly_queryable'    => true,
            'rewrite'               => $rewrite,
            'query_var'             => true,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            'show_in_rest'          => true,
            'rest_base'             => $this->get_name(),
        );

        return $args;
    }

    // Operation custom post type
    public function flush_rewrites(){
        $name = $this->get_name();
        $args = $this->post_type();
        register_post_type($name, $args);
        flush_rewrite_rules();
    }

    private function user_modifiable_option(){
        $settings_options = get_option('etn_zoom_meeting_options');

        $options = [
            'etn_zoom_meeting_singular_name' => 'Zoom meeting',
            'etn_zoom_meeting_all'            => 'Zoom meetings',
            'etn_zoom_meeting_slug'           => 'etn-zoom-meeting',
            'etn_zoom_meeting_exclude_from_search' => true
        ];

        if (isset($settings_options['etn_zoom_meeting_singular_name']) && $settings_options['etn_zoom_meeting_singular_name'] != '') {
            $options['etn_zoom_meeting_singular_name'] = $settings_options['etn_zoom_meeting_singular_name'];
        }
        if (isset($settings_options['etn_zoom_meeting_all']) && $settings_options['etn_zoom_meeting_all'] != '') {
            $options['etn_zoom_meeting_all'] = $settings_options['etn_zoom_meeting_all'];
        }
        if (isset($settings_options['etn_zoom_meeting_slug']) && $settings_options['etn_zoom_meeting_slug'] != '') {
            $options['etn_zoom_meeting_slug'] = $settings_options['etn_zoom_meeting_slug'];
        }
        if (isset($settings_options['etn_zoom_meeting_exclude_from_search']) && $settings_options['etn_zoom_meeting_exclude_from_search'] != '') {
            $options['etn_zoom_meeting_exclude_from_search'] = (bool) $settings_options['etn_zoom_meeting_exclude_from_search'];
        }

        return $options;
    }
}
