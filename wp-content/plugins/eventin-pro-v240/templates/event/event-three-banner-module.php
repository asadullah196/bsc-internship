<?php

defined( 'ABSPATH' ) || exit;
use Etn_Pro\Utils\Helper;

$single_event_id = get_the_id();

$etn_event_logo         = get_post_meta($single_event_id, 'etn_event_logo', true);
$event_logo             = wp_get_attachment_image_src($etn_event_logo, 'large');

$etn_banner             = get_post_meta($single_event_id, 'etn_banner', true);
$banner_bg_type         = get_post_meta($single_event_id, 'banner_bg_type', true);

$banner_bg_image        = get_post_meta($single_event_id, 'banner_bg_image', true);
$banner_image           = wp_get_attachment_image_src($banner_bg_image, 'large');
$banner_image           = !empty( $banner_image[0] ) ? $banner_image[0] : "";

$banner_bg_color        = get_post_meta($single_event_id, 'banner_bg_color', true);
$banner_bg_color        = empty( $banner_bg_color ) ?  "#ff057c" : $banner_bg_color;

$etn_ticket_unlimited   = isset( $data['etn_ticket_unlimited']) && ( "on" == $data['etn_ticket_unlimited'] ) ? false : true;

$banner_style = '';
if ($banner_bg_type === 'no') {
    $banner_style = 'style=background-image:url(' . esc_url( $banner_image ) . ');';
} else {
    $banner_style = 'style=background-color:' . esc_attr($banner_bg_color) . ';';
}
?>
<!-- banner area -->

<div class="etn-event-banner-wrap etn-event-single3" <?php if ('on' === $etn_banner) :  echo esc_attr($banner_style);  endif; ?>>
    <div class="etn-container">
        <div class="etn-row">
            <div class="etn-col-lg-10 etn-mx-auto">
                <div class="etn-event-banner-content">

                    <?php do_action("etn_before_single_event_content_title", $single_event_id); ?>

                    <h1 class="etn-event-entry-title"> 
                        <?php echo esc_html( apply_filters('etn_single_event_content_title', get_the_title()) ); ?> 
                    </h1>

                    <?php do_action("etn_after_single_event_content_title", $single_event_id); ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>