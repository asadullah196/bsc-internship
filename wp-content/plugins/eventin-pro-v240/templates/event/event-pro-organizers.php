<?php

defined( 'ABSPATH' ) || exit;

use Etn_Pro\Utils\Helper;

?>
<div class="etn-event-organizers etn-organizer-style-1">
    <h4 class="etn-title">
    <?php  
        $event_organizers_title = apply_filters( 'etn_event_organizers_title', esc_html__("Organizer:",  'eventin-pro' ) );
        echo esc_html( $event_organizers_title );
    ?> 
    </h4>
    <?php
    $term_details = get_term_by('slug',  $etn_organizer_events, 'etn_speaker_category');
    $organizer_term_id = $term_details->term_id;

    $data = Helper::post_data_query('etn-speaker', -1 , 'DESC' , [$organizer_term_id] , 'etn_speaker_category' , null, null );
    ?>
    <div class="etn-organizer-wrap">
        <?php
        if (isset( $data ) && !empty( $data )) {
            foreach ($data as $value) { 
                $social = get_post_meta( $value->ID , 'etn_speaker_socials', true);
                $email = get_post_meta( $value->ID , 'etn_speaker_website_email', true);
                $etn_speaker_company_logo = get_post_meta( $value->ID , 'etn_speaker_company_logo', true);
                $logo = wp_get_attachment_image_src($etn_speaker_company_logo, 'full');
                ?>
                <div class="etn-organaizer-item">
                    <?php 
                    if (isset($logo[0])) { 
                        ?>
                        <div class="etn-organizer-logo">
                            <img src="<?php echo esc_url($logo[0]); ?>" alt="<?php the_title_attribute(); ?>">
                        </div>
                        <?php 
                    } ?>
                    <h4 class="etn-organizer-name">
                        <?php echo esc_html( get_the_title( $value->ID ) ); ?>
                    </h4> 
                    <?php 
                    if ($email) { 
                        ?>
                        <div class="etn-organizer-email">
                            <span class="etn-label-name">
                                <?php echo esc_html__('Email :',  'eventin-pro' ); ?>
                            </span>
                            <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                        </div>
                        <?php 
                    } 
                    ?>
                    <?php 
                    if (is_array( $social ) && !empty( $social ) ) { 
                        ?>
                        <div class="etn-social etn-social-style-1">
                            <span class="etn-label-name"><?php echo esc_html__('Social :',  'eventin-pro' ); ?></span>
                                <?php 
                                foreach ($social as $social_value) {  
                                    ?>
                                    <?php $etn_social_class = 'etn-' . str_replace('fab fa-', '', $social_value['icon']); ?>
                                    <a target="_blank" href="<?php echo esc_url($social_value["etn_social_url"]); ?>" target="_blank" class="<?php echo esc_attr($etn_social_class); ?>" title="<?php echo esc_attr($social_value["etn_social_title"]); ?>"><i class="<?php echo esc_attr($social_value["icon"]); ?>"></i></a>
                                    <?php  
                                } 
                                ?>
                        </div>
                        <?php 
                    } 
                    ?>
                </div>
                <?php
            }
            wp_reset_postdata();
        }
        ?>
    </div>
</div>