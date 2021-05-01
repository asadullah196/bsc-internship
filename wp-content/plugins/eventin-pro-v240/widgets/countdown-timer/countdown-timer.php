<?php

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use \Etn_Pro\Utils\Helper;

defined( 'ABSPATH' ) || exit;

class Etn_Pro_countdown_Timer extends Widget_Base {

    
    /**
     * Retrieve the widget name.
     * @return string Widget name.
     */
    public function get_name() {
        return 'etn-pro-coundown';
    }

    /**
     * Retrieve the widget title.
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Eventin  countdown Pro', 'eventin-pro' );
    }

    /**
     * Retrieve the widget icon.
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-countdown';
    }

    /**
     * Retrieve the widget category.
     * @return string Widget category.
     */
    public function get_categories() {
        return ['etn-event'];
    }

    protected function _register_controls() {
        // Start of countdown section
        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__( 'Eventin countdowns Pro', 'eventin-pro' ),
            ]
        );
        $this->add_control(
            'coundwon_style',
            [
                'label'   => esc_html__( 'countdown Style', 'eventin-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'countdown-1',
                'options' => [
                    'countdown-1' => esc_html__( 'countdown 1', 'eventin-pro' ),
                ],
            ]
        );
        $this->add_control(
            'event_id',
            [
                'label'       => esc_html__( 'Select Event', 'eventin-pro' ),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $this->get_events(),
                'label_block' => true,
            ]
        );
        

        $this->add_control(
            'show_seperate_dot',
            [
                'label'     => esc_html__( 'Show Seperate Dot', 'eventin-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Yes', 'eventin-pro' ),
                'label_off' => esc_html__( 'No', 'eventin-pro' ),
                'default'   => 'yes',

            ]
        );
        $this->add_control(
            'show_event_title',
            [
                'label'     => esc_html__( 'Show event Title', 'eventin-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Yes', 'eventin-pro' ),
                'label_off' => esc_html__( 'No', 'eventin-pro' ),
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'justify_content',
            [
                'label'     => esc_html__( 'Justify Content', 'eventin-pro' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => [
                    'space-around'  => esc_html__( 'Space Around', 'eventin-pro' ),
                    'center'        => esc_html__( 'Center', 'eventin-pro' ),
                    'end'           => esc_html__( 'End', 'eventin-pro' ),
                    'start'         => esc_html__( 'Start', 'eventin-pro' ),
                    'flex-start'    => esc_html__( 'Flex Start', 'eventin-pro' ),
                    'flex-end'      => esc_html__( 'Flex End', 'eventin-pro' ),
                    'space-between' => esc_html__( 'Epace Between', 'eventin-pro' ),
                    'space-evenly'  => esc_html__( 'Space Evenly', 'eventin-pro' ),
                ],
                'default'   => 'center',

                'selectors' => [
                    '{{WRAPPER}} .etn-event-countdown-wrap' => 'justify-content: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'content_align',
            [
                'label'     => esc_html__( 'Alignment', 'eventin-pro' ),
                'type'      => \Elementor\Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'eventin-pro' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'eventin-pro' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'eventin-pro' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => 'center',
                'toggle'    => true,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-countdown-wrap' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .event-title'              => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'countdown_day',
            [
                'label'   => esc_html__( 'Day Singular Text', 'eventin-pro' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Day', 'eventin-pro' ),
            ]
        );
        $this->add_control(
            'countdown_days',
            [
                'label'   => esc_html__( 'Day Plural Text', 'eventin-pro' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Days', 'eventin-pro' ),
            ]
        );


        $this->add_control(
            'countdown_hr',
            [
                'label'   => esc_html__( 'Hour Singular Text', 'eventin-pro' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'hr', 'eventin-pro' ),
            ]
        );
        $this->add_control(
            'countdown_hrs',
            [
                'label'   => esc_html__( 'Hour Plural Text', 'eventin-pro' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'hrs', 'eventin-pro' ),
            ]
        );

        $this->add_control(
            'countdown_min',
            [
                'label'   => esc_html__( 'Minut Singular Text', 'eventin-pro' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Min', 'eventin-pro' ),
            ]
        );
        $this->add_control(
            'countdown_mins',
            [
                'label'   => esc_html__( 'Minut Plural Text', 'eventin-pro' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Mins', 'eventin-pro' ),
            ]
        );

        $this->add_control(
            'countdown_sec',
            [
                'label'   => esc_html__( 'Second Singular Text', 'eventin-pro' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Sec', 'eventin-pro' ),
            ]
        );
        $this->add_control(
            'countdown_secs',
            [
                'label'   => esc_html__( 'Second Plural Text', 'eventin-pro' ),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__( 'Secs', 'eventin-pro' ),
            ]
        );
        $this->end_controls_section();

        // Start of title section
        $this->start_controls_section(
            'event_title_style',
            [
                'label'     => esc_html__( ' Event Title Style', 'eventin-pro' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['show_event_title' => 'yes'],
            ]
        );
        //control for title typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'event_title_typography',
                'label'    => esc_html__( 'Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .event-title',
            ]
        );

        $this->add_control(
            'event_title_color',
            [
                'label'     => esc_html__( 'color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .event-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__( 'Margin', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .event-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End of title section

        // Start of count section
        $this->start_controls_section(
            'count_style',
            [
                'label' => esc_html__( ' Count Style', 'eventin-pro' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        //control for count typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'count_typography',
                'label'    => esc_html__( 'Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .etn-event-countdown-wrap .etn-count-item',
            ]
        );

        $this->add_control(
            'count_color',
            [
                'label'     => esc_html__( 'Count color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-countdown-wrap .etn-count-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End of count section

        // Start of seperate section
        $this->start_controls_section(
            'date_seperate_style',
            [
                'label'     => esc_html__( ' Seperate Dot Style', 'eventin-pro' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['show_seperate_dot' => 'yes'],
            ]
        );
        //control for count typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'dot_typography',
                'label'    => esc_html__( 'Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .date-seperate',
            ]
        );

        $this->add_control(
            'dot_color',
            [
                'label'     => esc_html__( 'color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .date-seperate' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End of dot section

        // Start of count section
        $this->start_controls_section(
            'count_text_style',
            [
                'label' => esc_html__( ' Count Text Style', 'eventin-pro' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        //control for count typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'count_text_typography',
                'label'    => esc_html__( 'Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .etn-event-countdown-wrap .etn-count-item .text',
            ]
        );

        $this->add_control(
            'count_text_color',
            [
                'label'     => esc_html__( 'Count Text color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-countdown-wrap .etn-count-item .text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End of count eext section

        // Start of count section
        $this->start_controls_section(
            'advance',
            [
                'label' => esc_html__( ' Advance Style', 'eventin-pro' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'bos_width',
            [
                'label'      => __( 'Box Min width', 'eventin-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],

                'selectors'  => [
                    '{{WRAPPER}} .etn-count-item' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bos_height',
            [
                'label'      => __( 'Box Min height', 'eventin-pro' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],

                'selectors'  => [
                    '{{WRAPPER}} .etn-count-item' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'background',
                'label'    => esc_html__( 'Background Color', 'eventin-pro' ),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .etn-count-item',
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label'      => esc_html__( 'Padding', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-count-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'box_margin',
            [
                'label'      => esc_html__( 'Margin', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-count-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name'     => 'box_border',
                'label'    => esc_html__( 'Border', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .etn-count-item',
            ]
        );
        $this->add_responsive_control(
            'box_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-count-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End of count eext section

    }

    protected function render() {
        $settings          = $this->get_settings();
        $style             = $settings["coundwon_style"];
        $countdown_id       = $settings["event_id"];

        $countdown_day      = !empty( $settings["countdown_day"] ) ? $settings["countdown_day"] : esc_html__( "day", "eventin-pro" );
        $countdown_days     = !empty( $settings["countdown_days"] ) ? $settings["countdown_days"] : esc_html__( "days", "eventin-pro" );
        $countdown_hr       = !empty( $settings["countdown_hr"] ) ? $settings["countdown_hr"] : esc_html__( "hr", "eventin-pro" );
        $countdown_hrs      = !empty( $settings["countdown_hrs"] ) ? $settings["countdown_hrs"] : esc_html__( "hrs", "eventin-pro" );
        $countdown_min      = !empty( $settings["countdown_min"] ) ? $settings["countdown_min"] : esc_html__( "min", "eventin-pro" );
        $countdown_mins     = !empty( $settings["countdown_mins"] ) ? $settings["countdown_mins"] : esc_html__( "mins", "eventin-pro" );
        $countdown_sec      = !empty( $settings["countdown_sec"] ) ? $settings["countdown_sec"] : esc_html__( "sec", "eventin-pro" );;
        $countdown_secs     = !empty( $settings["countdown_secs"] ) ? $settings["countdown_secs"] : esc_html__( "secs", "eventin-pro" );;
        $show_seperate_dot  = empty( $settings["show_seperate_dot"] ) ? false : true;
        $show_event_title   = $settings["show_event_title"];
        $event_id       = $settings["event_id"];
        $etn_start_date = get_post_meta( $event_id, 'etn_start_date', true );
        $etn_start_time = get_post_meta( $event_id, 'etn_start_time', true );
        $date_texts     = [
            'day'  => $countdown_day,
            'days' => $countdown_days,
            'hr'   => $countdown_hr,
            'hrs'  => $countdown_hrs,
            'min'  => $countdown_min,
            'mins' => $countdown_mins,
            'sec'  => $countdown_sec,
            'secs' => $countdown_secs,
        ];
        $counter_start_time = date_i18n( "m/d/Y", strtotime( $etn_start_date ) ) . " " . date_i18n( "H:i:s", strtotime( $etn_start_time ) );

        include ETN_PRO_DIR . "/widgets/countdown-timer/style/{$style}.php";
    }

    protected function get_events() {
        return Helper::get_events();
    }
}
