<?php

namespace Elementor;

defined( 'ABSPATH' ) || exit;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use \Etn_Pro\Utils\Helper;

class Etn_Pro_Organizers extends Widget_Base {

    /**
     * Retrieve the widget name.
     * @return string Widget name.
     */
    public function get_name() {
        return 'etn-organizer';
    }

    /**
     * Retrieve the widget title.
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'Eventin organizer Pro', 'eventin-pro' );
    }

    /**
     * Retrieve the widget icon.
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-user-circle-o';
    }

    /**
     * Retrieve the widget category.
     * @return string Widget category.
     */
    public function get_categories() {
        return ['etn-event'];
    }

    /**
     * Registers control for this widget
     *
     * @return void
     */
    protected function _register_controls() {
        // Start of speaker section
        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__( 'Eventin Organizers', 'eventin-pro' ),
            ]
        );

        $this->add_control(
            'organizer_style',
            [
                'label'   => esc_html__( 'Organizer Style', 'eventin-pro' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'organizer-2',
                'options' => [
                    'organizer-1' => esc_html__( 'Organizer 1', 'eventin-pro' ),
                    'organizer-2' => esc_html__( 'Organizer 2', 'eventin-pro' ),

                ],
            ]
        );
        $this->add_control(
            'speaker_id',
            [
                'label'     => esc_html__( 'Organizer', 'eventin-pro' ),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $this->get_speakers(),
                'condition' => ['organizer_style' => ['organizer-1']],
            ]
        );
        $this->add_control(
            'speakers_category',
            [
                'label'     => esc_html__( 'Organizer Category', 'eventin-pro' ),
                'type'      => Controls_Manager::SELECT2,
                'multiple'  => true,
                'options'   => $this->get_speakers_category(),
                'condition' => ['organizer_style' => ['organizer-2']],
            ]
        );
        $this->add_control(
            'etn_speaker_count',
            [
                'label'     => esc_html__( 'Organizer count', 'eventin-pro' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => '6',
                'condition' => ['organizer_style' => ['organizer-2']],
            ]
        );
        $this->add_control(
            'etn_speaker_col',
            [
                'label'     => esc_html__( 'Organizer column', 'eventin-pro' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '4',
                'options'   => [
                    '3' => esc_html__( '4 Column ', 'eventin-pro' ),
                    '4' => esc_html__( '3 Column', 'eventin-pro' ),
                    '6' => esc_html__( '2 Column', 'eventin-pro' ),

                ],
                'condition' => ['organizer_style' => ['organizer-2']],
            ]
        );
                
        $this->add_control(
            'orderby',
            [
                'label'     => esc_html__( 'Order Organizer By', 'eventin-pro' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'post_date',
                'options'   => [
                    'ID'        => esc_html__( 'Id', 'eventin-pro' ),
                    'title'     => esc_html__( 'Title', 'eventin-pro' ),
                    'post_date' => esc_html__( 'Post Date', 'eventin-pro' ),
                ],
                'condition' => ['organizer_style' => ['organizer-2']],
            ]
        );

        $this->add_control(
            'etn_speaker_order',
            [
                'label'     => esc_html__( 'Organizer Order', 'eventin-pro' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'DESC',
                'options'   => [
                    'DESC' => esc_html__( 'Descending', 'eventin-pro' ),
                    'ASC'  => esc_html__( 'Ascending', 'eventin-pro' ),
                ],
                'condition' => ['organizer_style' => ['organizer-2']],
            ]
        );
        $this->add_control(
            'etn_speaker_company_logo',
            [
                'label'     => esc_html__( 'Company logo', 'eventin-pro' ),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__( 'Yes', 'eventin-pro' ),
                'label_off' => esc_html__( 'No', 'eventin-pro' ),
                'default'   => 'yes',
                'condition' => ['organizer_style' => ['organizer-2']],
            ]
        );

        $this->end_controls_section();
        // End of speaker section

        // Start of designation section
        $this->start_controls_section(
            'orgainzer_info_section',
            [
                'label' => esc_html__( 'Organaizer Info', 'eventin-pro' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        //control for designation typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_org_info_typography',
                'label'    => esc_html__( 'Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .etn-organizer-content li',
            ]
        );

        $this->add_control(
            'etn_org_info_color',
            [
                'label'     => esc_html__( 'Organaizer Info color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-organizer-content li' => 'color: {{VALUE}};',
                ],
            ]
        );

        //control for designation margin
        $this->add_responsive_control(
            'etn_org_info_margin',
            [
                'label'      => esc_html__( 'Info Padding', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-organizer-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End of designation section

        // Start of social section
        $this->start_controls_section(
            'social_section',
            [
                'label' => esc_html__( 'Social Section', 'eventin-pro' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        //control for designation typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'etn_social_typography',
                'label'    => esc_html__( 'Typography', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .etn-organizer-content li .etn-organizer-social a',
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
                'label' => esc_html__( 'Normal', 'eventin-pro' ),
            ]
        );
        $this->add_control(
            'etn_social_color',
            [
                'label'     => esc_html__( 'Social color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-organizer-content li .etn-organizer-social a i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        //end of social-bg normal color tab

        //start of social-bg hover color tab
        $this->start_controls_tab(
            'etn_social_hover_tab',
            [
                'label' => esc_html__( 'Hover', 'eventin-pro' ),
            ]
        );
        $this->add_control(
            'etn_social_hover_color',
            [
                'label'     => esc_html__( 'Social Hover color', 'eventin-pro' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-organizer-content li .etn-organizer-social a:hover i' => 'color: {{VALUE}};',
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
                'label' => esc_html__( 'Advance Section', 'eventin-pro' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'content_box_border',
                'label'    => esc_html__( 'Border', 'eventin-pro' ),
                'selector' => '{{WRAPPER}} .etn-organizer-item',
            ]
        );

        $this->add_responsive_control(
            'etn_content_box_padding',
            [
                'label'      => esc_html__( 'Content Box Padding', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-organizer-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'etn_content_box_margin',
            [
                'label'      => esc_html__( 'Content Box Margin', 'eventin-pro' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-organizer-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End of advance style section
    }

    /**
     * Renders widget maerkup
     *
     * @return void
     */
    protected function render() {
        $settings   = $this->get_settings();
        $style      = $settings["organizer_style"];
        $speaker_id = $settings["speaker_id"];

        $etn_speaker_count          = isset($settings["etn_speaker_count"]) && is_numeric($settings["etn_speaker_count"]) ? $settings["etn_speaker_count"] : 3;
        $etn_speaker_col            = isset($settings["etn_speaker_col"]) && is_numeric($settings["etn_speaker_col"]) ? $settings["etn_speaker_col"] : 3;
        $etn_speaker_order          = isset($settings["etn_speaker_order"]) ? $settings["etn_speaker_order"] : "DESC";
        $etn_speaker_company_logo   = isset($settings["etn_speaker_company_logo"]) ? $settings["etn_speaker_company_logo"] : "";
        $show_url                   = "yes";
        $category_id                = $settings['speakers_category'];
        $orderby                    = $settings["orderby"];
        $orderby_meta               = null;

        include ETN_PRO_DIR . "/widgets/organizers/style/{$style}.php";
    }

    /**
     * Returns all speakers
     *
     * @return void
     */
    protected function get_speakers() {
        return Helper::get_speakers();
    }

    /**
     * Returns organizer's category
     *
     * @return void
     */
    protected function get_speakers_category() {
        return Helper::get_speakers_category();
    }
}
