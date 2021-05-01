<?php

namespace Elementor;

defined('ABSPATH') || exit;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use \Etn_Pro\Utils\Helper;

class Etn_Pro_Events_Pro extends Widget_Base
{

    /**
     * Retrieve the widget name.
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'etn-event-pro';
    }

    /**
     * Retrieve the widget title.
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Eventin Events Pro', 'eventin-pro');
    }

    /**
     * Retrieve the widget icon.
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-sort-amount-desc';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     * Used to determine where to display the widget in the editor.
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return ['etn-event'];
    }

    /**
     * Register the widget controls.
     * @access protected
     */
    protected function _register_controls()
    {

        // Start of event section
        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__('Eventin event Pro', 'eventin-pro'),
            ]
        );
        $this->add_control(
            'etn_event_style',
            [
                'label'   => esc_html__('Event Style', 'eventin-pro'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'event-1',
                'options' => [
                    'event-1' => esc_html__('Event 1', 'eventin-pro'),
                    'event-2' => esc_html__('Event 2', 'eventin-pro'),
                    'event-3' => esc_html__('Event 3', 'eventin-pro'),
                    'event-4' => esc_html__('Event 4', 'eventin-pro'),
                ],
            ]
        );
        $this->add_control(
            'etn_event_cat',
            [
                'label'    => esc_html__('Event Category', 'eventin-pro'),
                'type'     => Controls_Manager::SELECT2,
                'options'  => $this->get_event_category(),
                'multiple' => true,
            ]
        );
        $this->add_control(
            'etn_event_tag',
            [
                'label'    => esc_html__( 'Event Tag', 'eventin' ),
                'type'     => Controls_Manager::SELECT2,
                'options'  => $this->get_event_tag(),
                'multiple' => true,
            ]
        );
        $this->add_control(
            'etn_event_count',
            [
                'label'   => esc_html__('Event count', 'eventin-pro'),
                'type'    => Controls_Manager::NUMBER,
                'default' => '6',
            ]
        );
        $this->add_control(
            'etn_show_desc',
            [
                'label'     => esc_html__('Show Description', 'eventin-pro'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('Yes', 'eventin-pro'),
                'label_off' => esc_html__('No', 'eventin-pro'),
                'default'   => 'yes',
            ]
        );
        $this->add_control(
            'etn_desc_limit',
            [
                'label'     => esc_html__('Description Limit', 'eventin-pro'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 20,
                'condition' => ['etn_show_desc' => 'yes'],
            ]
        );

        $this->add_control(
            'etn_event_col',
            [
                'label'   => esc_html__('Event column', 'eventin-pro'),
                'type'    => Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '3'  => esc_html__('4 Column ', 'eventin-pro'),
                    '4'  => esc_html__('3 Column', 'eventin-pro'),
                    '6'  => esc_html__('2 Column', 'eventin-pro'),
                    '12' => esc_html__('1 Column', 'eventin-pro'),

                ],
            ]
        );
        $this->add_control(
            'order',
            [
                'label'   => esc_html__('Order', 'eventin-pro'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'ASC' => esc_html__('Ascending', 'eventin-pro'),
                    'DESC' => esc_html__('Descending', 'eventin-pro'),
                ],
            ]
        );
        $this->add_control(
            'etn_show_category',
            [
                'label'     => esc_html__('Show Category', 'eventin-pro'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('Yes', 'eventin-pro'),
                'label_off' => esc_html__('No', 'eventin-pro'),
                'default'   => 'yes',
            ]
        );
        $this->add_control(
            'etn_show_btn',
            [
                'label'     => esc_html__('Show Attend Button', 'eventin-pro'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('Yes', 'eventin-pro'),
                'label_off' => esc_html__('No', 'eventin-pro'),
                'default'   => 'yes',
            ]
        );
        $this->add_control(
            'etn_btn_text',
            [
                'label'     => esc_html__('Button Text', 'eventin-pro'),
                'type'      => Controls_Manager::TEXT,
                'default'   => esc_html__('attend ', 'eventin-pro'),
                'condition' => ['etn_show_btn' => 'yes'],
            ]
        );
        $this->add_control(
            'etn_show_attendee_count',
            [
                'label'     => esc_html__('Show Attendee Count', 'eventin-pro'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('Yes', 'eventin-pro'),
                'label_off' => esc_html__('No', 'eventin-pro'),
                'default'   => 'yes',
                'condition' => ['etn_event_style' => ['event-3', 'event-4']],

            ]
        );
        $this->add_control(
            'etn_show_thumb',
            [
                'label'     => esc_html__('Show Thumbnail', 'eventin-pro'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('Yes', 'eventin-pro'),
                'label_off' => esc_html__('No', 'eventin-pro'),
                'default'   => 'yes',
                'condition' => ['etn_event_style' => ['event-4']],

            ]
        );
        $this->end_controls_section();

        // Thumbnail style section
        $this->start_controls_section(
            'thumbnail_section',
            [
                'label' => __('Thumbnail Style', 'eventin-pro'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'thumbnail_height',
            [
                'label'           => esc_html__('image height', 'eventin-pro'),
                'type'            => \Elementor\Controls_Manager::SLIDER,
                'range'           => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'devices'         => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => [
                    'size' => 120,
                    'unit' => 'px',
                ],
                'tablet_default'  => [
                    'size' => 300,
                    'unit' => 'px',
                ],
                'mobile_default'  => [
                    'size' => 250,
                    'unit' => 'px',
                ],
                'condition'       => ['etn_event_style' => 'event-3'],
                'default'         => [
                    'unit' => 'px',
                    'size' => 400,
                ],
                'selectors'       => [
                    '{{WRAPPER}} .etn-event-style3 .etn-event-item' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'etn_thumb_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-event-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'etn_thumb_margin',
            [
                'label'      => esc_html__('Margin', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-event-thumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Title style section
        $this->start_controls_section(
            'title_section',
            [
                'label' => __('Title Style', 'eventin-pro'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'ent_title_typography',
                'label'    => esc_html__('Title Typography', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-event-content .etn-title',
            ]
        );

        // tab controls start
        $this->start_controls_tabs(
            'etn_title_tabs'
        );

        $this->start_controls_tab(
            'etn_title_normal_tab',
            [
                'label' => __('Normal', 'eventin-pro'),
            ]
        );
        $this->add_control(
            'etn_title_color',
            [
                'label'     => esc_html__('Title color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-content .etn-title'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .etn-event-content .etn-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'etn_title_hover_tab',
            [
                'label' => __('Hover', 'eventin-pro'),
            ]
        );
        $this->add_control(
            'etn_title_hover_color',
            [
                'label'     => esc_html__('Title Hover color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-item:hover .etn-event-content .etn-title:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .etn-event-item:hover .etn-event-content .etn-title a'     => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        // tabs control end

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__('Title margin', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-event-content .etn-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // designation style section
        $this->start_controls_section(
            'desc_section',
            [
                'label'     => esc_html__('Description Style', 'eventin-pro'),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['etn_show_desc' => 'yes'],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_description_typography',
                'label'    => esc_html__('Description Typography', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-event-content p',
            ]
        );

        $this->add_control(
            'etn_desc_color',
            [
                'label'     => esc_html__('Description color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-content p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'etn_desc_margin',
            [
                'label'      => esc_html__('Description margin', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-event-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // attendee count style section
        $this->start_controls_section(
            'attendee_count_style',
            [
                'label'     => esc_html__('Attendee Count Style', 'eventin-pro'),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['etn_event_style' => ['event-3', 'event-4']],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_attendee_count_typography',
                'label'    => esc_html__('Typography', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-event-attendee-count',
            ]
        );

        $this->add_control(
            'etn_attendee_count_color',
            [
                'label'     => esc_html__('color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-attendee-count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // location style section
        $this->start_controls_section(
            'location_style',
            [
                'label' => esc_html__('Location Style', 'eventin-pro'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_location_typography',
                'label'    => esc_html__('Location Typography', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-event-location',
            ]
        );

        $this->add_control(
            'etn_location_color',
            [
                'label'     => esc_html__('Location color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-location' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Date style section
        $this->start_controls_section(
            'date_style',
            [
                'label' => esc_html__('Date Style', 'eventin-pro'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_date_typography',
                'label'    => esc_html__('Date Typography', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-event-date',
            ]
        );

        $this->add_control(
            'etn_date_color',
            [
                'label'     => esc_html__('Date color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // category style section
        $this->start_controls_section(
            'category_style',
            [
                'label'     => esc_html__('Category Style', 'eventin-pro'),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['etn_show_category' => 'yes'],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_category_typography',
                'label'    => esc_html__('Typography', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-event-category span',
            ]
        );

        $this->add_control(
            'etn_category_color',
            [
                'label'     => esc_html__('color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-category span' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'etn_category_bg_color',
            [
                'label'     => esc_html__('Background color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-category span' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'etn_category_padding',
            [
                'label'      => esc_html__('Padding', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-event-category span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'etn_category_radius',
            [
                'label'      => esc_html__('Border Radius', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-event-category span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        // Button style section
        $this->start_controls_section(
            'etn_btn_style',
            [
                'label'     => esc_html__('Button Style', 'eventin-pro'),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['etn_show_btn' => 'yes'],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_btn_typography',
                'label'    => esc_html__('Button Typography', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-event-item .etn-btn',
            ]
        );
        // tab controls start
        $this->start_controls_tabs(
            'etn_btn_tabs'
        );

        $this->start_controls_tab(
            'etn_btn_normal_tab',
            [
                'label' => esc_html__('Normal', 'eventin-pro'),
            ]
        );
        $this->add_control(
            'etn_btn_color',
            [
                'label'     => esc_html__('Button color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-item .etn-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'btn_background',
                'label'    => esc_html__('Background Color', 'eventin-pro'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .etn-event-item .etn-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'etn_btn_border',
                'label'    => esc_html__('Border', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-event-item .etn-btn',
            ]
        );
        $this->add_responsive_control(
            'etn_btn_radius',
            [
                'label'      => esc_html__('Border Radius', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-event-item .etn-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'etn_btn_hover_tab',
            [
                'label' => esc_html__('Hover', 'eventin-pro'),
            ]
        );
        $this->add_control(
            'etn_btn_hover_color',
            [
                'label'     => esc_html__('Button Hover color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-item .etn-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'btn_background_hover',
                'label'    => esc_html__('Background Hover Color', 'eventin-pro'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .etn-event-item .etn-btn:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'etn_btn_hover_border',
                'label'    => esc_html__('Border Hover', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-event-item .etn-btn:hover',
            ]
        );

        $this->add_responsive_control(
            'etn_btn_hover_radius',
            [
                'label'      => esc_html__('Border Radius', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-event-item .etn-btn:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        // tabs control end

        $this->add_responsive_control(
            'etn_btn_padding',
            [
                'label'      => esc_html__('Button Padding', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-event-item .etn-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // advance style section
        $this->start_controls_section(
            'advance_style',
            [
                'label' => esc_html__('Advance Style', 'eventin-pro'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        // tab controls start
        $this->start_controls_tabs(
            'etn_content_box_tabs'
        );

        $this->start_controls_tab(
            'etn_content_box_normal_tab',
            [
                'label' => esc_html__('Normal', 'eventin-pro'),
            ]
        );
        $this->add_control(
            'etn_content_box_color',
            [
                'label'     => esc_html__('Content box BG color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'content_box_border',
                'label'    => esc_html__('Border', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-event-item',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'conetnt_box_shadow',
                'label'    => esc_html__('Box Shadow', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-event-item',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'etn_content_box_hover_tab',
            [
                'label' => esc_html__('Hover', 'eventin-pro'),
            ]
        );
        $this->add_control(
            'etn_content_box_hover_color',
            [
                'label'     => esc_html__('Box Hover BG color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-event-item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'content_box_hover_border',
                'label'    => esc_html__('BorderHover', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-event-item:hover',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'conetnt_hover_box_shadow',
                'label'    => esc_html__('Box Hover Shadow', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-event-item:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        // tabs control end

        $this->add_responsive_control(
            'etn_content_box_radius',
            [
                'label'      => esc_html__('Box Border Radius', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-event-item, .etn-event-style3 .etn-event-item:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'etn_content_box_padding',
            [
                'label'      => esc_html__('Content Box Padding', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-event-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'etn_content_box_margin',
            [
                'label'      => esc_html__('Content Box Margin', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-event-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings       = $this->get_settings();
        $style          = $settings["etn_event_style"];
        $event_cat      = $settings["etn_event_cat"];
        $event_tag      = $settings["etn_event_tag"];
        $event_count    = $settings["etn_event_count"];
        $event_col      = $settings["etn_event_col"];
        $desc_limit     = $settings["etn_desc_limit"];
        $show_category  = $settings["etn_show_category"];
        $show_desc      = $settings["etn_show_desc"];
        $btn_text       = $settings["etn_btn_text"];
        $show_btn       = $settings["etn_show_btn"];
        $order          = (isset($settings["order"]) ? $settings["order"] : 'DESC');
        $show_attendee_count       = $settings["etn_show_attendee_count"];
        $show_thumb     = $settings["etn_show_thumb"];


        include ETN_PRO_DIR . "/widgets/events-pro/style/{$style}.php";
    }

    public function get_event_category()
    {
        return Helper::get_event_category();
    }

    public function get_event_tag()
    {
        return Helper::get_event_tag();
    }
}
