<?php

namespace Etn_Pro\Core\Metaboxs;

defined( 'ABSPATH' ) || exit;

use Etn\Core\Metaboxs\Event_manager_metabox;

class Speaker_meta extends Event_manager_metabox {

    use \Etn\Traits\Singleton;

    public $metabox_id   = 'etn_speaker_settings1';
    public $event_fields = [];
    public $cpt_id       = 'etn-speaker';

    /**
     * Call all hooks
     *
     * @return void
     */
    public function init() {
        add_filter( "etn_speaker_fields", [$this, "update_speaker_meta"] );
    }

    /**
     * add new field function
     *
     */
    public function update_speaker_meta( $metabox_fields ) {
        $metabox_fields['etn_speaker_url'] = [
            'label'    => esc_html__( 'Company Url', 'eventin-pro' ),
            'desc'     => esc_html__('Provide speaker / company site link', "eventin-pro"),
            'type'     => 'url',
            'default'  => '',
            'value'    => '',
            'priority' => 1,
            'attr'     => ['class' => 'etn-label-item'],
            'required' => true,
        ];
        
        return $metabox_fields;
    }
}
