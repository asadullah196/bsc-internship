<?php

use Etn\Utils\Helper;

$get_arr = filter_input_array( INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS );

if( empty( $get_arr["attendee_id"] ) || empty( $get_arr["etn_info_edit_token"] ) ){
    Helper::show_attendee_pdf_invalid_data_page();
    exit;
}

if( !Helper::verify_attendee_edit_token( $get_arr["attendee_id"], $get_arr["etn_info_edit_token"] ) ){
    Helper::show_attendee_pdf_invalid_data_page();
    exit;
}

    $user_id            = is_numeric( $get_arr["attendee_id"] ) ? $get_arr["attendee_id"] : 0;
    $access_token       = $get_arr['etn_info_edit_token'];
    $attendee_data      = Helper::get_attendee_by_token( 'etn_info_edit_token', $access_token  );
    $attendee_name      = get_the_title( $user_id );
    $attendee_email     = get_post_meta( $user_id, "etn_email", true );
    $attendee_phone     = get_post_meta( $user_id, "etn_phone", true );
    $base_url           = home_url( );
    $attendee_cpt       = new \Etn\Core\Attendee\Cpt();
    $attendee_endpoint  = $attendee_cpt->get_name();
    $action_url         = $base_url . "/" . $attendee_endpoint;
    wp_head(  );
    ?>
    <div class="etn-es-events-page-container">
        <div class="etn-event-single-wrap">
            <div class="etn-container">
                <div class="etn-attendee-form">
                    <h3 class="attendee-title"><?php echo esc_html__( "Update Attendee Details", "eventin" ); ?></h3>
                    <hr>
                    <form action="<?php echo esc_url( $action_url );?>" method="post" class="attende_form">
                        <div class="etn-attendee-form-wrap">
                            <div class="etn-name-field etn-group-field">
                                <label for="etn_product_qty">
                                    <?php echo esc_html__( 'Name', "eventin" ); ?>
                                    <span class="etn-input-field-required"> *</span>
                                </label>
                                <input required placeholder="<?php echo esc_html__('Enter attendee full name', 'eventin'); ?>" class="attr-form-control" id="attendee_name" name="name" type="text" value="<?php echo esc_html( $attendee_name ); ?>" required/>
                                <div class="etn-error attendee_name"></div>   
                            </div>
                            <?php 
                            if( $include_email ){
                                ?>
                                <div class="etn-email-field etn-group-field">
                                    <label for="etn_product_qty">
                                        <?php echo esc_html__( 'Email', "eventin" ); ?>
                                        <span class="etn-input-field-required"> *</span>
                                    </label>
                                    <input required placeholder="<?php echo esc_html__('Enter email address', 'eventin'); ?>"  class="attr-form-control"  id="attendee_email" name="email" type="email" value="<?php echo esc_html( $attendee_email ); ?>" required/>
                                    <div class="etn-error attendee_email"></div>   
                                </div>
                                <?php
                            }
                            ?>
                            <?php
                            if( $include_phone ) {
                                ?>
                                <div class="etn-phone-field etn-group-field">
                                    <label for="etn_product_qty">
                                        <?php echo esc_html__( 'Phone', "eventin" ); ?>
                                        <span class="etn-input-field-required"> *</span>
                                    </label>
                                    <input required placeholder="<?php echo esc_html__('Enter phone number', 'eventin'); ?>"  class="attr-form-control" id="attendee_phone" name="phone" type="tel" value="<?php echo esc_html( $attendee_phone ); ?>" required/>
                                    <div class="etn-error attendee_phone"></div>   
                                </div>
                                <?php
                            }

                            $settings                           = Helper::get_settings();
                            $attendee_extra_fields_labels       = !empty( $settings['attendee_extra_label'] ) ? $settings['attendee_extra_label'] : [];
                            $attendee_extra_fields_type         = !empty( $settings['attendee_extra_type'] ) ? $settings['attendee_extra_type'] : [];
                            $attendee_extra_fields_place_holder = !empty( $settings['attendee_extra_place_holder'] ) ? $settings['attendee_extra_place_holder'] : [];

                            if( is_array( $attendee_extra_fields_labels ) && !empty( $attendee_extra_fields_labels[0] ) ) {
                                $total_extra_field_count = count( $attendee_extra_fields_labels );

                                for( $extra_field_index = 0; $extra_field_index < $total_extra_field_count; $extra_field_index++ ){
                                    $name_from_label            = \Etn\Utils\Helper::generate_name_from_label( "etn_attendee_extra_field_" , $attendee_extra_fields_labels[$extra_field_index]); 
                                    $extra_field_saved_value    = get_post_meta( $user_id, $name_from_label, true ); 
                                    $class_name_from_label      = \Etn\Utils\Helper::get_name_structure_from_label($attendee_extra_fields_labels[$extra_field_index]);
                                    ?>
                                    <div class="etn-<?php echo esc_attr( $class_name_from_label ); ?>-field etn-group-field">
                                        <label for="extra_field_<?php echo esc_attr( $extra_field_index ) ; ?>">
                                            <?php echo esc_html( $attendee_extra_fields_labels[$extra_field_index] ); ?>
                                            <span class="etn-input-field-required"> *</span>
                                        </label>
                                        <input placeholder="<?php echo esc_attr( $attendee_extra_fields_place_holder[$extra_field_index] ); ?>" value="<?php echo esc_attr( $extra_field_saved_value ); ?>" class="attr-form-control etn-attendee-extra-fields" id="etn_attendee_extra_field_<?php echo esc_attr( $extra_field_index ); ?>" name="<?php echo esc_attr( $name_from_label  ); ?>" type="<?php echo esc_html( $attendee_extra_fields_type[$extra_field_index] );?>" required/>
                                        <div class="etn-error etn_attendee_extra_field_<?php echo esc_attr( $extra_field_index ); ?>"></div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php wp_nonce_field( 'attendee_details_nonce', 'attendee_personal_data' );?>
                        <input name="etn_attendee_details_update_action" type="hidden" value="etn_attendee_details_update_action" required/>
                        <input name="etn_attendee_id" type="hidden" value="<?php echo esc_html( $user_id ); ?>" required/>
                        <input name="etn_info_edit_token" type="hidden" value="<?php echo esc_html( $access_token ); ?>" required/>
                        <input name="submit" class="etn-btn etn-primary attendee_update_sumbit" type="submit" value="<?php echo esc_html__( "Update", "eventin" ); ?>" />
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
    wp_footer(  );
exit;