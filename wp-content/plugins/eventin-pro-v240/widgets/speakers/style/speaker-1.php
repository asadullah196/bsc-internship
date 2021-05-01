<?php

use \Etn_Pro\Utils\Helper;

$data['etn_speaker_designation'] = get_post_meta($speaker_id, 'etn_speaker_designation', true);
$data['social']                 = get_post_meta($speaker_id, 'etn_speaker_socials', true);
$data['summery']                = get_post_meta($speaker_id, 'etn_speaker_summery', true);
$all_logo                       = get_post_meta($speaker_id, 'etn_speaker_company_logo', true);
$data['logo']                   = isset($all_logo) ? wp_get_attachment_image_src($all_logo) : array();
$data['photo']                  = has_post_thumbnail($speaker_id) ? get_the_post_thumbnail_url($speaker_id) : null;

if ( is_array($data) && !empty( $data ) ) {
    $social = array_key_exists("social", $data) ? $data["social"] : [];
    ?>
    <div class="etn-speaker-wrapper speaker-style1">
        <div class="etn-single-speaker-item">
            <div class="etn-speaker-thumb">
                <?php if (!is_null($data["photo"])) : ?>
                    <img src="<?php echo esc_url($data['photo']); ?>" class="img-fluid" alt="<?php echo esc_attr(get_the_title($speaker_id)); ?>">
                <?php endif; ?>
                <?php if ($show_social == 'yes') : ?>
                    <div class="etn-speakers-social">
                        <?php if (is_array($social)) { ?>
                            <?php foreach ($social as $social_value) {  ?>
                                <a href="<?php echo esc_url($social_value["etn_social_url"]); ?>" target="_blank" title="<?php echo esc_attr($social_value["etn_social_title"]); ?>"><i class="<?php echo esc_attr($social_value["icon"]); ?>"></i></a>
                            <?php  } ?>
                        <?php } ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="etn-speaker-content">
                <h3 class="etn-title etn-speaker-title"><a href="<?php echo esc_url(get_the_permalink($speaker_id)); ?>"> <?php echo esc_html(get_the_title($speaker_id)); ?></a> </h3>
                <?php if ($show_designation == 'yes') { ?>
                    <p>
                        <?php echo Helper::kses($data['etn_speaker_designation']); ?>
                    </p>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
}
