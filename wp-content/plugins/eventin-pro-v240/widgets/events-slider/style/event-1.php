<?php
if (!defined('ABSPATH')) exit;

use \Etn_Pro\Utils\Helper;



$date_options= Helper::get_date_formats();

$event_options = get_option("etn_event_options");
$data = Helper::post_data_query('etn', $event_count, $order, $event_cat, 'etn_category', null, null, $event_tag);

?>
<div class='etn-event-wrapper etn-event-slider' data-count="<?php echo esc_attr($event_slider_count); ?>">
    <div class="swiper-wrapper">

        <?php
        if ( !empty( $data ) ) {
            foreach( $data as $value ) { 
                $social           = get_post_meta($value->ID, 'etn_event_socials', true);
                $etn_event_location = get_post_meta($value->ID, 'etn_event_location', true);
                $etn_start_date = get_post_meta($value->ID, 'etn_start_date', true);
                $event_start_date = isset($event_options["date_format"]) && "" != $event_options["date_format"] ? date_i18n($date_options[$event_options["date_format"]], strtotime($etn_start_date)) : date_i18n('d/m/Y', strtotime($etn_start_date));
                $category =  Helper::cate_with_link($value->ID, 'etn_category');
                ?>
                <div class="swiper-slide">
                    <div class="etn-event-item">
                        <?php if ( esc_url( get_the_post_thumbnail_url( $value->ID ) ) ) { ?>
                            <div class="etn-event-thumb">
                                    <a href="<?php echo esc_url( get_the_permalink( $value->ID ) ); ?>">
                                        <img src="<?php echo esc_url( get_the_post_thumbnail_url( $value->ID ) ); ?>" alt="<?php the_title_attribute($value->ID); ?>">
                                    </a>
                                <?php if ($show_category === 'yes') : ?>
                                    <div class="etn-event-category">
                                        <?php echo  Helper::kses($category); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php } ?>
                        <!-- thumbnail start-->
                        <!-- content start-->
                        <div class="etn-event-content">
                            <?php if (isset($etn_event_location) && $etn_event_location != '') { ?>
                                <div class="etn-event-location"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($etn_event_location); ?></div>
                            <?php } ?>
                            <h3 class="etn-title etn-event-title"><a href="<?php echo esc_url( get_the_permalink( $value->ID ) ); ?>"> <?php echo esc_html( get_the_title( $value->ID ) ); ?></a> </h3>
                            <?php if ($show_desc == 'yes') : ?>
                                <p><?php echo esc_html(Helper::trim_words( $value->post_content, $desc_limit)); ?></p>
                            <?php endif; ?>
                            <div class="etn-event-footer">
                                <div class="etn-event-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <?php echo esc_html($event_start_date); ?>
                                </div>
                                <?php if ($show_btn == 'yes') : ?>
                                    <div class="etn-atend-btn">
                                        <a href="<?php echo esc_url( get_the_permalink( $value->ID ) ); ?>" class="etn-btn etn-btn-border"><?php echo esc_html($btn_text); ?> <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- content end-->
                    </div>
                </div>
                <?php
            }
        }
        ?>

    </div>
    <?php if ($slider_nav_show == 'yes') : ?>
        <!-- next / prev arrows -->
        <div class="swiper-button-next"> <i class="fas fa-arrow-right"></i> </div>
        <div class="swiper-button-prev"> <i class="fas fa-arrow-left"></i> </div>
        <!-- !next / prev arrows -->
    <?php endif; ?>
    <?php if ($slider_dot_show == 'yes') : ?>
        <!-- pagination dots -->
        <div class="swiper-pagination"></div>
        <!-- !pagination dots -->
    <?php endif; ?>

</div>