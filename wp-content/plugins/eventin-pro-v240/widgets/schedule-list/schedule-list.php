<?php

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use \Etn_Pro\Utils\Helper;

defined( 'ABSPATH' ) || exit;

// Exit if accessed directly

/**
 * @since 1.1.0
 */
class Etn_Pro_Schedule_List extends Widget_Base {

    /**
     * Retrieve the widget name.
     * @return string Widget name.
     */
    public function get_name() {
        return 'etn-schedule-list-pro';
    }

    /**
     * Retrieve the widget title.
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Eventin Schedule List Pro', 'eventin-pro' );
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
                'label' => esc_html__( 'Schedule List pro', 'eventin-pro' ),
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
                'label'   => esc_html__( 'Schedule', 'eventin-pro' ),
                'type'    => Controls_Manager::SELECT2,
                'options' => $this->get_schedules(),
            ]
        );

        $this->add_control(
            'show_desc',
            [
                'label'     => esc_html__( 'Show Description', 'eventin-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Yes', 'eventin-pro' ),
                'label_off' => esc_html__( 'No', 'eventin-pro' ),
                'default'   => 'yes',
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

        // Start of title section
        $this->start_controls_section(
            'Head_style',
            [
                'label'     => esc_html__( 'Head style', 'eventin-pro' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['schedule_style' => ['schedule-1']],
            ]
        );
        //control for head typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'schedule_title_typography',
                'label'    => esc_html__( 'Title Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .schedule-head-title',
            ]
        );

        $this->add_control(
            'schedule_title_color',
            [
                'label'     => esc_html__( 'color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .schedule-header' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'schedule_head_bg_color',
            [
                'label'     => esc_html__( 'background color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .schedule-header' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        //control for head typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'schedule_date_typography',
                'label'    => esc_html__( 'Date Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .schedule-head-date',
            ]
        );
        $this->add_responsive_control(
            'schedule_title_padding',
            [
                'label'      => esc_html__( 'Padding', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .schedule-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'schedule_title_margin',
            [
                'label'      => esc_html__( 'Margin', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .schedule-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End of head section

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
                'label'     => esc_html__( 'Description style', 'eventin-pro' ),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['show_desc' => 'yes'],

            ]
        );
        //control for desc typography
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
        $this->add_responsive_control(
            'timer_padding',
            [
                'label'      => esc_html__( 'Padding', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-schedule-info .etn-schedule-time' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}}  .etn-schedule-location',
            ]
        );

        $this->add_control(
            'location_color',
            [
                'label'     => esc_html__( 'Location Color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}  .etn-schedule-location' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'location_margin',
            [
                'label'      => esc_html__( 'Margin', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-schedule-location' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'label'     => esc_html__( 'Title Color', 'eventin-pro' ),
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
                'label'    => esc_html__( 'Title Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}}  .etn-schedule-speaker-title',
            ]
        );

        $this->add_control(
            'speake_designation_color',
            [
                'label'     => esc_html__( 'Designation Color', 'eventin-pro' ),
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
                'label'    => esc_html__( 'Designation Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}}  .etn-schedule-speaker-designation',
            ]
        );

        $this->add_responsive_control(
            'speaker_img_border_radius',
            [
                'label'      => esc_html__( 'Image Border Radius', 'eventin-pro' ),
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
                'label'      => esc_html__( 'Content Margin', 'eventin-pro' ),
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
                'label'      => esc_html__( 'Content Padding', 'eventin-pro' ),
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
        $this->add_responsive_control(
            'full_box_padding',
            [
                'label'      => esc_html__( 'Box Padding', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'condition'  => ['schedule_style' => ['schedule-1']],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-schedule-wrap' => 'Padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'box_shadow',
                'label'     => esc_html__( 'Box Shadow', 'eventin-pro' ),
                'selector'  => '{{WRAPPER}} .etn-schedule-wrap',
                'condition' => ['schedule_style' => ['schedule-1']],
            ]
        );
        $this->end_controls_section();
        // End of location section

    }

    protected function render() {
        $settings = $this->get_settings();
        $style    = $settings["schedule_style"];

        $schedule_id    = $settings["schedule_id"];
        $show_speaker   = $settings["show_speaker"];
        $show_location  = $settings["show_location"];
        $show_desc      = $settings["show_desc"];
        $show_time_duration = $settings["show_time_duration"];
        $col            = ($show_speaker == 'yes') ? 'etn-col-lg-6' : 'etn-col-lg-9';

        include ETN_PRO_DIR . "/widgets/schedule-list/style/{$style}.php";
    }

    protected function get_schedules() {
        return Helper::get_schedules();
    }
}
