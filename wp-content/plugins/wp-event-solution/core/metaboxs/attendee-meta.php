<?php

namespace Etn\Core\Metaboxs;
use \Etn\Utils\Helper;

defined( 'ABSPATH' ) || exit;

class Attendee_Meta extends Event_manager_metabox {

    public $metabox_id              = 'etn_attendee_meta';
    public $default_attendee_fields = [];
    public $cpt_id                  = 'etn-attendee';

    public function register_meta_boxes() {

        add_meta_box( $this->metabox_id, esc_html__( 'Attendee Details', 'eventin' ), [$this, 'display_callback'], $this->cpt_id );

    }

    public function etn_attendee_meta_fields() {

        $default_attendee_fields = [];
        $settings          = Helper::get_settings();
        $include_phone     = !empty( $settings["reg_require_phone"] ) ? true : false;
        $include_email     = !empty( $settings["reg_require_email"] ) ? true : false;

        if( $include_email ){
            $default_attendee_fields['etn_email']   = [
                'label' => esc_html__( 'Email', 'eventin' ),
                'type'  => 'email',
                'value' => '',
                'desc'  => esc_html__( 'Enter Attendee Email Address', 'eventin' ),
                'attr'  => ['class' => 'etn-label-item'],
            ];
        }
        if( $include_phone ){
            $default_attendee_fields['etn_phone']   = [
                'label' => esc_html__( 'Phone', 'eventin' ),
                'type'  => 'text',
                'value' => '',
                'desc'  => esc_html__( 'Enter Attendee Phone Number', 'eventin' ),
                'attr'  => ['class' => 'etn-label-item'],
            ];
        }
        $default_attendee_fields['etn_attendeee_ticket_status'] = [
            'label'    => esc_html__( 'Status', 'eventin' ),
            'desc'     => esc_html__( 'Attendee ticket status', 'eventin' ),
            'type'     => 'select_single',
            'options'  => [
                'unused' => esc_html__( 'Unused', 'eventin' ),
                'used' => esc_html__( 'Used', 'eventin' ),
            ],
            'priority' => 1,
            'attr'     => ['class' => 'etn-label-item'],
        ];

        $this->default_attendee_fields = apply_filters( 'etn_attendee_fields', $default_attendee_fields );

        return $this->default_attendee_fields;
    }

}
