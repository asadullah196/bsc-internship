<?php

namespace Etn_Pro\Core\Metaboxs;

defined( 'ABSPATH' ) || exit;

use Etn\Core\Metaboxs\Event_manager_metabox;

class Event_meta extends Event_manager_metabox {

    use \Etn\Traits\Singleton;

    public $metabox_id   = 'etn_event_settings';
    public $text_domain  = 'eventin-pro';
    public $event_fields = [];
    public $cpt_id       = 'etn';

    /**
     * Call all hooks
     */
    public function init() {
        add_filter( "etn_event_fields", [$this, "update_event_meta"] );
        add_filter( "etn/metaboxs/etn_metaboxs", [$this, "register_meta_boxes"] );
        add_filter( "etn/banner_fields/etn_metaboxs", [$this, "update_banner_meta"], 9 );
    }

    /**
     * Add metaboxes
     */
    public function register_meta_boxes() {
        return [
            'meta_id'  => 'banner_settings',
            'name'     => 'Banner Settings',
            'callback' => 'banner_item_display',
            'cpt_name' => 'etn',
        ];
    }

    /**
     * Add extra field to event form
     *
     */
    public function update_event_meta( $metabox_fields ) {

        if( !empty( \Etn_Pro\Utils\Helper::get_option( "attendee_registration" ) ) ){
            $metabox_fields["attende_page_link"] = [
                'label'    => esc_html__( 'Attendee Page URL', 'eventin-pro' ),
                'desc'     => esc_html__( 'Page link where the details of the attendees of this event is located. You can use shortcode / widget to create a specific page and use that link here', 'eventin-pro' ),
                'type'     => 'text',
                'default'  => '',
                'value'    => '',
                'priority' => 1,
                'required' => true,
                'attr'     => ['class' => 'etn-label-item'],
            ];
        }

        $metabox_fields['etn_event_logo'] = [
            'label'    => esc_html__( 'Event logo', 'eventin-pro' ),
            'type'     => 'upload',
            'multiple' => true,
            'default'  => '',
            'value'    => '',
            'desc'     => esc_html__( 'Event logo will be shown on single page', "eventin-pro" ),
            'priority' => 1,
            'required' => false,
            'attr'     => ['class' => ' banner etn-label-item'],
        ];

        $metabox_fields['etn_event_faq'] = [
            'label'    => esc_html__( 'Event FAQ\'s', 'eventin-pro' ),
            'type'     => 'repeater',
            'default'  => '',
            'value'    => '',
            'options'  => [
                'etn_faq_title'   => [
                    'label'    => esc_html__( 'FAQ Title', 'eventin-pro' ),
                    'type'     => 'text',
                    'default'  => '',
                    'value'    => '',
                    'desc'     => '',
                    'priority' => 1,
                    'attr'     => ['class' => ''],
                    'required' => true,
                ],
                'etn_faq_content' => [
                    'label'    => esc_html__( 'FAQ Content', 'eventin-pro' ),
                    'type'     => 'textarea',
                    'default'  => '',
                    'value'    => '',
                    'desc'     => '',
                    'attr'     => [
                        'class' => 'schedule',
                        'row'   => 14,
                        'col'   => 50,
                    ],
                    'required' => true,
                ],
            ],
            'desc'     => esc_html__( 'Add all frequently asked questions here', "eventin-pro" ),
            'attr'     => ['class' => ''],
            'priority' => 1,
            'required' => true,
        ];
        return $metabox_fields;
    }

    /**
     * Add extra field to banner form
     *
     */
    public function update_banner_meta( $metabox_fields ) {

        $metabox_fields['alignment'] = [
            'label'        => esc_html__( 'Alignment', 'eventin-pro' ),
            'desc'         => esc_html__( 'Define banner title postion.', 'eventin-pro' ),
            'type'         => 'checkbox',
            'left_choice'  => 'Default',
            'right_choice' => 'Left',
            'attr'         => ['class' => 'etn-label-item'],
        ];
        $metabox_fields['etn_banner'] = [
            'label'        => esc_html__( 'Banner', 'eventin-pro' ),
            'desc'         => esc_html__( 'Place banner to event page. Banner will be displayed in Event template 2 and template 3.', 'eventin-pro' ),
            'type'         => 'checkbox',
            'left_choice'  => 'Show',
            'right_choice' => 'Hide',
            'attr'         => ['class' => 'etn-label-item'],
        ];
        $metabox_fields['banner_bg_type'] = [
            'label'        => esc_html__( 'Background type', 'eventin-pro' ),
            'desc'         => esc_html__( 'Choose background type text or image', 'eventin-pro' ),
            'type'         => 'checkbox',
            'left_choice'  => 'Color',
            'right_choice' => 'Image',
            'attr'         => ['class' => 'etn-label-item banner_bg_type'],
        ];
        $metabox_fields['banner_bg_color'] = [
            'label'         => esc_html__( 'Background color', 'eventin-pro' ),
            'desc'          => esc_html__( 'Choose background color of banner', 'eventin-pro' ),
            'type'          => 'color_picker',
            'default-color' => '#FF55FF',
            'attr'          => ['class' => 'etn-label-item banner_bg_color'],
        ];
        $metabox_fields['banner_bg_image'] = [
            'label' => esc_html__( 'Background image', 'eventin-pro' ),
            'desc'  => esc_html__( 'Choose background image of banner', 'eventin-pro' ),
            'type'  => 'upload',
            'attr'  => ['class' => 'etn-label-item'],
        ];
        return $metabox_fields;
    }

}
