<?php

use Etn\Utils\Helper;

wp_head();
if ( !empty($post_arr["etn_attendee_id"]) && !empty($post_arr["name"]) ) {

    $attendee_id         = is_numeric( $post_arr["etn_attendee_id"] ) ? $post_arr["etn_attendee_id"] : 0;
    $attendee_name       = !empty( $post_arr["name"] ) ? $post_arr["name"] : "";
    $attendee_email      = !empty( $post_arr["email"] ) ? $post_arr["email"] : "";
    $attendee_phone      = !empty( $post_arr["phone"] ) ? $post_arr["phone"] : "";
    $attendee_edit_token = $post_arr["etn_info_edit_token"];

    $attendee_data = Helper::get_attendee_by_token( 'etn_info_edit_token', $attendee_edit_token  );

    if ( !empty( $attendee_data ) && ( $attendee_data[0]->post_id == $attendee_id ) ) {
        update_post_meta( $attendee_id, "etn_name", $attendee_name );
        update_post_meta( $attendee_id, "etn_email", $attendee_email );
        update_post_meta( $attendee_id, "etn_phone", $attendee_phone );

        //check if there's any attendee extra field set from Plugin Settings
        $settings               = Helper::get_settings();
        $attendee_extra_fields  = !empty( $settings['attendee_extra_label'] ) ? $settings['attendee_extra_label'] : [];
        $extra_field_array      = [];
        if( is_array( $attendee_extra_fields ) && !empty( $attendee_extra_fields[0] )){
            foreach( $attendee_extra_fields as $label ){
                $name_from_label['label']   = $label;
                $name_from_label['name']    = Helper::generate_name_from_label("etn_attendee_extra_field_", $label);
                array_push( $extra_field_array, $name_from_label );
            }
        }

        //check and insert attendee extra field data from attendee form
        if( is_array( $extra_field_array ) && !empty( $extra_field_array ) ){
            foreach( $extra_field_array as $key => $value ){
                if( !empty( $post_arr[$value['name']] ) ){
                    update_post_meta( $attendee_id, $value['name'], $post_arr[$value['name']] );
                }
            }
        }

        $attendee_post = array(
            'ID'           => $attendee_id,
            'post_title'   => $attendee_name,
        );
        
        // Update the post into the database
        wp_update_post( $attendee_post );
        ?>
        <div class="etn-es-events-page-container">
            <div class="etn-event-single-wrap">
                <div class="etn-container">
                    <div class="section-inner">
                        <h3 class="entry-title">
                            <?php echo esc_html__("Attendee details updated", "eventin");?>
                        </h3>
                        <div class="intro-text">
                            <a href="<?php echo esc_url( home_url() );?>"><?php echo esc_html__("Return to homepage", "eventin"); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
        ?>
        <div class="etn-es-events-page-container">
            <div class="etn-event-single-wrap">
                <div class="etn-container">
                    <div class="section-inner">
                        <h3 class="entry-title">
                            <?php echo esc_html__("Invalid data. Make sure no required data is missing.", "eventin");?>
                        </h3>
                        <div class="intro-text">
                            <a href="<?php echo esc_url( home_url() );?>"><?php echo esc_html__("Return to homepage", "eventin"); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
}

wp_footer();

exit;