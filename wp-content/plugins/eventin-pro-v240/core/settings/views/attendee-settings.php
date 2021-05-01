<?php 
$settings =  \Etn\Core\Settings\Settings::instance()->get_settings_option();
?>
<div class="etn-label-item">
    <div class="etn-label">
        <label for="attendee_extra_field" class="etn-settings-label"><?php echo esc_html__('Extra field', "eventin-pro" ); ?></label>
        <p class="etn-desc"> <?php echo esc_html__("Extra field will be added in attendee form", "eventin-pro" ); ?> </p>
    </div>
    <div class="etn-meta">
        <div class="attendee_extra_main_block">
            <?php
            $attendee_extra_label       = isset($settings['attendee_extra_label']) ? $settings['attendee_extra_label'] : [];
            $attendee_extra_type        = isset($settings['attendee_extra_type']) ? $settings['attendee_extra_type'] : [];
            $attendee_extra_place_holder= isset($settings['attendee_extra_place_holder']) ? $settings['attendee_extra_place_holder'] : [];

            $input_type_array   = [
                'text'      => esc_html__('Text','eventin-pro'),
                'number'    => esc_html__('Number','eventin-pro'),
            ];

            if ( is_array($attendee_extra_label) && !empty($attendee_extra_label) && $attendee_extra_label['0'] !== '') {
                for ($index = 0; $index < count( $attendee_extra_label ); $index++) {
                    ?>
                    <div class="etn-attendee-field attendee_block mb-2">
                        <input type="text" name="attendee_extra_label[]" value="<?php echo \Etn_Pro\Utils\Helper::render($attendee_extra_label[$index]); ?>" class="attendee_extra_label mr-1 etn-settings-input etn-form-control" id="attendee_extra_label_<?php echo intval($index) ?>" placeholder="<?php esc_html_e('Input Label','eventin-pro');?>" />
                        <select name="attendee_extra_type[]" id="attendee_extra_type_<?php echo intval($index) ?>" class=" attendee_extra_type mr-1 etn-settings-input etn-form-control">
                            <option value="" selected><?php echo esc_html__('Select Input Type', 'eventin-pro');?></option><?php
                            foreach( $input_type_array as $key  => $value ){
                                ?>
                                <option <?php selected( $attendee_extra_type[$index], $key, true )?> value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value );?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <input type="text" name="attendee_extra_place_holder[]" value="<?php echo \Etn_Pro\Utils\Helper::render($attendee_extra_place_holder[$index]); ?>" class="attendee_extra_place_holder mr-1 etn-settings-input etn-form-control" id="attendee_extra_place_holder_<?php echo intval($index) ?>" placeholder="<?php esc_html_e('Input Placeholder','eventin-pro');?>" />
                        <?php 
                        if( $index != 0 ) { 
                            ?>
                            <span class="dashicons etn-btn dashicons dashicons-no-alt remove_attendee_extra_field pl-1">
                            </span>
                            <?php 
                        } 
                        ?>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="etn-attendee-field attendee_block mb-2">
                    <input type="text" name="attendee_extra_label[]" value="" class="attendee_extra_label mr-1 etn-settings-input etn-form-control" placeholder="<?php esc_html_e('Input Label','eventin-pro');?>" />
                    <select name="attendee_extra_type[]" class=" attendee_extra_type mr-1 etn-settings-input etn-form-control">
                        <option value="" selected><?php echo esc_html__('Select Input Type', 'eventin-pro');?></option>
                        <?php
                        foreach( $input_type_array as $key  => $value ){
                            ?>
                            <option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value );?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <input type="text" name="attendee_extra_place_holder[]" value="" class="attendee_extra_place_holder mr-1 etn-settings-input etn-form-control" placeholder="<?php esc_html_e('Input Placeholder','eventin-pro');?>" />
                </div>
                <?php
            }
            ?>
        </div>
        <div class="etn_flex_reverse attendee_extra_section">
            <span class="add_attendee_extra_block etn-btn" data-label_text="<?php echo esc_html__("Label text", "eventin-pro");?>" data-placeholder_text="<?php echo esc_html__("Placeholder text", "eventin-pro");?>" data-select_input_type_text="<?php echo esc_html__("Select Input Type", "eventin-pro");?>" data-input_type_text="<?php echo esc_html__("Text", "eventin-pro");?>" data-input_type_number="<?php echo esc_html__('Number', "eventin-pro");?>">
               <?php echo esc_html__('Add', 'eventin-pro');?>
            </span>
        </div>
    </div>
</div>