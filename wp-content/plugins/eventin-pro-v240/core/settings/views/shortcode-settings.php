
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label><?php esc_html_e( 'Organizer List (Pro)', 'eventin-pro' );?> </label>
        <div class="etn-desc"> <?php esc_html_e( "Use id of the category which is being used as speaker. You can use [etn_pro_organizers cat_id='3' orderby='title' order='DESC' limit='3'  url='yes' logo='yes']", 'eventin-pro' );?></div>
    </div>
    <div class="etn-meta">
        <input type="text" readonly name="etn_pro_organizers" id="etn_pro_organizers" value="[etn_pro_organizers cat_id='3' orderby='title' order='DESC' limit='3'  url='yes' logo='yes']" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e( 'Label Text', 'eventin-pro' );?>" />
        <button type="button" onclick="copyTextData('etn_pro_organizers');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
    </div>
</div>

<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label><?php esc_html_e( 'Speaker Classic List (Pro)', 'eventin-pro' );?> </label>
        <div class="etn-desc"> <?php esc_html_e( "Use id of the category which is being used as speaker. You can use [etn_pro_speakers_classic speakers_category='2' speaker_count='6' orderby='title / post_date / ID / name' order='DESC / ASC' show_designation='yes' show_social='yes']", 'eventin-pro' );?></div>
    </div>
    <div class="etn-meta">
        <input type="text" readonly name="speaker_classic_list_pro" id="speaker_classic_list_pro" value="[etn_pro_speakers_classic speakers_category ='2' speaker_count ='6' orderby='title' order='ASC' show_designation='yes' show_social='yes']" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e( 'Label Text', 'eventin-pro' );?>" />
        <button type="button" onclick="copyTextData('speaker_classic_list_pro');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
    </div>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label><?php esc_html_e( 'Speaker Standard List (Pro)', 'eventin-pro' );?> </label>
        <div class="etn-desc"> <?php esc_html_e( "Use id of the category which is being used as speaker. You can use [etn_pro_speakers_standard speakers_category='2' speaker_count='6' orderby='title / post_date / ID / name' order='ASC / DESC' show_designation='yes' show_social ='yes']", 'eventin-pro' );?></div>
    </div>
    <div class="etn-meta">
        <input type="text" readonly name="speaker_standard_list_pro" id="speaker_standard_list_pro" value="[etn_pro_speakers_standard speakers_category='2' speaker_count='6' orderby='title' order='ASC' show_designation='yes' show_social ='yes']" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e( 'Label Text', 'eventin-pro' );?>" />
        <button type="button" onclick="copyTextData('speaker_standard_list_pro');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
    </div>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label><?php esc_html_e( 'Speaker Slider (Pro)', 'eventin-pro' );?> </label>
        <div class="etn-desc"> <?php esc_html_e( "Use id of the category which is being used as speaker. You can use [etn_pro_speakers_sliders categories_id='2' speaker_count ='6' slider_count='3' style='style-1' orderby='title / post_date / ID / name' order='ASC / DESC' show_designation='yes' show_social ='yes']", 'eventin-pro' );?></div>
    </div>
    <div class="etn-meta">
        <input type="text" readonly name="etn_pro_speakers_sliders" id="etn_pro_speakers_sliders" value="[etn_pro_speakers_sliders categories_id='2' speaker_count ='6' slider_count='3' style='style-1' orderby='title' order='ASC' show_designation='yes' show_social ='yes']" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e( 'Label Text', 'eventin-pro' );?>" />
        <button type="button" onclick="copyTextData('etn_pro_speakers_sliders');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
    </div>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label><?php esc_html_e( 'Event Classic List(Pro)', 'eventin-pro' );?> </label>
        <div class="etn-desc"> <?php esc_html_e( "You can use [etn_pro_events_classic event_count ='6' order='DESC' desc_limit='25' event_cat_ids='1,2' event_tag_ids='1,2']", 'eventin-pro' );?></div>

    </div>
    <div class="etn-meta">
        <input type="text" readonly name="event_classic_list_pro" id="event_classic_list_pro" value="[etn_pro_events_classic event_count ='6' order='DESC' desc_limit='25']" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e( 'Label Text', 'eventin-pro' );?>" />
        <button type="button" onclick="copyTextData('event_classic_list_pro');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
    </div>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label><?php esc_html_e( 'Event Standard List(Pro)', 'eventin-pro' );?> </label>
        <div class="etn-desc"> <?php esc_html_e( "You can use [etn_pro_events_standard event_count ='6' order='DESC' desc_limit='25' event_cat_ids='1,2' event_tag_ids='1,2']", 'eventin-pro' );?></div>
        </div>
    <div class="etn-meta">
        <input type="text" readonly name="event_standard_list_pro" id="event_standard_list_pro" value="[etn_pro_events_standard event_count ='6' order='DESC' desc_limit='25']" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e( 'Label Text', 'eventin-pro' );?>" />
        <button type="button" onclick="copyTextData('event_standard_list_pro');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
    </div>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label><?php esc_html_e( 'Event Sliders(Pro)', 'eventin-pro' );?> </label>
        <div class="etn-desc"> <?php esc_html_e( "You can use [etn_pro_events_sliders style= 'event-1'  event_slider_count='2' order='DESC' event_cat_ids='1,2' event_tag_ids='1,2']", 'eventin-pro' );?></div>
        </div>
    <div class="etn-meta">
        <input type="text" readonly name="etn_pro_events_sliders" id="etn_pro_events_sliders" value="[etn_pro_events_sliders event_cat_ids='' style= 'event-1'  event_slider_count='2' order='DESC']" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e( 'Label Text', 'eventin-pro' );?>" />
        <button type="button" onclick="copyTextData('etn_pro_events_sliders');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
    </div>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label><?php esc_html_e( 'Event Countdown (Pro)', 'eventin-pro' );?> </label>
        <div class="etn-desc"> <?php esc_html_e( "You can use [etn_pro_countdown event_id='18']", 'eventin-pro' );?></div>
    </div>
    <div class="etn-meta">
        <input type="text" readonly name="event_countdown_pro" id="event_countdown_pro" value="[etn_pro_countdown event_id='18']" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e( 'Label Text', 'eventin-pro' );?>" />
        <button type="button" onclick="copyTextData('event_countdown_pro');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
    </div>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label><?php esc_html_e( 'Event Schedules Tab (Pro)', 'eventin-pro' );?> </label>
        <div class="etn-desc"> <?php esc_html_e( "You can use [etn_pro_schedules_tab ids='16,33' order='asc']", 'eventin-pro' );?></div>
    </div>
    <div class="etn-meta">
        <input type="text" readonly name="schedule_tab_pro" id="schedule_tab_pro" value="[etn_pro_schedules_tab ids='16,33' order='asc']" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e( 'Label Text', 'eventin-pro' );?>" />
        <button type="button" onclick="copyTextData('schedule_tab_pro');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
    </div>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label><?php esc_html_e( 'Event Schedules List (Pro)', 'eventin-pro' );?> </label>
        <div class="etn-desc"> <?php esc_html_e( "You can use [etn_pro_schedules_list style='style-1' id='16']", 'eventin-pro' );?></div>
    </div>
    <div class="etn-meta">
        <input type="text" readonly name="schedule_list_pro" id="schedule_list_pro" value="[etn_pro_schedules_list style='style-1' id='16']" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e( 'Label Text', 'eventin-pro' );?>" />
        <button type="button" onclick="copyTextData('schedule_list_pro');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
    </div>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label><?php esc_html_e( 'Event Ticket Form (Pro)', 'eventin-pro' );?> </label>
        <div class="etn-desc"> <?php esc_html_e( "You can use [etn_pro_ticket_form id='7' show_title='yes' ]", 'eventin-pro' );?></div>
    </div>
    <div class="etn-meta">
        <input type="text" readonly name="event_ticket_form_pro" id="event_ticket_form_pro" value="[etn_pro_ticket_form id='7' show_title='yes' ]" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e( 'Label Text', 'eventin-pro' );?>" />
        <button type="button" onclick="copyTextData('event_ticket_form_pro');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
    </div>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label><?php esc_html_e( 'Related Events Widget (Pro)', 'eventin-pro' );?> </label>
        <div class="etn-desc"> <?php esc_html_e( "You can use [etn_pro_related_events id='16' /]", 'eventin-pro' );?></div>
    </div>
    <div class="etn-meta">
        <input type="text" readonly name="related_events_pro" id="related_events_pro" value="[etn_pro_related_events id='16' /]" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e( 'Label Text', 'eventin-pro' );?>" />
        <button type="button" onclick="copyTextData('related_events_pro');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
    </div>
</div>
<div class="attr-form-group etn-label-item">
    <div class="etn-label">
        <label><?php esc_html_e( 'Attendee List Widget (Pro)', 'eventin-pro' );?> </label>
        <div class="etn-desc"> <?php esc_html_e( "You can use [etn_pro_attendee_list id='16' /]", 'eventin-pro' );?></div>
    </div>
    <div class="etn-meta">
        <input type="text" readonly name="etn_pro_attendee_list" id="etn_pro_attendee_list" value="[etn_pro_attendee_list id='16' /]" class="etn-setting-input attr-form-control etn-recaptcha-secret-key" placeholder="<?php esc_html_e( 'Label Text', 'eventin-pro' );?>" />
        <button type="button" onclick="copyTextData('etn_pro_attendee_list');" class="etn_copy_button etn-btn"><span class="dashicons dashicons-category"></span></button>
    </div>
</div>

<?php return; ?>