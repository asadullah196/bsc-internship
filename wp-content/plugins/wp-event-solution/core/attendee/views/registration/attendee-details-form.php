<?php

if ( $check && !empty( $post_arr["quantity"] ) && !empty( $post_arr["event_id"] ) ) {

    $total_qty                = intval( $post_arr["quantity"] );
    $attendee_info_update_key = md5( md5( "etn-access-token" . time() . $total_qty ) );
    ?>
    <?php wp_head();?>
    <div class="etn-es-events-page-container">
        <div class="etn-event-single-wrap">
            <div class="etn-container">
                <div class="etn-attendee-form">
                <h3 class="attendee-title"><?php echo esc_html__( "Attendee Details For ", "eventin" ) . esc_html( $post_arr["event_name"] ); ?></h3>
                    <form action="" method="post" id="etn-event-attendee-data-form" class="attende_form">
                        <?php wp_nonce_field( 'ticket_purchase_next_step_three', 'ticket_purchase_next_step_three' );?>
                        <input name="ticket_purchase_next_step" type="hidden" value="three" />
                        <input name="event_name" type="hidden" value="<?php echo esc_html( $post_arr["event_name"] ); ?>" />
                        <input name="add-to-cart" type="hidden" value="<?php echo intval( $post_arr["event_id"] ); ?>" />
                        <input name="quantity" type="hidden" value="<?php echo intval( $post_arr["quantity"] ); ?>" />
                        <input name="attendee_info_update_key" type="hidden" value="<?php echo esc_html( $attendee_info_update_key ); ?>" />
                        <?php
                            for ( $i = 1; $i <= $total_qty; $i++ ) {
                                ?>
                                <div class="etn-attendee-form-wrap">
                                    <div class="etn-attendy-count">
                                        <h4><?php echo esc_html__( "Attendee - ", "eventin" ) . $i; ?></h4>
                                    </div>
                                    <div class="etn-name-field etn-group-field">
                                        <label for="etn_product_qty">
                                            <?php echo esc_html__( 'Name', "eventin" ); ?> <span class="etn-input-field-required">*</span>
                                        </label>
                                        <input required placeholder="<?php echo esc_html__('Enter attendee full name', 'eventin'); ?>" class="attr-form-control" id="attendee_name_<?php echo intval( $i ) ?>" name="attendee_name[]"  type="text"/>
                                        <div class="etn-error attendee_name_<?php echo intval( $i ) ?>"></div>
                                    </div>
                                    <?php

                                    if ( $include_email ) {
                                        ?>
                                        <div class="etn-email-field etn-group-field">
                                            <label for="etn_product_qty">
                                                <?php echo esc_html__( 'Email', "eventin" ); ?><span class="etn-input-field-required"> *</span>
                                            </label>
                                            <input required placeholder="<?php echo esc_html__('Enter email address', 'eventin'); ?>" class="attr-form-control" id="attendee_email_<?php echo intval( $i ) ?>" name="attendee_email[]" type="email"/>
                                            <div class="etn-error attendee_email_<?php echo intval( $i ) ?>"></div>
                                        </div>
                                        <?php
                                    }

                                    if ( $include_phone ) {
                                        ?>
                                        <div class="etn-phone-field etn-group-field">
                                            <label for="etn_product_qty">
                                                <?php echo esc_html__( 'Phone', "eventin" ); ?><span class="etn-input-field-required"> *</span>
                                            </label>
                                            <input required placeholder="<?php echo esc_html__('Enter phone number', 'eventin'); ?>" class="attr-form-control" maxlength="15" id="attendee_phone_<?php echo intval( $i ) ?>" name="attendee_phone[]" type="tel"/>
                                            <div class="etn-error attendee_phone_<?php echo intval( $i ) ?>"></div>
                                        </div>
                                        <?php
                                    }

                                    $attendee_extra_fields_labels       = !empty( $settings['attendee_extra_label'] ) ? $settings['attendee_extra_label'] : [];
                                    $attendee_extra_fields_type         = !empty( $settings['attendee_extra_type'] ) ? $settings['attendee_extra_type'] : [];
                                    $attendee_extra_fields_place_holder = !empty( $settings['attendee_extra_place_holder'] ) ? $settings['attendee_extra_place_holder'] : [];
    
                                    if( is_array( $attendee_extra_fields_labels ) && !empty( $attendee_extra_fields_labels[0] ) ) {
                                        $total_extra_field_count = count( $attendee_extra_fields_labels );

                                        for( $extra_field_index = 0; $extra_field_index < $total_extra_field_count; $extra_field_index++ ){
                                            $name_from_label        = \Etn\Utils\Helper::generate_name_from_label( "etn_attendee_extra_field_" , $attendee_extra_fields_labels[$extra_field_index]); 
                                            $class_name_from_label  = \Etn\Utils\Helper::get_name_structure_from_label($attendee_extra_fields_labels[$extra_field_index]);
                                            ?>
                                            <div class="etn-<?php echo esc_attr( $class_name_from_label ); ?>-field etn-group-field">
                                                <label for="extra_field_<?php echo esc_attr( $extra_field_index ) . "_attendee_" . intval( $i ) ?>">
                                                    <?php echo esc_html( $attendee_extra_fields_labels[$extra_field_index] ); ?>
                                                    <span class="etn-input-field-required"> *</span>
                                                </label>
                                                <input placeholder="<?php echo esc_attr( $attendee_extra_fields_place_holder[$extra_field_index] ); ?>" class="attr-form-control etn-attendee-extra-fields" id="etn_attendee_extra_field_<?php echo esc_attr( $extra_field_index ) . "_attendee_" . intval( $i ) ?>" name="<?php echo esc_attr( $name_from_label  ); ?>[]" type="<?php echo esc_html( $attendee_extra_fields_type[$extra_field_index] );?>" required/>
                                                <div class="etn-error etn_attendee_extra_field_<?php echo esc_attr( $extra_field_index ) . "_attendee_" . intval( $i ) ?>"></div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        <input name="submit" class="etn-btn etn-primary attendee_sumbit" type="submit" value="<?php echo esc_html__( "Confirm", "eventin" ); ?>" />
                        <a class="etn-btn etn-btn-secondary" href="<?php echo get_permalink(); ?>"><?php echo esc_html__("Go Back", "eventin");?></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php wp_footer();
    exit;
} else {
    wp_redirect( get_permalink() );
}

return;