<?php
defined( 'ABSPATH' ) || exit;

$etn_speaker_socials_two            = get_post_meta(get_the_id(), 'etn_speaker_socials', true);
?>
    <div class="etn-social etn-social-two">
        <?php if (is_array( $etn_speaker_socials_two ) ) : ?>
            <?php foreach ($etn_speaker_socials_two as $social) : ?>
                <?php $etn_social_class = 'etn-' . str_replace('fab fa-', '', $social['icon']); ?>
                <a href="<?php echo esc_url($social['etn_social_url']); ?>" target="_blank" class="<?php echo esc_attr($etn_social_class); ?>"> <i class="<?php echo esc_attr($social['icon']); ?>"></i> </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>