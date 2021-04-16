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
     * Download PDF from email and admin dashboard
     */
    public function generate_ticket_pdf() {

        if ( isset( $_GET['etn_action'] ) && sanitize_text_field( $_GET['etn_action'] ) === 'download_ticket' ) {
            
            $get_arr = filter_input_array( INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS );

            if( empty( $get_arr["attendee_id"] ) || empty( $get_arr["etn_info_edit_token"] ) ){
                Helper::show_attendee_pdf_invalid_data_page();
                exit;
            }

            if( !Helper::verify_attendee_edit_token( $get_arr["attendee_id"], $get_arr["etn_info_edit_token"] ) ){
                Helper::show_attendee_pdf_invalid_data_page();
                exit;
            }

            $attendee_id = $get_arr["attendee_id"];
            $event_id    = get_post_meta( $attendee_id, "etn_event_id", true );
            $attendee_data = [
                "attendee_id"           => $attendee_id,
                "etn_ticket_price"      => get_post_meta( $attendee_id, "etn_ticket_price", true ),
                "event_location"        => get_post_meta( $event_id, "etn_event_location", true ),
                "event_name"            => get_the_title( $event_id ),
                "etn_start_date"        => get_post_meta( $event_id, "etn_start_date", true ),
                "etn_end_date"          => get_post_meta( $event_id, "etn_end_date", true ),
                "etn_start_time"        => get_post_meta( $event_id, "etn_start_time", true ),
                "etn_end_time"          => get_post_meta( $event_id, "etn_end_time", true ),

            ];
            $result_data = $this->attendee_ticket_data( $attendee_data );

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
            exit;
        }
        return;

    }

    /**
     * Generate PDF file with provided data
     */
    public function generate_pdf( $event_name, $start_date, $end_date, $start_time, $end_time, 
        $event_location, $ticket_price, $attendee_name, $attendee_email, $attendee_phone ) {
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
        if( !empty(Helper::get_option('reg_require_email')) ){
            $columns['etn_email']                   = esc_html__( 'Email', 'eventin' );
        }
        if( !empty(Helper::get_option('reg_require_phone')) ){
            $columns['etn_phone']                   = esc_html__( 'Phone', 'eventin' );
        }
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
            echo esc_html( ucfirst($payment_status) );
            break;
        case 'etn_attendeee_ticket_status':
            echo esc_html( ucfirst($attendee_ticket_status) );
            break;
        case 'etn_download_ticket':
            $attendee_id            = intval($post_id) ;
            $edit_token             = get_post_meta( $attendee_id , 'etn_info_edit_token' , true );
            $base_url               = home_url( );
            $attendee_cpt           = new \Etn\Core\Attendee\Cpt();
            $attendee_endpoint      = $attendee_cpt->get_name();
            $action_url             = $base_url . "/" . $attendee_endpoint;
            $ticket_download_link   = $action_url . "?etn_action=". urlencode('download_ticket') ."&attendee_id=" . urlencode($attendee_id) . "&etn_info_edit_token=" . urlencode($edit_token); 
            ?>
            <div class="etn-attendee-details-button-download">
                <a class="etn-btn etn-success download-details" target="_blank" href="<?php echo esc_url( $ticket_download_link ); ?>"><?php  echo esc_html__('Ticket','eventin');?></a>
            </div>
            <?php
            break;
        }

    }

}
