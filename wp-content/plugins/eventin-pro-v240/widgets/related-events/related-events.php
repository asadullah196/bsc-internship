<?php

namespace Elementor;

use Elementor\Widget_Base;
use Etn_Pro\Utils\Helper;

defined( "ABSPATH" ) || die();

class Etn_Pro_Related_Events extends Widget_Base {

    public function get_categories() {
        return ['etn-event'];
    }

    public function get_name() {
        return "etn-related-events";
    }

    public function get_title() {
        return esc_html__( "Related Events Pro", "eventin-pro" );
    }

    public function get_icon() {
        return "eicon-sort-amount-desc";
    }

    public function _register_controls() {
        $this->start_controls_section(
            "section_tab",
            [
                "label" => esc_html__( "Related Events" ),
            ]
        );

        $this->add_control(
            "event_id",
            [
                "label"    => esc_html__( "Select Event Id", "eventin-pro" ),
                "type"     => Controls_Manager::SELECT2,
                "multiple" => false,
                "options"  => Helper::get_events(),
            ]
        );

        $this->add_control(
            "column",
            [
                "label"     => esc_html__("Event Column", "eventin-pro"),
                "type"      => Controls_Manager::SELECT2,
                "multiple"  => false,
                "default"   => "4",
                'options'   => [
                    '3'  => esc_html__('4 Column ', 'eventin-pro'),
                    '4'  => esc_html__('3 Column', 'eventin-pro'),
                    '6'  => esc_html__('2 Column', 'eventin-pro'),
                    '12' => esc_html__('1 Column', 'eventin-pro'),

                ],
            ]
        );
        $this->add_control(
            "title",
            [
                "label" => esc_html__("Set label", "eventin-pro"),
                "default" => esc_html__("Related Events", "eventin-pro"),
            ]
        );

        $this->end_controls_section();
    }

    public function render() {
        $settings        = $this->get_settings();
        $single_event_id = !empty( $settings['event_id'] ) ? $settings['event_id'] : 0;
        $column          = !empty( $settings['column'] ) ? $settings['column'] : 4;
        $title           = !empty( $settings['title'] ) ? $settings['title'] : esc_html__("Related Events", "eventin-pro");
        $configs         = [
            "column"    => $column,
            "title"     => $title,
        ];

        Helper::related_events_widget( $single_event_id, $configs );
    }

}
