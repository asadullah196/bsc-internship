<?php
if (!defined('ABSPATH')) exit;

use \Etn_Pro\Utils\Helper;

$event_options = get_option("etn_event_options");
$date_options= Helper::get_date_formats();

$data = Helper::post_data_query('etn', $event_count, $order, $event_cat, 'etn_category', null, null, $event_tag);
?>
<div class='etn-row etn-event-wrapper etn-event-style3'>
    <?php
    if ( !empty( $data ) ) {
        foreach( $data as $value ) { 

            $social             = get_post_meta( $value->ID, 'etn_event_socials', true);
            $event_location = get_post_meta( $value->ID, 'etn_event_location', true);

            $start_date = get_post_meta( $value->ID, 'etn_start_date', true);
            $end_date   = get_post_meta( $value->ID, 'etn_end_date', true);

            $first_day        = date_i18n('d M', strtotime($start_date));
            $event_start_date = date_i18n('d M Y', strtotime($start_date));
            $event_end_date   = date_i18n('d M Y', strtotime($end_date));
        
            $category =  Helper::cate_with_link( $value->ID, 'etn_category');
            ?>
            <div class="etn-col-md-6 etn-col-lg-<?php echo esc_attr( $event_col ); ?>">
                <div class="etn-event-item" style="background-image: url(<?php echo esc_url( esc_url( get_the_post_thumbnail_url( $value->ID ) ) ); ?>);">
                    <div class="etn-event-meta-info">
                        <?php if ($show_category === 'yes') : ?>
                            <div class="etn-event-category">
                                <?php echo  Helper::kses($category); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($show_btn == 'yes') : ?>
                            <div class="etn-atend-btn">
                                <a href="<?php echo esc_url( get_the_permalink( $value->ID ) ); ?>" class="etn-btn etn-btn-border"><?php echo esc_html( $btn_text ); ?></a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- content start-->
                    <div class="etn-event-content">
                        <div class="etn-event-date">
                            <i class="far fa-calendar-alt"></i>
                            <?php if( isset($end_date ) && $end_date != '') { ?>
                                <span><?php echo esc_html( $first_day . ' - ' .  $event_end_date); ?></span>
                            <?php } else { ?>
                                <?php echo esc_html( $event_start_date ); ?>
                            <?php } ?>
                        </div>
                        <div class="etn-title-info">
                            <?php if( isset( $event_location ) && $event_location != '') { ?>
                                <div class="etn-event-location"><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($event_location); ?></div>
                            <?php } ?>

                            <h3 class="etn-title etn-event-title"><a href="<?php echo esc_url( get_the_permalink( $value->ID ) ); ?>"> <?php echo esc_html( get_the_title( $value->ID ) ); ?></a> </h3>
                            
                            <?php if ($show_desc == 'yes') : ?>
                                <p><?php echo esc_html( Helper::trim_words( $value->post_content, $desc_limit ) ); ?></p>
                            <?php endif; ?>

                            <?php if ($show_attendee_count == 'yes') : ?>
                                <div class="etn-event-attendee-count">
                                    <i class="fa fa-user-plus"></i>
                                    <?php echo esc_html( \Etn_Pro\Core\Action::instance()->total_attendee( $value->ID ) ); ?>
                                    <?php echo esc_html__( 'People Joined', 'eventin-pro'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- content end-->
                </div>
                <!-- etn event item end -->
            </div>
            <!-- col end -->
            <?php
        }
    }
    wp_reset_postdata();
    ?>

</div>