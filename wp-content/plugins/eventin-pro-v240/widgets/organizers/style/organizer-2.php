<?php
use \Etn_Pro\Utils\Helper;

$data = Helper::post_data_query( "etn-speaker" , $etn_speaker_count, $etn_speaker_order, $category_id , 'etn_speaker_category',null, null, null, $orderby_meta, $orderby  );
if ( !empty( $data ) ) {?>
    <div class='etn-row etn-speaker-wrapper'>
        <?php
          foreach( $data as $value ) { 
            $etn_speaker_designation    = get_post_meta($value->ID, 'etn_speaker_designation', true);
            $etn_speaker_website_email  = get_post_meta($value->ID, 'etn_speaker_website_email', true);
            $social                     = get_post_meta($value->ID, 'etn_speaker_socials', true);

            $etn_company_logo = '';
            if ($etn_speaker_company_logo == 'yes') {
                $etn_speaker_id       = get_post_meta($value->ID, 'etn_speaker_company_logo', true);
                $etn_company_logo_src =  Helper::img_meta($etn_speaker_id);
                $etn_company_logo    .= is_array($etn_company_logo_src) ? $etn_company_logo_src['src'] : '';
            }

            $etn_sepeaker_url_src = ( $show_url == 'yes' ) ? get_post_meta( $value->ID, 'etn_speaker_url', true ) : "#";
            ?>
            <div class="etn-col-lg-<?php echo esc_attr($etn_speaker_col); ?> etn-col-md-6">
                <div class="etn-organizer-item">
                    <?php if ($etn_company_logo != '') : ?>
                        <div class="etn-organizer-company-logo">
                            <a href="<?php echo esc_url($etn_sepeaker_url_src); ?>" target="_blank">
                                <img src='<?php echo esc_url($etn_company_logo); ?>' class="img-fluid" alt="<?php the_title_attribute(); ?>">
                            </a>
                        </div>
                    <?php endif; ?>

                    <ul class="etn-organizer-content">
                        <?php if (isset($etn_speaker_website_email) && $etn_speaker_website_email != '') : ?>
                            <li>
                                <strong>
                                    <?php echo esc_html__('Email : ', 'eventin-pro'); ?>
                                </strong>
                                <a class="etn-speaker-mail-anchor" href="mailto:<?php echo esc_attr($etn_speaker_website_email); ?>"><?php echo esc_html($etn_speaker_website_email); ?></a>
                            </li>
                        <?php endif; ?>
                        <?php if (is_array( $social ) && !empty( $social )) { ?>
                            <li>
                                <strong>
                                    <?php echo esc_html__('Social : ', 'eventin-pro'); ?>
                                </strong>
                                <div class="etn-organizer-social">
                                        <?php foreach ($social as $social_value) {  ?>
                                            <a  target="_blank" href="<?php echo esc_url($social_value["etn_social_url"]); ?>" title="<?php echo esc_attr($social_value["etn_social_title"]); ?>">
                                                <i class="<?php echo esc_attr($social_value["icon"]); ?>"></i>
                                            </a>
                                        <?php  } ?>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <?php 
        }
        ?>
    </div>
<?php } 