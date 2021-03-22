<?php

namespace Etn\Core\Metaboxs;

defined( 'ABSPATH' ) || exit;

class Speaker_meta extends Event_manager_metabox {
    
    public $metabox_id   = 'etn_speaker_settings';
    public $event_fields = [];
    public $cpt_id       = 'etn-speaker';

    /**
     * Register meta box for meta speaker post type
     *
     * @return void
     */
    public function register_meta_boxes() {
        add_meta_box( $this->metabox_id, esc_html__( 'Speaker info', 'eventin' ), [$this, 'display_callback'], $this->cpt_id );
    }

    /**
     * Input fields array for speaker meta
     *
     * @return void
     */
    public function etn_speaker_meta_fields() {
        $default_fields = [
            'etn_speaker_title'         => [
                'label'    => esc_html__( 'Name', 'eventin' ),
                'type'     => 'text',
                'default'  => '',
                'value'    => '',
                'desc'     => esc_html__( 'Name of speaker', 'eventin' ),
                'priority' => 1,
                'attr'     => ['class' => 'etn-label-item'],
                'required' => true,
            ],
            'etn_speaker_designation'   => [
                'label'    => esc_html__( 'Designation', 'eventin' ),
                'type'     => 'text',
                'default'  => '',
                'value'    => '',
                'desc'     => esc_html__( 'Speaker designation', "eventin" ),
                'priority' => 1,
                'attr'     => ['class' => 'etn-label-item'],
                'required' => true,
            ],
            'etn_speaker_website_email' => [
                'label'    => esc_html__( 'Email', 'eventin' ),
                'type'     => 'email',
                'default'  => '',
                'value'    => '',
                'desc'     => esc_html__( 'Email address of speaker', "eventin" ),
                'attr'     => ['class' => 'etn-label-item'],
                'priority' => 1,
                'required' => true,
            ],
            'etn_speaker_summery'       => [
                'label'    => esc_html__( 'Summary', 'eventin' ),
                'type'     => 'textarea',
                'default'  => '',
                'value'    => '',
                'desc'     => esc_html__( 'Write about speaker', "eventin" ),
                'priority' => 1,
                'attr'     => ['class' => 'etn-label-item'],
                'required' => true,
            ],
            'etn_speaker_socials'       => [
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
                'desc'     => esc_html__( 'Social link of speaker', "eventin" ),
                'attr'     => ['class' => 'etn-label-item'],
                'priority' => 1,
                'required' => true,
            ],
            'etn_speaker_company_logo'  => [
                'label'    => esc_html__( 'Company logo', 'eventin' ),
                'type'     => 'upload',
                'multiple' => true,
                'default'  => '',
                'value'    => '',
                'desc'     => esc_html__( 'Company logo will be shown for organizer ', "eventin" ),
                'priority' => 1,
                'required' => false,
                'attr'     => ['class' => ' banner etn-label-item'],
            ],

        ];
        $this->event_fields = apply_filters( 'etn_speaker_fields', $default_fields );

        return $this->event_fields;
    }

    public function banner_meta_field() {
        return [];
    }

    /**
     * Override speaker title from speaker post meta
     *
     * @param [type] $data
     * @param [type] $postarr
     * @return void
     */
    public function etn_set_speaker_title( $data, $postarr ) {

        if ( 'etn-speaker' == $data['post_type'] ) {

            if ( isset( $postarr['etn_speaker_title'] ) ) {
                $speaker_title = sanitize_text_field( $postarr['etn_speaker_title'] );
            } else {
                $speaker_title = get_post_meta( $postarr['ID'], 'etn_speaker_title', true );
            }

            $post_slug    = sanitize_title_with_dashes( $speaker_title, '', 'save' );
            $speaker_slug = sanitize_title( $post_slug );

            $data['post_title'] = $speaker_title;
            $data['post_name']  = $speaker_slug;
        }

        return $data;
    }

}
