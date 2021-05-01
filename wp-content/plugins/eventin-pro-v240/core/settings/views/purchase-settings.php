<?php
$license_settings               = \Etn_Pro\Utils\Helper::get_option( "license" );
$enable_license                 =  (!empty($license_settings) ? 'checked' : '');
?>
<div class="etn-title-wrap">
    <h2 class="etn-wrap-title"><?php esc_html_e('License Settings', 'eventin-pro'  ); ?></h2>
</div>
<div class="etn-label-item">
    <div class="etn-label">
        <label for="license"><?php esc_html_e("Enable Licensing", "eventin-pro" ); ?></label>
        <div class="etn-desc"> <?php esc_html_e("Enable licensing for premium version. This will be used for automatic update and premium support", "eventin-pro" ); ?></div>
    </div>
    <div class="etn-meta">
        
        <div class="etn-meta">
            <input id="license" type="checkbox" <?php echo esc_attr( $enable_license );  ?> class="etn-admin-control-input" name="license">
            <label for="license" class="etn_switch_button_label"></label>
        </div>
    </div>
</div>

<?php return; ?>