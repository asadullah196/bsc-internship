<div class=" etn-attendee-widget-holder">
    <div class="etn-row">
        <?php
         if ( is_array( $event_attendees ) && !empty( $event_attendees ) ) {

            foreach ( $event_attendees as $attendee ) {
                $attendee_id     = $attendee->post_id;
                $attendee_avatar = "";
                $attendee_name   = get_post_meta( $attendee_id, "etn_name", true );
                $attendee_email  = get_post_meta( $attendee_id, "etn_email", true );
                $attendee_email  = !empty( $attendee_email ) ? $attendee_email : "";

                if ( !empty( $attendee_email ) ) {
                    $attendee_avatar = get_avatar_url( $attendee_email );
                } else {
                    $default_avatar_url = ETN_ASSETS . "images/avatar.jpg";
                    $attendee_avatar    = apply_filters( "etn/attendee/default_avatar", $default_avatar_url );
                }
                ?>
                <div class="etn-col-lg-4 etn-col-md-6">
                    <div class="etn-event-attendee-single">
                        <?php if($show_avatar == 'yes'){ ?>
                            <div class="etn-attendee etn-attendee-avatar-wrap">
                                <img class="etn-attendee-avatar" src="<?php echo esc_url( $attendee_avatar ); ?>" />
                            </div>
                        <?php } ?>
                        <div class="etn-attendee etn-attendee-content">
                            <h4 class="etn-attendee-title">
                                <?php echo esc_html( $attendee_name ); ?>
                            </h4>
                            <?php if($show_email == 'yes' && $attendee_email !=''){ ?>
                                <p class="attende-meta">
                                    <span class="etn-attendee-email-label">
                                        <?php echo esc_html__( "Email: ", "eventin-pro" ); ?>
                                    </span>
                                    <?php echo esc_html( $attendee_email ); ?>
                                </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else { ?>
        <div class="etn-no-attendee-holder">
            <?php echo esc_html__( "No attendee found", "eventin-pro" ); ?>
        </div>
        <?php
         }
        ?>
    </div>
</div>