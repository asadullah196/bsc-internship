<?php

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use \Etn_Pro\Utils\Helper;

defined( 'ABSPATH' ) || exit;

/**
 * @since 1.1.0
 */
class Etn_Pro_Schedule_Tab extends Widget_Base {

    /**
     * Retrieve the widget name.
     * @return string Widget name.
     */
    public function get_name() {
        return 'etn-schedule-tab-pro';
    }

    /**
     * Retrieve the widget title.
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Eventin Schedule Tab Pro', 'eventin-pro' );
    }

    /**
     * Retrieve the widget icon.
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-post-list';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     * Used to determine where to display the widget in the editor.
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['etn-event'];
    }

    protected function _register_controls() {
        // Start of schedule section
        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__( 'Schedule Tab pro', 'eventin-pro' ),
            ]
        );
        $this->add_control(
            'schedule_style',
            [
                'label'   => esc_html__( 'Schedule Style', 'eventin-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'schedule-1',
                'options' => [
                    'schedule-1' => esc_html__( 'Schedule 1', 'eventin-pro' ),
                    'schedule-2' => esc_html__( 'Schedule 2', 'eventin-pro' ),
                ],
            ]
        );
        $this->add_control(
            'schedule_id',
            [
                'label'    => esc_html__( 'Schedule', 'eventin-pro' ),
                'type'     => Controls_Manager::SELECT2,
                'multiple' => true,
                'options'  => $this->get_schedules(),
            ]
        );
        $this->add_control(
            'etn_schedule_order',
            [
                'label'   => esc_html__( 'Schedule order', 'eventin-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => esc_html__( 'Descending', 'eventin-pro' ),
                    'ASC'  => esc_html__( 'Ascending', 'eventin-pro' ),
                ],
            ]
        );
        $this->add_control(
            'show_speaker',
            [
                'label'     => esc_html__( 'Show Speaker', 'eventin-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Yes', 'eventin-pro' ),
                'label_off' => esc_html__( 'No', 'eventin-pro' ),
                'default'   => 'yes',
            ]
        );

        $this->add_control(
            'show_location',
            [
                'label'     => esc_html__( 'Show Location', 'eventin-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Yes', 'eventin-pro' ),
                'label_off' => esc_html__( 'No', 'eventin-pro' ),
                'default'   => 'yes',
            ]
        );
        $this->add_control(
            'show_time_duration',
            [
                'label'     => esc_html__( 'Show Time Duration', 'eventin-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Yes', 'eventin-pro' ),
                'label_off' => esc_html__( 'No', 'eventin-pro' ),
                'default'   => 'yes',
            ]
        );
        $this->end_controls_section();
        // End of schedule section

        // Start of nav section
        $this->start_controls_section(
            'nav_style',
            [
                'label' => esc_html__( 'Nav style', 'eventin-pro' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'nav_align',
            [
                'label'     => esc_html__( 'Alignment', 'eventin-pro' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [

                    'left'    => [
                        'title' => esc_html__( 'Left', 'eventin-pro' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__( 'Center', 'eventin-pro' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'   => [
                        'title' => esc_html__( 'Right', 'eventin-pro' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'eventin-pro' ),
                        'icon'  => 'fa fa-align-justify',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .schedule-tab-wrapper .etn-nav' => 'text-align: {{VALUE}};',
                ],
            ]
        );
        //Responsive control end

        //control for nav typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_nav_typography',
                'label'    => esc_html__( 'Nav Title Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .etn-nav li a',
            ]
        );

        //control for nav typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_nav_sub_typography',
                'label'    => esc_html__( 'Nav Sub Title Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .schedule-tab-wrapper .etn-nav li a .etn-day',
            ]
        );

        //start of nav color tabs (normal and hover)
        $this->start_controls_tabs(
            'etn_nav_tabs'
        );

        //start of nav normal color tab
        $this->start_controls_tab(
            'etn_nav_normal_tab',
            [
                'label' => esc_html__( 'Normal', 'eventin-pro' ),
            ]
        );

        $this->add_control(
            'etn_nav_color',
            [
                'label'     => esc_html__( 'Nav Title Color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-nav li a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'etn_nav_sub_color',
            [
                'label'     => esc_html__( 'Nav Subtitle color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .schedule-tab-wrapper .etn-nav li a .etn-day' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'nav_background',
                'label'    => esc_html__( 'Background', 'eventin-pro' ),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .etn-nav li a',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'nav_border',
                'label'    => esc_html__( 'Border', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .etn-nav li a',
            ]
        );
        $this->add_responsive_control(
            'nav_padding',
            [
                'label'      => esc_html__( 'Padding', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-nav li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        //end of nav normal color tab

        //start of nav active color tab
        $this->start_controls_tab(
            'etn_nav_active_tab',
            [
                'label' => esc_html__( 'Active', 'eventin-pro' ),
            ]
        );
        $this->add_control(
            'etn_nav_active_color',
            [
                'label'     => esc_html__( 'Nav active color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-nav li a.etn-active'                  => 'color: {{VALUE}};',
                    '{{WRAPPER}} .schedule-tab-wrapper .etn-nav li a:after' => 'border-color: {{VALUE}} transparent transparent transparent;',
                ],
            ]
        );
        $this->add_control(
            'etn_nav_sub_active_color',
            [
                'label'     => esc_html__( 'Nav Subtitle Active color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .schedule-tab-wrapper .etn-nav li a.etn-active .etn-day' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'etn_nav_angle_active_color',
            [
                'label'     => esc_html__( 'Nav Angle Active color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .schedule-tab-wrapper .etn-nav li a:after' => 'border-color: {{VALUE}}  transparent transparent transparent;',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'nav_active_background',
                'label'    => esc_html__( 'Active Background', 'eventin-pro' ),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .etn-nav li a.etn-active',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'nav_borderactive',
                'label'    => esc_html__( 'Border active', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .etn-nav li a.etn-active',
            ]
        );
        $this->add_responsive_control(
            'nav_active_padding',
            [
                'label'      => esc_html__( 'Padding', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-nav li a.etn-active' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        //end of nav hover color tab

        $this->end_controls_tabs();
        //end of nav color tabs (normal and hover)

        $this->add_responsive_control(
            'nav_margin',
            [
                'label'      => esc_html__( 'Margin', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-nav li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'nav_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-nav li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End of nav section

        // Start of title section
        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__( 'Title style', 'eventin-pro' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        //control for nav typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_title_typography',
                'label'    => esc_html__( 'Title Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .etn-schedule-content .etn-title',
            ]
        );

        $this->add_control(
            'etn_title_color',
            [
                'label'     => esc_html__( 'Title color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-schedule-content .etn-title' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}}  .etn-schedule-content .etn-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End of title section

        // Start of title section
        $this->start_controls_section(
            'desc_style',
            [
                'label' => esc_html__( 'Description style', 'eventin-pro' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        //control for nav typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_desc_typography',
                'label'    => esc_html__( 'Desc Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .etn-schedule-content p',
            ]
        );

        $this->add_control(
            'etn_desc_color',
            [
                'label'     => esc_html__( 'Desc color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-schedule-content p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'desc_margin',
            [
                'label'      => esc_html__( 'Margin', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-schedule-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End of desc section

        // Start of time section
        $this->start_controls_section(
            'schedule_time_style',
            [
                'label'     => esc_html__( 'Schedule Time style', 'eventin-pro' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['show_time_duration' => 'yes'],
            ]
        );
        //control typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_schedule_time_typography',
                'label'    => esc_html__( 'Schedule Time Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}}  .etn-schedule-info .etn-schedule-time',
            ]
        );

        $this->add_control(
            'etn_schedule_time_color',
            [
                'label'     => esc_html__( 'Schedule Time Color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-schedule-info .etn-schedule-time' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'etn_schedule_time__bgcolor',
            [
                'label'     => esc_html__( 'Schedule Time BG Color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-schedule-info .etn-schedule-time' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End of time section

        // Start of location section
        $this->start_controls_section(
            'location_style',
            [
                'label'     => esc_html__( 'Location style', 'eventin-pro' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['show_location' => 'yes'],
            ]
        );
        //control typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_schedule_location_typography',
                'label'    => esc_html__( 'location Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}}  .etn-schedule-info .etn-schedule-location',
            ]
        );

        $this->add_control(
            'location_color',
            [
                'label'     => esc_html__( 'Location Color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-schedule-info .etn-schedule-location' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();
        // End of location section

        // Start of speaker section
        $this->start_controls_section(
            'speaker_style',
            [
                'label'     => esc_html__( 'Speaker style', 'eventin-pro' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['show_speaker' => 'yes'],
            ]
        );

        $this->add_control(
            'speaker_title_color',
            [
                'label'     => esc_html__('Title Color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-schedule-speaker-title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'speaker_title_typography',
                'label'    => esc_html__('Title Typography', 'eventin-pro'),
                'selector' => '{{WRAPPER}}  .etn-schedule-speaker-title',
            ]
        );

        $this->add_control(
            'speake_designation_color',
            [
                'label'     => esc_html__('Designation Color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-schedule-speaker-designation' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'speaker_designation_typography',
                'label'    => esc_html__('Designation Typography', 'eventin-pro'),
                'selector' => '{{WRAPPER}}  .etn-schedule-speaker-designation',
            ]
        );

        $this->add_responsive_control(
            'speaker_img_border_radius',
            [
                'label'      => esc_html__('Image Border Radius', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-schedule-single-speaker img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        // End of location section

        // Start of accrodion icon section
        $this->start_controls_section(
            'accordion_icon_style',
            [
                'label'     => esc_html__( 'Accordion Icon style', 'eventin-pro' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['schedule_style' => ['schedule-2']],
            ]
        );
        $this->add_control(
            'acc_icon_color',
            [
                'label'     => esc_html__( 'Icon Color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .schedule-tab-2 .etn-accordion-heading i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'acc_icon_bg_color',
            [
                'label'     => esc_html__( 'Icon Background Color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .schedule-tab-2 .etn-accordion-heading i' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End of icon section

        // Start of advance section
        $this->start_controls_section(
            'advance_style',
            [
                'label' => esc_html__( 'Advance style', 'eventin-pro' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name'     => 'box_background',
                'label'    => esc_html__( 'Background', 'eventin-pro' ),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .etn-single-schedule-item',
            ]
        );

        $this->add_responsive_control(
            'box_margin',
            [
                'label'      => esc_html__( 'Margin', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-single-schedule-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'box_padding',
            [
                'label'      => esc_html__( 'Padding', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-single-schedule-item' => 'Padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'box_border',
                'label'    => esc_html__( 'Border', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .etn-single-schedule-item',
            ]
        );
        $this->add_responsive_control(
            'box_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-single-schedule-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
        // End of location section

    }

    protected function render() {
        $settings = $this->get_settings();
        $style    = $settings["schedule_style"];

        $etn_schedule_order = $settings["etn_schedule_order"];
        $schedule_ids = $settings["schedule_id"];
        $show_speaker = $settings["show_speaker"];
        $show_location = $settings["show_location"];
        $show_time_duration = $settings["show_time_duration"];
        $col = ($show_speaker == 'yes') ? 'etn-col-lg-6' : 'etn-col-lg-9';
        $event_options = get_option("etn_event_options");
        $order = isset($etn_schedule_order) ? $etn_schedule_order : 'DESC';
        $widget_id = $this->get_id();
        include ETN_PRO_DIR . "/widgets/schedule-tab/style/{$style}.php";
    }

    protected function get_schedules() {
        return Helper::get_schedules();
    }
}
