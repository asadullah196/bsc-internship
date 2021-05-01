<?php
namespace Elementor;
use Elementor\Widget_base;
use Elementor\Controls_Manager;
use Etn_Pro\Utils\Helper;

defined( "ABSPATH" ) || die();

class Etn_Pro_Event_Ticket extends Widget_Base {
    public function get_name() {
        return "etn-event-ticket";
    }

    public function get_title() {
        return esc_html__( "Event Ticket Pro", "eventin-pro" );
    }

    public function get_categories() {
        return ["etn-event"];
    }

    public function get_icon() {
        return "eicon-product-add-to-cart";
    }

    public function _register_controls() {
        $this->start_controls_section(
            'section_tab',
            [
                'label' => esc_html__("Event Ticket Form", "eventin-pro")
            ]
        );
        $this->add_control(
            "event_id",
            [
                "label"     => esc_html__("Select Event", "eventin-pro"),
                "type"      => Controls_Manager::SELECT2,
                "multiple"  => false,
                "options"   => Helper::get_events(),
            ]
        );
        $this->add_control(
            "show_title",
            [
                "label" => esc_html__("Show Title", "eventin-pro"),
                "type"  => Controls_Manager::SWITCHER,
                "label_on"  => esc_html__("Show", "eventin-pro"),
                "label_on"  => esc_html__("Hide", "eventin-pro"),
                "default"   => "yes"
            ]
        );
        $this->end_controls_section();
    }

    public function render() {
        $settings               = $this->get_settings();
        $single_event_id        = !empty( $settings['event_id'] ) ? $settings['event_id'] : 0;
        if ( class_exists( 'WooCommerce' ) ) {
            if( function_exists('wc_print_notices') ){
             wc_print_notices();
            }
         }
        ?>
        <div class="etn-event-form-widget">
            <?php
            if( !empty( $settings["show_title"] ) ){
                ?>
                <div>
                    <h3 class="etn-event-form-widget-title"><?php echo esc_html( get_the_title( $single_event_id ) );?></h3>
                </div>
                <?php
            }
            
            ?>
            <?php
            if( class_exists('WooCommerce') ){
                Helper::woocommerce_ticket_widget( $single_event_id );
            }
            ?>
        </div>
        <?php
    }
    

}

?>