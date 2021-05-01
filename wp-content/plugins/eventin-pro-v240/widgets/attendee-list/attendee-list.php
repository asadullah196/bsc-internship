<?php
namespace Elementor;
use Elementor\Widget_base;
use Elementor\Controls_Manager;
use Etn_Pro\Utils\Helper;

defined( "ABSPATH" ) || die();

class Etn_Pro_Attendee_List extends Widget_Base {
    public function get_name() {
        return "etn-attendee-list";
    }

    public function get_title() {
        return esc_html__( "Attendee List", "eventin-pro" );
    }

    public function get_categories() {
        return ["etn-event"];
    }

    public function get_icon() {
        return "eicon-user-circle-o";
    }

    public function _register_controls() {
        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__("Attendee List", "eventin-pro")
            ]
        );
        $this->add_control(
            "event_id",
            [
                "label"     => esc_html__("Select Event", "eventin-pro"),
                "type"      => Controls_Manager::SELECT,
                "multiple"  => false,
                "options"   => Helper::get_events(),
            ]
        );
        $this->add_control(
            'show_avatar',
            [
                'label'     => esc_html__('Show Thumbnail', 'eventin-pro'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('Yes', 'eventin-pro'),
                'label_off' => esc_html__('No', 'eventin-pro'),
                'default'   => 'yes',

            ]
        );
        $this->add_control(
            'show_email',
            [
                'label'     => esc_html__('Show Email', 'eventin-pro'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('Yes', 'eventin-pro'),
                'label_off' => esc_html__('No', 'eventin-pro'),
                'default'   => 'yes',

            ]
        );
   
        $this->end_controls_section();

         // designation style section
         $this->start_controls_section(
            'style_section',
            [
                'label'     => esc_html__('Title Style', 'eventin-pro'),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => esc_html__('Typography', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .etn-attendee-title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .etn-attendee-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__('margin', 'eventin-pro'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .etn-attendee-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

         // email style section
         $this->start_controls_section(
            'meta_style_section',
            [
                'label'     => esc_html__('Meta Style', 'eventin-pro'),
                'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'meta_typography',
                'label'    => esc_html__('Typography', 'eventin-pro'),
                'selector' => '{{WRAPPER}} .attende-meta',
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label'     => esc_html__('color', 'eventin-pro'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .attende-meta' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    public function render() {
        $settings               = $this->get_settings();
        $id        = !empty( $settings['event_id'] ) ? $settings['event_id'] : 0;
        $show_avatar        = $settings['show_avatar'];
        $show_email        = $settings['show_email'];
        ?>
        <div class="etn-attendee-widget">
             <?php
                Helper::attendee_list_widget( $id,$show_avatar, $show_email );
            ?>
        </div>
        <?php
    }
    

}

?>