<?php
use Etn\Core\Settings\Settings as SettingsFree;
$settings                            = SettingsFree::instance()->get_settings_option();
$remainder_message                   = isset( $settings['remainder_message'] ) ? $settings['remainder_message'] : '';

?>
<div class="etn-title-wrap">
    <h2 class="etn-wrap-title"><?php echo esc_html__( 'Notifications', 'eventin-pro' ) ?></h2>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label>
            <?php esc_html_e( 'Remainder email sending time', 'eventin-pro' );?>
        </label>
        <div class="etn-desc"> <?php esc_html_e( 'Reminder email will be sent X day(s) before event starting time', 'eventin-pro' );?> </div>
    </div>
    <div class="etn-meta">
        <input id='remainder_email_sending_day' type="number" value="<?php echo esc_html( $remainder_email_sending_day ); ?>" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" name="remainder_email_sending_day" placeholder="1" min="1" max="365"/>
    </div>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label>
            <?php esc_html_e( 'Remainder email message', 'eventin-pro' );?>
        </label>
        <div class="etn-desc"> <?php esc_html_e( 'Reminder email message text', 'eventin-pro' );?> </div>
    </div>
    <div class="etn-meta">
        <textarea id='remainder_message' rows="10" cols="5" class="etn-setting-input etn-msg-box attr-form-control etn-recaptcha-secret-key" name="remainder_message"><?php echo esc_html( $remainder_message ); ?></textarea>
    </div>
</div>

<?php return; ?>