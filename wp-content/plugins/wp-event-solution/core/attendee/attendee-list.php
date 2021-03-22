<?php
namespace Etn\Core\Attendee;
use Etn\Utils\Helper;

defined( 'ABSPATH' ) || exit;

class Attendee_List {
    use \Etn\Traits\Singleton;

    /**
     * Class constructor.
     */
    public function init() {
        add_filter( "manage_etn-attendee_posts_columns", [$this, "attendee_post_columns"] );
        add_action( "manage_etn-attendee_posts_custom_column", [$this, 'attendee_custom_column_data'], 10, 2 );

        //register cron-job depending on settings
        $settings            = Helper::get_settings();
        $attendee_reg_enable = !empty( $settings["attendee_registration"] ) ? true : false;

        if ( $attendee_reg_enable ) {
            // Attendee cron job to remove attendee
            \Etn\Core\Attendee\Cron::instance()->init();
        }

        // hide preview , view , edit link
        add_filter( 'page_row_actions', [$this, 'remove_row_actions'], 10, 2 );

        // generate pdf
        add_action( 'init', [$this, 'generate_ticket_pdf'] );
        add_action( 'init', [$this, 'download_ticket_pdf_admin'] );
    }

    /**
     * Attendee data array both for generate and download
     */
    public function attendee_ticket_data( $data ) {
        $result_data                   = [];
        $result_data['user_id']        = intval( $data["attendee_id"] );
        $result_data['ticket_price']   = $data['etn_ticket_price'];
        $result_data['event_location'] = $data['event_location'];
        $result_data['event_name']     = $data['event_name'];

        $settings                   = \Etn\Utils\Helper::get_settings();
        $date_options               = \Etn\Utils\Helper::get_date_formats();
        $etn_settings_time_format   = empty( $settings["time_format"] ) ? '12' : $settings["time_format"];
        $etn_settings_time_format   = $etn_settings_time_format == '24' ? "H:i" : "h:i a";
        $etn_settings_date_format   = !empty( $settings["date_format"] ) ? $date_options[$settings["date_format"]] : 'd/m/Y';
        
        $result_data['start_date']     = !empty( $settings['date_format'] ) ? date_i18n( $etn_settings_date_format, strtotime($data['etn_start_date']) ) : $data['etn_start_date'];
        $result_data['end_date']       = !empty( $settings['date_format'] ) ? date_i18n( $etn_settings_date_format, strtotime($data['etn_end_date']) ) : $data['etn_end_date'] ;
        $result_data['start_time']     = !empty($settings['time_format']) ? date_i18n( $etn_settings_time_format, strtotime($data['etn_start_time']) ) : $data['etn_start_time'];
        $result_data['end_time']       = !empty($settings['time_format']) ? date_i18n( $etn_settings_time_format, strtotime($data['etn_end_time']) ) : $data['etn_end_time'];

        $result_data['attendee_name']  = get_the_title( $result_data['user_id'] );
        $result_data['attendee_email'] = get_post_meta( $result_data['user_id'], "etn_email", true );
        $result_data['attendee_phone'] = get_post_meta( $result_data['user_id'], "etn_phone", true );

        return $result_data;
    }

    /**
     * Download PDF from email
     */
    public function generate_ticket_pdf() {

        if ( isset( $_POST['etn_download_attendee_action'] ) && sanitize_text_field( $_POST['etn_download_attendee_action'] ) !== '' ) {
            $post_arr = filter_input_array( INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS );

            if ( !empty( $post_arr["attendee_id"] ) ) {

                $result_data = $this->attendee_ticket_data( $post_arr );

                if ( is_array( $result_data ) && !empty( $result_data ) ) {

                    $this->generate_pdf( 
                        $result_data['event_name'], 
                        $result_data['start_date'],
                        $result_data['end_date'], 
                        $result_data['start_time'], 
                        $result_data['end_time'],
                        $result_data['event_location'], 
                        $result_data['ticket_price'], 
                        $result_data['attendee_name'],
                        $result_data['attendee_email'], 
                        $result_data['attendee_phone'] 
                    );
                }

            } else {

                wp_head();

                ?>
                <div class="section-inner">
                    <h3 class="entry-title">
                        <?php echo esc_html__( "Invalid data. ", "eventin" ); ?>
                    </h3>
                    <div class="intro-text">
                        <a href="<?php echo esc_url( home_url() ); ?>"><?php echo esc_html__( "Return to homepage", "eventin" ); ?></a>
                    </div>
                </div>
                <?php

                wp_footer();
            }

            exit;
        }

    }

    /**
     * Download PDF from admin
     */
    public function download_ticket_pdf_admin() {

        if ( isset( $_GET['download_ticket_admin'] ) ) {

            $get_arr = filter_input_array( INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS );

            if ( !empty( $get_arr["attendee_id"] ) ) {

                $result_data = $this->attendee_ticket_data( $get_arr );

                if ( is_array( $result_data ) && count( $result_data ) > 0 ) {

                    $this->generate_pdf( 
                        $result_data['event_name'], 
                        $result_data['start_date'],
                        $result_data['end_date'], 
                        $result_data['start_time'], 
                        $result_data['end_time'],
                        $result_data['event_location'], 
                        $result_data['ticket_price'], 
                        $result_data['attendee_name'],
                        $result_data['attendee_email'], 
                        $result_data['attendee_phone'] 
                    );
                }

            } else {

                wp_head();

                ?>
                <div class="section-inner">
                    <h3 class="entry-title">
                        <?php echo esc_html__( "Invalid data. ", "eventin" ); ?>
                    </h3>
                    <div class="intro-text">
                        <a href="<?php echo esc_url( home_url() ); ?>"><?php echo esc_html__( "Return to homepage", "eventin" ); ?></a>
                    </div>
                </div>
                <?php

                wp_footer();

            }

            exit;
        }

    }

    /**
     * Generate PDF file with provided data
     */
    public function generate_pdf( 
        $event_name, 
        $start_date, 
        $end_date, 
        $start_time, 
        $end_time, 
        $event_location, 
        $ticket_price, 
        $attendee_name, 
        $attendee_email, 
        $attendee_phone 
        ) {
        $settings      = Helper::get_settings();
        $include_phone = !empty( $settings["reg_require_phone"] ) ? true : false;
        $include_email = !empty( $settings["reg_require_email"] ) ? true : false;

        // render template
        if ( file_exists( ETN_CORE . "attendee/views/ticket/pdf.php" ) ) {
            include_once ETN_CORE . "attendee/views/ticket/pdf.php";
        }

    }

    /**
     * hide preview , view , edit link
     */
    public function remove_row_actions( $actions, $post ) {

        if ( $post->post_type === 'etn-attendee' ):
            unset( $actions['view'] );
            unset( $actions['inline hide-if-no-js'] );
        endif;

        return $actions;
    }

    /**
     * Column name
     */
    public function attendee_post_columns( $columns ) {
        unset( $columns['date'] );
        unset( $columns['title'] );

        $columns['id']                          = esc_html__( 'Id', 'eventin' );
        $columns['etn_name']                    = esc_html__( 'Name', 'eventin' );
        $columns['etn_email']                   = esc_html__( 'Email', 'eventin' );
        $columns['etn_phone']                   = esc_html__( 'Phone', 'eventin' );
        $columns['etn_event']                   = esc_html__( 'Event', 'eventin' );
        $columns['etn_status']                  = esc_html__( 'Payment Status', 'eventin' );
        $columns['etn_attendeee_ticket_status'] = esc_html__( 'Ticket Status', 'eventin' );
        $columns['etn_download_ticket']         = esc_html__( 'Action', 'eventin' );

        return $columns;
    }

    /**
     * Return row
     */
    public function attendee_custom_column_data( $column, $post_id ) {

        $event_id               = get_post_meta( $post_id, 'etn_event_id', true );
        $attendee_name          = get_the_title( $post_id );
        $attendee_email         = get_post_meta( $post_id, 'etn_email', true );
        $attendee_phone         = get_post_meta( $post_id, 'etn_phone', true );
        $payment_status         = get_post_meta( $post_id, 'etn_status', true );
        $attendee_ticket_status = get_post_meta( $post_id, 'etn_attendeee_ticket_status', true );
        $event_name             = get_the_title( $event_id );
        $event_location         = get_post_meta( $event_id, "etn_event_location", true );
        $event_start_date       = get_post_meta( $event_id, "etn_start_date", true );
        $event_end_date         = get_post_meta( $event_id, "etn_end_date", true );
        $event_start_time       = get_post_meta( $event_id, "etn_start_time", true );
        $event_end_time         = get_post_meta( $event_id, "etn_end_time", true );
        $event_ticket_price     = get_post_meta( $event_id, "etn_ticket_price", true );

        switch ( $column ) {
        case 'id':
            echo intval( $post_id );
            break;
        case 'etn_name':
            echo esc_html( $attendee_name );
            break;
        case 'etn_email':
            echo esc_html( $attendee_email );
            break;
        case 'etn_phone':
            echo esc_html( $attendee_phone );
            break;
        case 'etn_event':
            echo esc_html( $event_name );
            break;
        case 'etn_status':
            echo esc_html( $payment_status );
            break;
        case 'etn_attendeee_ticket_status':
            echo esc_html( ucfirst($attendee_ticket_status) );
            break;
        case 'etn_download_ticket':
            $action_url      = home_url();
            $attend_pdf_data = [
                'event_name'       => $event_name,
                'event_location'   => $event_location,
                'etn_ticket_price' => $event_ticket_price,
                'etn_start_date'   => $event_start_date,
                'etn_end_date'     => $event_end_date,
                'etn_start_time'   => $event_start_time,
                'etn_end_time'     => $event_end_time,
                'attendee_id'      => $post_id,
            ];
            ?>
            <div class="etn-attendee-details-button-download">
                <?php
                $query_string = "?download_ticket_admin=true";

                foreach ( $attend_pdf_data as $key => $value ) {
                    $query_string .= "&" . $key . "=" . $value;
                }

                ?>
                <a target="_blank" href="<?php echo esc_url( $action_url ); ?>/etn-attendee<?php echo esc_html( $query_string ); ?>" class="etn-btn etn-success download-details" ><?php echo esc_html__( 'Download', 'eventin' ); ?></a>
            </div>
            <?php
            break;
        }

    }

}
