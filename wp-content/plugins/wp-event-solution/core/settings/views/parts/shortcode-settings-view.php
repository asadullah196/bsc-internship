<!-- hooks -->
<div class="attr-tab-pane etn-settings-section etn-shortcode-settings" data-id="tab5" id="etn-hooks_options">
    <div class="etn-settings-single-section">
        <div class="attr-form-group etn-label-item">
            <div class="etn-label">
                <label><?php esc_html_e('Event List', 'eventin'); ?> </label>
                <div class="etn-desc"> <?php esc_html_e("You can use [events limit='1' event_cat_ids='1,2' event_tag_ids='1,2' /]", 'eventin'); ?> </div>
            </div>
            <div class="etn-meta">
                <input type="text" readonly name="etn_event_label" id="event_list" value="[events]" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e('Label Text', 'eventin'); ?>">
                <button type="button" onclick="copyTextData('event_list');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
            </div>
        </div>
        <div class="attr-form-group etn-label-item">
            <div class="etn-label">
                <label><?php esc_html_e('Speaker List', 'eventin'); ?> </label>
                <div class="etn-desc"> <?php esc_html_e("Use id of the category which is being used as speaker. You can use [speakers cat_id='19' orderby='title / post_id / ID / name' order='ASC/DESC' limit='3'/]", 'eventin'); ?> </div>
            </div>
            <div class="etn-meta">
                <input type="text" readonly name="etn_speaker_label" id="speaker_list" value="[speakers cat_id='19' orderby='title' order='DESC' limit='3']" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e('Label Text', 'eventin'); ?>">
                <button type="button" onclick="copyTextData('speaker_list');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
            </div>
        </div>
        <div class="attr-form-group etn-label-item">
            <div class="etn-label">
                <label><?php esc_html_e('Schedule List', 'eventin'); ?> </label>
                <div class="etn-desc"> <?php esc_html_e("Use comma seperated schedule id's that you want to show in schedule list", 'eventin'); ?> </div>
            </div>
            <div class="etn-meta">
                <input type="text" readonly name="etn_schedule_label" id="schedule_list" value="[schedules ids ='18,19'/]" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e('Label Text', 'eventin'); ?>">
                <button type="button" onclick="copyTextData('schedule_list');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
            </div>
        </div>
        <?php
        if (isset($settings['etn_zoom_api']) &&  $settings['etn_zoom_api'] == 'on') {
        ?>
            <div class="attr-form-group etn-label-item">
                <div class="etn-label">
                    <label><?php esc_html_e('Zoom meeting details', 'eventin'); ?> </label>
                    <div class="etn-desc"> <?php esc_html_e("Use meeting id to show meeting details. You can use [etn_zoom_api_link meeting_id=''  link_only='yes'] ", 'eventin'); ?> </div>

                </div>
                <div class="etn-meta">
                    <input type="text" readonly name="meeting_info" id="etn_zoom_metting" value="[etn_zoom_api_link meeting_id ='123456789' link_only='no']" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e('Label Text', 'eventin'); ?>">
                    <button type="button" onclick="copyTextData('etn_zoom_metting');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
                </div>
            </div>
        <?php
        }
        if( is_array( $settings_arr ) && isset( $settings_arr['pro_shortcode'] )  && file_exists($settings_arr['pro_shortcode'])){
            include $settings_arr['pro_shortcode'];
        }
        ?>
    </div>
</div>