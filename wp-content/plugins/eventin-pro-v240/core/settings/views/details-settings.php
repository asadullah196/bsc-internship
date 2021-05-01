<?php
use Etn\Core\Settings\Settings as SettingsFree;
$settings                            = SettingsFree::instance()->get_settings_option();
$checked_hide_countdown_from_details  = isset( $settings['checked_hide_countdown_from_details'] ) ? 'checked' : '';
$hide_faq_from_details               = isset( $settings['hide_faq_from_details'] ) ? 'checked' : '';
$hide_social_from_details            = isset( $settings['hide_social_from_details'] ) ? 'checked' : '';
$hide_related_event_from_details     = isset( $settings['hide_related_event_from_details'] ) ? 'checked' : '';
$remainder_email_sending_day         = isset( $settings['remainder_email_sending_day'] ) ? $settings['remainder_email_sending_day'] : '';
?>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label>
            <?php esc_html_e( 'Hide Countdown', 'eventin-pro' );?>
        </label>
        <div class="etn-desc"> <?php esc_html_e( 'Hide countdown from event details.', 'eventin-pro' );?> </div>
    </div>
    <div class="etn-meta">
        <input id="checked_hide_countdown_from_details" type="checkbox" <?php echo esc_html( $checked_hide_countdown_from_details ); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="checked_hide_countdown_from_details" />
        <label for="checked_hide_countdown_from_details" class="etn_switch_button_label"></label>
    </div>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label>
            <?php esc_html_e( 'Hide FAQ', 'eventin-pro' );?>
        </label>
        <div class="etn-desc"> <?php esc_html_e( 'Hide frequently asked questions from event details.', 'eventin-pro' );?> </div>
    </div>
    <div class="etn-meta">
        <input id="hide_faq_from_details" type="checkbox" <?php echo esc_html( $hide_faq_from_details ); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="hide_faq_from_details" />
        <label for="hide_faq_from_details" class="etn_switch_button_label"></label>
    </div>
</div>

<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label>
            <?php esc_html_e( 'Hide social', 'eventin-pro' );?>
        </label>
        <div class="etn-desc"> <?php esc_html_e( 'Hide social from event details.', 'eventin-pro' );?> </div>
    </div>
    <div class="etn-meta">
        <input id="hide_social_from_details" type="checkbox" <?php echo esc_html( $hide_social_from_details ); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="hide_social_from_details" />
        <label for="hide_social_from_details" class="etn_switch_button_label"></label>
    </div>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label>
            <?php esc_html_e( 'Hide related event', 'eventin-pro' );?>
        </label>
        <div class="etn-desc"> <?php esc_html_e( 'Hide related event from event details.', 'eventin-pro' );?> </div>
    </div>
    <div class="etn-meta">
        <input id="hide_related_event_from_details" type="checkbox" <?php echo esc_html( $hide_related_event_from_details ); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="hide_related_event_from_details" />
        <label for="hide_related_event_from_details" class="etn_switch_button_label"></label>
    </div>
</div>

<?php return; ?>