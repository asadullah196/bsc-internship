<?php

namespace Etn_Pro\Core\Event;

defined( 'ABSPATH' ) || exit;

use Etn\Core\Settings\Settings as SettingsFree;
use Etn_Pro\Utils\Helper;

class Single_Page_View {

    use \Etn\Traits\Singleton;

    public $text_domain = "eventin-pro";

    /**
     * Call all hooks
     *
     * @return void
     */
    public function init() {
        add_filter( "etn_faq_view", [$this, "generate_single_page_faq_view"], 10, 2 );
        add_filter( 'eventin/view/counter/section', [$this, 'banner_section'], 10, 1 );
    }

    /**
     * Generate and inject F.A.Q. view through hook
     */
    public function generate_single_page_faq_view( $view, $post_id ) {
        
        $settings = SettingsFree::instance()->get_settings_option();
        
        if ( !isset( $settings["hide_faq_from_details"] ) ) {
            return 'event/event-pro-faq.php';
        }

        return;
    }


    /**
     * Render banner in event single page
     *
     */
    public function banner_section( $id ) {
        $alignment   = get_post_meta( $id, 'alignment', true );
        $banner      = get_post_meta( $id, 'etn_banner', true );
        $banner_type = get_post_meta( $id, 'banner_bg_type', true );

        if ( $banner == 'on' ) {
            if ( $banner_type == 'on' ) {
                $banner_bg_color = get_post_meta( $id, 'banner_bg_color', true );
                $style           = "height: 230px; background-color:" . esc_attr( $banner_bg_color ) . "";
            } else {
                $banner_bg_image = get_post_meta( $id, 'banner_bg_image', true );
                $banner_bg_image = Helper::img_meta( $banner_bg_image );
                $bg_image        = '';
                if ( is_array( $banner_bg_image ) ) {
                    $bg_image = $banner_bg_image['src'];
                }

                $style = 'height: 230px; background-size: cover; background-position: center center; background-repeat: no-repeat;background-image:url(' . esc_url( $bg_image ) . ');';
            }

            $alignment_style = '';
            if ( $alignment == 'off' ) {
                $alignment_style = "text-align:left";
            } else {
                $alignment_style = "text-align:center; mergin:0 auto";
            }

            ?>
            <div style="<?php echo esc_attr( $style ) !== '' ? esc_attr( $style ) : ''; ?>">
                <div class="event_title" style="<?php echo esc_attr( $alignment_style ) !== '' ? esc_attr( $alignment_style ) : ''; ?>">
                    <?php echo esc_html( get_the_title( $id ) ); ?>
                </div>
                <div class="count_down" style="<?php echo esc_attr( $alignment_style ) ?>">countdown</div>
            </div>
            <?php
        }
    }

}
