<?php

defined( 'ABSPATH' ) || exit;

?>
<div class="etn-event-meta-info etn-widget">
    <ul>
        <?php if (!isset($event_options["etn_hide_time_from_details"])) { ?>
            <li>
                <span><?php echo esc_html__('Time : ', 'eventin-pro'); ?></span>
                <?php echo esc_html($data['event_start_time'] . " - " . $data['event_end_time']); ?>
            </li>
        <?php } ?>
        <li>
            <span><?php echo esc_html__('Registration Deadline : ', 'eventin-pro'); ?></span>
            <?php echo esc_html($data['etn_deadline_value']); ?>
        </li>
        <?php if (!isset($event_options["hide_social_from_details"]) && is_array($data['etn_event_socials']) && !empty( $data['etn_event_socials'] )) { ?>
            <li>
                <div class="etn-social">
                    <a href="#" class="share-icon">
                        <i class="fas fa-share-alt"></i>
                    </a>
                    <?php foreach ($data['etn_event_socials'] as $social) : ?>
                        <?php $etn_social_class = 'etn-' . str_replace('fab fa-', '', $social['icon']); ?>
                        <a href="<?php echo esc_url($social['etn_social_url']); ?>" target="_blank" class="<?php echo esc_attr($etn_social_class); ?>"> <i class="<?php echo esc_attr($social['icon']); ?>"></i> </a>
                    <?php endforeach; ?>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>