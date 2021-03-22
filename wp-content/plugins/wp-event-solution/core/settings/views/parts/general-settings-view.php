<!-- General Tab -->
<div class="etn-settings-section attr-tab-pane" data-id="tab1" id="etn-general_options">
    <div class="etn-settings-single-section">
        <div class="etn-recaptcha-settings-wrapper">
            <div class="etn-recaptcha-settings">
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label>
                            <?php esc_html_e('Sell on Woocommerce', 'eventin'); ?>
                        </label>
                        <div class="etn-desc"> <?php esc_html_e('Sell event tickets through Woocommerce. This will require Woocommerce plugin.', 'eventin'); ?> </div>
                    </div>
                    <div class="etn-meta">
                        <input id='sell_tickets' type="checkbox" <?php echo esc_html($sell_tickets); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="sell_tickets" />
                        <label for="sell_tickets" class="etn_switch_button_label"></label>
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label class="etn-setting-label" for="admin_mail_address"><?php esc_html_e('Admin email address', 'eventin'); ?></label>
                        <div class="etn-desc"> <?php esc_html_e('Email will be sent from this mail address', 'eventin'); ?> </div>
                    </div>
                    <div class="etn-meta">
                    <input type="text" name="admin_mail_address"
                        value="<?php echo esc_attr( isset($settings['admin_mail_address'] ) && $settings['admin_mail_address'] !== '' ? $settings['admin_mail_address'] : wp_get_current_user()->data->user_email ); ?>"
                        class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e('Admin email address', 'eventin'); ?>">
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label class="etn-setting-label" for="captcha-method"><?php esc_html_e('Select Date Format', 'eventin'); ?></label>
                        <div class="etn-desc"> <?php esc_html_e('Select date format to display. For instance 15-01-2020.', 'eventin'); ?> </div>
                    </div>
                    <div class="etn-meta">
                        <select id="date_format" name="date_format" class="etn-setting-input attr-form-control etn-settings-select">
                            <option value=''> --- </option>
                            <?php
                            if( is_array( $date_formats ) ){
                                foreach ($date_formats as $key => $date_format) {
                                    ?>
                                    <option <?php echo esc_html( selected( $selected_date_format, $key, false) ); ?> value='<?php echo esc_attr( $key ); ?>'> <?php echo esc_html( date_i18n( $date_format, $sample_date) ); ?> </option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label for="captcha-method"><?php esc_html_e('Select Time Format:', 'eventin'); ?></label>
                        <div class="etn-desc"> <?php esc_html_e('Select time format. For instance 12h.', 'eventin'); ?> </div>
                    </div>
                    <div class="etn-meta">
                        <select id="time_format" name="time_format" class="etn-setting-input attr-form-control etn-settings-select">
                            <option value=''> --- </option>
                            <option value="24" <?php echo esc_html(selected($selected_time_format, '24', false)); ?>> <?php echo esc_html__('24h', 'eventin'); ?> </option>
                            <option value="12" <?php echo esc_html(selected($selected_time_format, '12', false)); ?>><?php echo esc_html__('12h', 'eventin'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label for="captcha-method"><?php esc_html_e( 'Select event expiry point', 'eventin' );?></label>
                        <div class="etn-desc"> <?php esc_html_e( 'Event will be exipred at the selected point.Event filtering in event report will be applied from selected point.', 'eventin' );?> </div>
                    </div>
                    <div class="etn-meta">
                        <select id="expiry_point" name="expiry_point" class="etn-setting-input attr-form-control etn-settings-select">
                            <option value=''> --- </option>
                            <option value="start" <?php echo esc_html( selected( $selected_expiry_point, 'start', false ) ); ?>> <?php echo esc_html__( 'Starting Date', 'eventin' ); ?> </option>
                            <option value="end" <?php echo esc_html( selected( $selected_expiry_point, 'end', false ) ); ?>><?php echo esc_html__( 'Ending Date', 'eventin' ); ?></option>
                        </select>
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label>
                            <?php esc_html_e( 'Disable registration after event is expired', 'eventin' );?>
                        </label>
                        <div class="etn-desc"> <?php esc_html_e( 'Turn off registration once event is expired', 'eventin' );?> </div>
                    </div>
                    <div class="etn-meta">
                        <input id='disable_registration_if_expired' type="checkbox" <?php echo esc_html( $is_registration_disabled_if_expired ); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="disable_registration_if_expired" />
                        <label for="disable_registration_if_expired" class="etn_switch_button_label"></label>
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label for="captcha-method"><?php esc_html_e( 'Select event template', 'eventin' );?></label>
                        <div class="etn-desc"> <?php esc_html_e( 'Event single page template.', 'eventin' );?> </div>
                    </div>
                    <div class="etn-meta">
                        <select id="event_template" name="event_template" class="etn-setting-input attr-form-control etn-settings-select">
                            <option value=''> --- </option>
                            <?php 
                            foreach( $event_template_array as $key => $value ){
                                ?>
                                <option value="<?php echo esc_attr( $key ); ?>" <?php echo esc_html( selected( $selected_event_template, $key, false ) ); ?>> <?php echo esc_html( $value ); ?> </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label for="captcha-method"><?php esc_html_e( 'Select speaker template', 'eventin' );?></label>
                        <div class="etn-desc"> <?php esc_html_e( 'Speaker single page template.', 'eventin' );?> </div>
                    </div>
                    <div class="etn-meta">
                        <select id="speaker_template" name="speaker_template" class="etn-setting-input attr-form-control etn-settings-select">
                            <option value=''> --- </option>
                            <?php 
                            foreach( $speaker_template_array as $key => $value ){
                                ?>
                                <option value="<?php echo esc_attr( $key ); ?>" <?php echo esc_html( selected( $selected_speaker_template, $key, false ) ); ?>> <?php echo esc_html( $value ); ?> </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label>
                            <?php esc_html_e('Include Into Search', 'eventin'); ?>
                        </label>
                        <div class="etn-desc"> <?php esc_html_e('Do you want to include events into search ? This will also enable taxonomy archive pages', 'eventin'); ?> </div>
                    </div>
                    <div class="etn-meta">
                        <select value='on' id="checked_exclude_from_search" name='etn_include_from_search' class="etn-setting-input attr-form-control etn-settings-select">
                            <option value=''> --- </option>
                            <option value='on' <?php echo esc_html( selected( $checked_exclude_from_search, 'on', false ) ); ?>> <?php echo esc_html__( 'Yes', 'eventin' ); ?> </option>
                            <option value='off' <?php echo esc_html( selected( $checked_exclude_from_search, 'off', false ) ); ?>> <?php echo esc_html( 'No', 'eventin' ); ?> </option>
                        </select>
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label>
                            <?php esc_html_e('Require login', 'eventin'); ?>
                        </label>
                        <div class="etn-desc"> <?php esc_html_e('Require login to purchase event ticket', 'eventin'); ?> </div>
                    </div>
                    <div class="etn-meta">
                        <input id="checked_purchase_login_required" type="checkbox" <?php echo esc_html($checked_purchase_login_required); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="etn_purchase_login_required" />
                        <label for="checked_purchase_login_required" class="etn_switch_button_label"></label>
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label>
                            <?php esc_html_e('Hide Expired Events', 'eventin'); ?>
                        </label>
                        <div class="etn-desc"> <?php esc_html_e('Hide expired events from event listing', 'eventin'); ?> </div>
                    </div>
                    <div class="etn-meta">
                        <input id="hide_expired_events" type="checkbox" <?php echo esc_html($checked_expired_event); ?> class="etn-admin-control-input etn-form-modalinput-paypal_sandbox" name="checked_expired_event" />
                        <label for="hide_expired_events" class="etn_switch_button_label"></label>
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label><?php esc_html_e('Price label text', 'eventin'); ?> </label>
                        <div class="etn-desc"> <?php esc_html_e('Place price label', 'eventin'); ?> </div>

                    </div>
                    <div class="etn-meta">
                        <input type="text" name="etn_price_label" value="<?php echo esc_attr(isset($etn_price_label) ? $etn_price_label : ''); ?>" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e('Label Text', 'eventin'); ?>">
                    </div>
                </div>
                <h2 class="etn-wrap-title"><?php echo esc_html__( 'Slug options','eventin' )?></h2>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label><?php esc_html_e('Event slug name', 'eventin'); ?> </label>
                        <div class="etn-desc"> <?php esc_html_e('Place event slug here', 'eventin'); ?> </div>

                    </div>
                    <div class="etn-meta">
                        <input type="text" name="event_slug" value="<?php echo esc_attr(isset($event_slug) ? $event_slug : ''); ?>" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e('Event slug', 'eventin'); ?>">
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label><?php esc_html_e('Speaker slug name', 'eventin'); ?> </label>
                        <div class="etn-desc"> <?php esc_html_e('Place speaker slug here', 'eventin'); ?> </div>

                    </div>
                    <div class="etn-meta">
                        <input type="text" name="speaker_slug" value="<?php echo esc_attr(isset( $speaker_slug) ? $speaker_slug : ''); ?>" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e('Speaker slug', 'eventin'); ?>">
                    </div>
                </div>

                <h2 class="etn-wrap-title"><?php echo esc_html__( 'Color options','eventin' )?></h2>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label><?php esc_html_e('Primary color', 'eventin'  ); ?></label>
                        <div class="etn-desc"> <?php esc_html_e("Choose primary color", 'eventin'  ); ?> </div>
                    </div>
                    <div class="etn-meta">
                        <input type="text" name="etn_primary_color" id="etn_primary_color"
                        value="<?php echo esc_attr( isset($settings['etn_primary_color'] ) ? $settings['etn_primary_color'] : ''); ?>"
                        />
                    </div>
                </div>
                <div class="attr-form-group etn-label-item">
                    <div class="etn-label">
                        <label for="etn_secondary_color"><?php esc_html_e('Secondary color', 'eventin'  ); ?></label>
                        <div class="etn-desc"> <?php esc_html_e("Choose secondary color for menu", 'eventin'  ); ?> </div>
                    </div>
                    <div class="etn-meta">
                        <input type="text" name="etn_secondary_color" id="etn_secondary_color"
                        value="<?php echo esc_attr( isset($settings['etn_secondary_color'] ) ? $settings['etn_secondary_color'] : ''); ?>"
                        />
                    </div>
                </div>

                <?php
                    if( is_array( $settings_arr ) && isset( $settings_arr['remainder_email'] ) && file_exists( $settings_arr['remainder_email'] )){
                        include_once $settings_arr['remainder_email'];
                    }

                    if( is_array( $settings_arr ) && isset( $settings_arr['pro_license_options'] ) && file_exists( $settings_arr['pro_license_options'] )){
                        include_once $settings_arr['pro_license_options'];
                    }
                ?>
            </div>
        </div>
    </div>

</div>
<!-- ./End General Tab -->