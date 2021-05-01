<?php

use \Etn_Pro\Utils\Helper;

$speaker_id                      = $settings["speaker_id"];
$data['etn_speaker_designation'] = get_post_meta($speaker_id, 'etn_speaker_designation', true);
$data['social']                  = get_post_meta($speaker_id, 'etn_speaker_socials', true);
$data['summery']                 = get_post_meta($speaker_id, 'etn_speaker_summery', true);
$data['email']                   = get_post_meta($speaker_id, 'etn_speaker_website_email', true);
$data['url']                     = get_post_meta($speaker_id, 'etn_speaker_url', true);

$all_logo                        = get_post_meta($speaker_id, 'etn_speaker_company_logo', true);
$data['logo']                    = isset($all_logo) ? wp_get_attachment_image_src($all_logo, 'full') : array();
$data['photo']                   = has_post_thumbnail($speaker_id) ? get_the_post_thumbnail_url($speaker_id) : null;

if (is_array($data) && !empty($data)) {
    $social = array_key_exists("social", $data) ? $data["social"] : [];
    ?>
    <div class="etn-speaker-wrapper">
        <div class="etn-organizer-item">
            <?php if (  !empty($logo) && ( "" != $data["logo"][0]) )  : ?>
                <div class="etn-organizer-company-logo">
                    <a href="<?php echo esc_url($data['url']); ?>" target="_blank">
                        <img src="<?php echo esc_url($data['logo'][0]); ?>" class="img-fluid" alt="<?php the_title_attribute($speaker_id); ?>">
                    </a>
                </div>
            <?php endif; ?>
            <ul class="etn-organizer-content">
                <?php if (isset($data['email']) && $data['email'] != '') : ?>
                    <li>
                        <strong>
                            <?php echo esc_html__('Email : ', 'eventin-pro'); ?>
                        </strong>
                        <a class="etn-speaker-mail-anchor" href="mailto:<?php echo esc_attr($data['email']); ?>"><?php echo esc_html($data['email']); ?></a>
                    </li>
                <?php endif; ?>
                <?php if (is_array($social) && !empty($social)) { ?>
                    <li>
                        <strong>
                            <?php echo esc_html__('Social : ', 'eventin-pro'); ?>
                        </strong>
                        <div class="etn-organizer-social">
                                <?php foreach ($social as $social_value) {  ?>
                                    <a target="_blank" href="<?php echo esc_url($social_value["etn_social_url"]); ?>" title="<?php echo esc_attr($social_value["etn_social_title"]); ?>">
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
