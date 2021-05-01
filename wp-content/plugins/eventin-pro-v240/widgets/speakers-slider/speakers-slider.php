<?php

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use \Etn_Pro\Utils\Helper;

defined('ABSPATH') || exit;

class Etn_Pro_Speakers_Slider extends Widget_Base
{

    /**
     * Retrieve the widget name.
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'etn-pro-speaker-slider';
    }

    /**
     * Retrieve the widget title.
     * @return string Widget title.
     */
    public function get_title()
    {
        return esc_html__('Speaker Slider Pro', 'eventin-pro');
    }

    /**
     * Retrieve the widget icon.
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-user-circle-o';
    }

    /**
     * Retrieve the widget category.
     * @return string Widget category.
     */
    public function get_categories()
    {
        return ['etn-event'];
    }

    protected function _register_controls()
    {
        // Start of speaker section
        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__('Speaker Slider Pro', 'eventin-pro'),
            ]
        );

        $this->add_control(
            'speaker_style',
            [
                'label'   => esc_html__('Speaker Style', 'eventin-pro'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'speaker-1',
                'options' => [
                    'speaker-1' => esc_html__('Speaker 1', 'eventin-pro'),
                    'speaker-2' => esc_html__('Speaker 2', 'eventin-pro'),
                    'speaker-3' => esc_html__('Speaker 3', 'eventin-pro'),
                    'speaker-4' => esc_html__('Speaker 4', 'eventin-pro'),
                    'speaker-5' => esc_html__('Speaker 5', 'eventin-pro'),
                ],
            ]
        );

        $this->add_control(
            'speakers_category',
            [
                'label'     => esc_html__('Speaker Category', 'eventin-pro'),
                'type'      => Controls_Manager::SELECT2,
                'multiple'  => true,
                'options'   => $this->get_speakers_category(),
            ]
        );
        $this->add_control(
            'etn_speaker_count',
            [
                'label'     => esc_html__('Speaker count', 'eventin-pro'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => '6',

            ]
        );
        $this->add_control(
            'slider_count',
            [
                'label'     => esc_html__('slider count', 'eventin-pro'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => '3',

            ]
        );
        $this->add_control(
            'spaceBetween',
            [
                'label'     => esc_html__('Space Between', 'eventin-pro'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => '30',

            ]
        );
        
        $this->add_control(
            'orderby',
            [
                'label'     => esc_html__( 'Order Speaker By', 'eventin-pro' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'post_date',
                'options'   => [
                    'ID'        => esc_html__( 'Id', 'eventin-pro' ),
                    'title'     => esc_html__( 'Title', 'eventin-pro' ),
                    'post_date' => esc_html__( 'Post Date', 'eventin-pro' ),
                ],
            ]
        );
        $this->add_control(
            'etn_speaker_order',
            [
                'label'     => esc_html__('Speaker order', 'eventin-pro'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'DESC',
                'options'   => [
                    'DESC' => esc_html__('Descending', 'eventin-pro'),
                    'ASC'  => esc_html__('Ascending', 'eventin-pro'),
                ],

            ]
        );
        $this->add_control(
            'etn_show_social',
            [
                'label'     => esc_html__('Show Social', 'eventin-pro'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('Yes', 'eventin-pro'),
                'label_off' => esc_html__('No', 'eventin-pro'),
                'default'   => 'yes',
            ]
        );
        $this->add_control(
            'etn_show_designation',
            [
                'label'     => esc_html__('Show Designation', 'eventin-pro'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('Yes', 'eventin-pro'),
                'label_off' => esc_html__('No', 'eventin-pro'),
                'default'   => 'yes',
            ]
        );
        $this->add_control(
            'content_align',
            [
                'label' => esc_html__('Alignment', 'eventin-pro'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'eventin-pro'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'eventin-pro'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'eventin-pro'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'toggle' => true,
                'selectors'  => [
                    '{{WRAPPER}} .etn-single-speaker-item' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // End of speaker section
        // item slider nav style section 
        $this->start_controls_section(
            'etn_slider_style',
            [
                'label' => esc_html__('Slider Style', 'eventin-pro'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'etn_slider_nav_show',
            [
                'label' => esc_html__('Slider Nav Show', 'eventin-pro'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'eventin-pro'),
                'label_off' => esc_html__('Hide', 'eventin-pro'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'etn_slider_dot_show',
            [
                'label' => esc_html__('Slider dot Show', 'eventin-pro'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'eventin-pro'),
                'label_off' => esc_html__('Hide', 'eventin-pro'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'etn_slider_nav_bg_color',
            [
                'label'         => esc_html__('Slider Nav BG Color', 'eventin-pro'),
                'type'         => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .etn-speaker-wrapper.etn-speaker-slider .swiper-button-next, .etn-speaker-wrapper.etn-speaker-slider .swiper-button-prev, .etn-speaker-wrapper.etn-speaker-slider .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_section();



        // Start of thumnail section
        $this->start_controls_section(
            'thumbanil_section',
            [
                'label' => esc_html__('Thumbanil Section', 'eventin-pro'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'etn_thumb_margin',
            [
                'label'      => esc_html__('margin', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-speaker-thumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'etn_thumb_radius',
            [
                'label'      => esc_html__('Border Radius', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-speaker-thumb' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'img_width',
            [
                'label' => esc_html__('Width', 'eventin-pro'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'condition' => ['speaker_style' => ['speaker-3']],

                'selectors' => [
                    '{{WRAPPER}} .etn-speaker-thumb' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'img_height',
            [
                'label' => esc_html__('Height', 'eventin-pro'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'condition' => ['speaker_style' => ['speaker-3']],
                'selectors' => [
                    '{{WRAPPER}} .etn-speaker-thumb' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'thumb_box_shadow',
                'label' => esc_html__('Box Shadow', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-speaker-thumb',
            ]
        );
        $this->end_controls_section();
        // Start of title section
        $this->start_controls_section(
            'title_section',
            [
                'label' => esc_html__('Title Section', 'eventin-pro'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        //control for title typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'ent_title_typography',
                'label'    => esc_html__('Title Typography', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-speaker-content .etn-title',
            ]
        );

        //start of title color tabs (normal and hover)
        $this->start_controls_tabs(
            'etn_title_tabs'
        );

        //start of title normal color tab
        $this->start_controls_tab(
            'etn_title_normal_tab',
            [
                'label' => esc_html__('Normal', 'eventin-pro'),
            ]
        );
        $this->add_control(
            'etn_title_color',
            [
                'label'     => esc_html__('Title color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-speaker-content .etn-title'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .etn-speaker-content .etn-title a' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'etn_title_bg_color',
            [
                'label'     => esc_html__('Title BG color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'condition' => ['speaker_style' => ['speaker-4']],

                'selectors' => [
                    '{{WRAPPER}} .etn-speaker-content .etn-title a' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        // end of title normal color tab

        //start of title hover color tab
        $this->start_controls_tab(
            'etn_title_hover_tab',
            [
                'label' => esc_html__('Hover', 'eventin-pro'),
            ]
        );
        $this->add_control(
            'etn_title_hover_color',
            [
                'label'     => esc_html__('Title Hover color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-single-speaker-item:hover .etn-speaker-content .etn-title:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .etn-single-speaker-item:hover .etn-speaker-content .etn-title a'     => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        //end of title hover color tab

        $this->end_controls_tabs();

        //end of title color tabs (normal and hover)

        //start of title margin control
        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__('Title margin', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-speaker-content .etn-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        //end of title margin control

        $this->end_controls_section();

        // end of title section

        // Start of designation section
        $this->start_controls_section(
            'desginnation_section',
            [
                'label' => esc_html__('Designation Section', 'eventin-pro'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['etn_show_designation' => 'yes'],
            ]
        );
        //control for designation typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_designation_typography',
                'label'    => esc_html__('Designation Typography', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-speaker-content p',
            ]
        );

        //start of designation color tabs (normal and hover)
        $this->start_controls_tabs(
            'etn_desc_tabs'
        );

        //start of designation normal color tab
        $this->start_controls_tab(
            'etn_desc_normal_tab',
            [
                'label' => esc_html__('Normal', 'eventin-pro'),
            ]
        );
        $this->add_control(
            'etn_desc_color',
            [
                'label'     => esc_html__('Designation color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-speaker-content p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'etn_desc_bg_color',
            [
                'label'     => esc_html__('Designation BG color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'condition' => ['speaker_style' => ['speaker-4']],

                'selectors' => [
                    '{{WRAPPER}} .etn-speaker-content p' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        //end of designation normal color tab

        //start of designation hover color tab
        $this->start_controls_tab(
            'etn_desc_hover_tab',
            [
                'label' => esc_html__('Hover', 'eventin-pro'),
            ]
        );
        $this->add_control(
            'etn_desc_hover_color',
            [
                'label'     => esc_html__('Designation Hover color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-single-speaker-item:hover .etn-speaker-content p' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        //end of designation hover color tab

        $this->end_controls_tabs();

        //end of designation color tabs (normal and hover)

        //control for designation margin
        $this->add_responsive_control(
            'etn_desc_margin',
            [
                'label'      => esc_html__('Description margin', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-speaker-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // End of designation section

        // Start of social section
        $this->start_controls_section(
            'social_section',
            [
                'label' => esc_html__('Social Section', 'eventin-pro'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => ['etn_show_social' => 'yes']
            ]
        );

        // Start of social-bg color tabs (Normal and Hover)
        $this->start_controls_tabs(
            'etn_social_tabs'
        );

        //start of social-bg normal color tab
        $this->start_controls_tab(
            'etn_social_normal_tab',
            [
                'label' => esc_html__('Normal', 'eventin-pro'),
            ]
        );
        $this->add_control(
            'etn_social_color',
            [
                'label'     => esc_html__('Social color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-single-speaker-item  .etn-speakers-social a i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'etn_social_bg_color',
            [
                'label'     => esc_html__('Social BG color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-single-speaker-item  .etn-speakers-social a' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        //control for social typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_social_typography',
                'label'    => esc_html__('Typography', 'eventin-pro'),
                'selector' => '{{WRAPPER}}  .etn-speakers-social a',
            ]
        );
        $this->add_responsive_control(
            'etn_social_padding',
            [
                'label'      => esc_html__('Padding', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-speakers-social a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'etn_social__border_radius',
            [
                'label'      => esc_html__('Border Radius', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-speakers-social a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        //end of social-bg normal color tab

        //start of social-bg hover color tab
        $this->start_controls_tab(
            'etn_social_hover_tab',
            [
                'label' => esc_html__('Hover', 'eventin-pro'),
            ]
        );
        $this->add_control(
            'etn_social_hover_color',
            [
                'label'     => esc_html__('Social color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-single-speaker-item  .etn-speakers-social a:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'etn_social_hover_bg_color',
            [
                'label'     => esc_html__('Social Hover BG color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-single-speaker-item .etn-speakers-social a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'etn_social_hover_padding',
            [
                'label'      => esc_html__('Padding', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-speakers-social a:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'etn_social__hover_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}  .etn-speakers-social a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab();
        //end of social-bg hover color tab

        $this->end_controls_tabs();
        // End of social-bg color tabs (Normal and Hover)

        $this->end_controls_section();

        // End of social section

        // Start of advance style section
        $this->start_controls_section(
            'advance_section',
            [
                'label' => esc_html__('Advance Section', 'eventin-pro'),
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
                    '{{WRAPPER}} .etn-single-speaker-item .etn-speaker-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'content_box_border',
                'label'    => esc_html__('Border', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-single-speaker-item',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__('Box Shadow', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-single-speaker-item',
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
                    '{{WRAPPER}} .etn-single-speaker-item:hover .etn-speaker-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'content_box_hover_border',
                'label'    => esc_html__('Border Hover', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-single-speaker-item:hover',
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'hover_box_shadow',
                'label' => esc_html__('Box Shadow', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-single-speaker-item:hover',
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();
        // tabs control end

        $this->add_responsive_control(
            'etn_content_box_padding',
            [
                'label'      => esc_html__('Content Box Padding', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-speaker-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'etn_item_box_padding',
            [
                'label'      => esc_html__('Item Padding', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-single-speaker-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'etn_item_box_margin',
            [
                'label'      => esc_html__('Item Margin', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-single-speaker-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
        // End of advance style section
    }

    protected function render()
    {
        $settings           = $this->get_settings();
        $style              = $settings["speaker_style"];
        $slider_nav_show    = $settings["etn_slider_nav_show"];
        $slider_dot_show    = $settings["etn_slider_dot_show"];
        $slider_count       = $settings["slider_count"];
        $spaceBetween       = $settings["spaceBetween"];
        $speaker_count      = $settings["etn_speaker_count"];
        $speaker_order      = $settings["etn_speaker_order"];
        $show_social        = $settings["etn_show_social"];
        $show_designation   = $settings["etn_show_designation"];
        $speaker_category   = $settings['speakers_category'];
        $orderby            = $settings["orderby"];
        $orderby_meta       = null;


        include ETN_PRO_DIR . "/widgets/speakers-slider/style/{$style}.php";
    }

    protected function get_speakers()
    {
        return Helper::get_speakers();
    }

    protected function get_speakers_category()
    {
        return Helper::get_speakers_category();
    }
}
