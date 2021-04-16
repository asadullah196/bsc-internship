<?php

namespace Etn\Core\Metaboxs;

use Etn\Utils\Helper;

defined( 'ABSPATH' ) || exit;

class Event_meta extends Event_manager_metabox {

    public $metabox_id    = 'etn_event_settings';
    public $event_fields  = [];
    public $cpt_id        = 'etn';
    public $banner_fields = [];
    public $text_domain   = 'eventin';

    public function register_meta_boxes() {
        
        add_meta_box( $this->metabox_id, esc_html__( 'Eventin Event Settings', 'eventin' ), [$this, 'display_callback'], $this->cpt_id );
        $all_boxes = apply_filters( 'etn/metaboxs/etn_metaboxs', false );
        $instance  = !empty( $all_boxes["instance"] ) ? $all_boxes["instance"] : $this;

        if ( is_array( $all_boxes ) ) {
            add_meta_box( $all_boxes['meta_id'], esc_html__( $all_boxes['name'], 'eventin' ), [$instance, $all_boxes['callback']], $all_boxes['cpt_name'] );
        }

    }

    /**
     * Input fields array for event meta
     */
    public function etn_meta_fields() {
        $settings = \Etn\Core\Settings\Settings::instance()->get_settings_option();

        $default_fields = [
            'etn_event_location'        => [
                'label'    => esc_html__( 'Event Location', 'eventin' ),
                'desc'     => esc_html__( 'Place event location', 'eventin' ),
                'type'     => 'text',
                'default'  => '',
                'value'    => '',
                'priority' => 1,
                'required' => true,
                'attr'     => ['class' => 'etn-label-item'],
            ],
            'etn_event_schedule'        => [
                'label'    => esc_html__( 'Event Schedule', 'eventin' ),
                'desc'     => esc_html__( 'Select all schedules of this event', 'eventin' ),
                'type'     => 'select2',
                'options'  => Helper::get_schedules(),
                'priority' => 1,
                'required' => true,
                'attr'     => ['class' => 'etn-label-item'],
            ],
            'etn_event_organizer'       => [
                'label'    => esc_html__( 'Organizers', 'eventin' ),
                'desc'     => esc_html__( 'Select organizer', 'eventin' ),
                'type'     => 'select_single',
                'options'  => Helper::get_orgs(),
                'priority' => 1,
                'required' => true,
                'attr'     => ['class' => 'etn-label-item'],
            ],
            'etn_start_date'            => [
                'label'    => esc_html__( 'Start date', 'eventin' ),
                'desc'     => esc_html__( 'Select start date', 'eventin' ),
                'type'     => 'text',
                'default'  => '',
                'value'    => '',
                'priority' => 1,
                'required' => false,
                'attr'     => ['class' => 'etn-label-item'],
            ],

            'etn_start_time'            => [
                'label'    => esc_html__( 'Start time', 'eventin' ),
                'desc'     => esc_html__( 'Select start time', 'eventin' ),
                'type'     => 'time',
                'default'  => '',
                'value'    => '',
                'priority' => 1,
                'required' => false,
                'attr'     => ['class' => 'etn-label-item'],
            ],

            'etn_end_date'              => [
                'label'    => esc_html__( 'End date', 'eventin' ),
                'type'     => 'text',
                'default'  => '',
                'value'    => '',
                'desc'     => esc_html__( 'Select end date', 'eventin' ),
                'priority' => 1,
                'required' => false,
                'attr'     => ['class' => 'etn-label-item'],
            ],

            'etn_end_time'              => [
                'label'    => esc_html__( 'End time', 'eventin' ),
                'type'     => 'time',
                'default'  => '',
                'desc'     => esc_html__( 'Select end time', 'eventin' ),
                'value'    => '',
                'priority' => 1,
                'required' => false,
                'attr'     => ['class' => 'etn-label-item'],
            ],

            'etn_registration_deadline' => [
                'label'    => esc_html__( 'Registration deadline', 'eventin' ),
                'type'     => 'text',
                'default'  => '',
                'desc'     => esc_html__( 'Select registration deadline', 'eventin' ),
                'value'    => '',
                'priority' => 1,
                'required' => false,
                'attr'     => ['class' => 'etn-label-item'],
            ],
        ];

        if( !empty( $settings['sell_tickets'] ) && class_exists('WooCommerce') ){
            $default_fields['_virtual'] = [
                'label'        => esc_html__( 'Virtual Product', 'eventin' ),
                'desc'         => esc_html__( 'Set if you want to register this event as a Woocommerce Virtual Product. It will handle all behaviors related to Woocommerce Virtual Product', "eventin" ),
                'type'         => 'radio',
                'options'       => [
                    'yes'   =>'yes',
                    'no'   =>'no',
                ]
            ];
        }

        if ( !empty( $settings['etn_zoom_api'] ) ) {
            $default_fields['etn_zoom_event'] = [
                'label'        => esc_html__( 'Zoom Event', "eventin" ),
                'desc'         => esc_html__( 'Enable if this event is a zoom event', "eventin" ),
                'type'         => 'checkbox',
                'left_choice'  => 'Yes',
                'right_choice' => 'no',
                'attr'         => ['class' => 'etn-label-item etn-zoom-event'],
                'conditional'  => true,
                'condition-id' => 'etn_zoom_id',
            ];

            $default_fields['etn_zoom_id'] = [
                'label'    => esc_html__( 'Select Meeting', "eventin" ),
                'desc'     => esc_html__( 'Choose zoom meeting for this event', "eventin" ),
                'type'     => 'select_single',
                'options'  => Helper::get_zoom_meetings(),
                'priority' => 1,
                'required' => true,
                'attr'     => ['class' => 'etn-label-item etn-zoom-id'],
            ];
        }

        $default_fields['etn_ticket_availability'] = [
            'label'        => esc_html__( 'Limited Tickets', 'eventin' ),
            'desc'         => esc_html__( 'Set if you want to limit available tickets', "eventin" ),
            'type'         => 'checkbox',
            'left_choice'  => 'limited',
            'right_choice' => 'unlimited',
            'attr'         => ['class' => 'etn-label-item etn-limit-event-ticket'],
            'conditional'  => true,
            'condition-id' => 'etn_avaiilable_tickets',
        ];

        $default_fields['etn_avaiilable_tickets'] = [
            'label'    => esc_html__( 'No. of Tickets', 'eventin' ),
            'type'     => 'number',
            'default'  => '',
            'value'    => '',
            'desc'     => esc_html__( 'Total no of ticket', 'eventin' ),
            'priority' => 1,
            'required' => true,
            'attr'     => ['class' => 'etn-label-item'],
        ];

        $default_fields['etn_ticket_price'] = [
            'label'    => esc_html__( 'Ticket Price', 'eventin' ),
            'type'     => 'number',
            'default'  => '',
            'value'    => '',
            'desc'     => esc_html__( 'Par ticket price', 'eventin' ),
            'priority' => 1,
            'step'     => 0.01,
            'required' => true,
            'attr'     => ['class' => 'etn-label-item'],
        ];

        $default_fields['etn_event_socials'] = [
            'label'    => esc_html__( 'Social', 'eventin' ),
            'type'     => 'social_reapeater',
            'default'  => '',
            'value'    => '',
            'options'  => [
                'facebook' => [
                    'label'      => esc_html__( 'Facebook', 'eventin' ),
                    'icon_class' => '',
                ],
                'twitter'  => [
                    'label'      => esc_html__( 'Twitter', 'eventin' ),
                    'icon_class' => '',
                ],
            ],
            'desc'     => esc_html__( 'Add multiple social icon', 'eventin' ),
            'attr'     => ['class' => ''],
            'priority' => 1,
            'required' => true,
        ];

        $this->event_fields = apply_filters( 'etn_event_fields', $default_fields );

        return $this->event_fields;
    }

    /**
     * Banner meta field function
     */
    public function banner_meta_field() {
        $this->banner_fields = apply_filters( 'etn/banner_fields/etn_metaboxs', [] );

        return $this->banner_fields;
    }

}
