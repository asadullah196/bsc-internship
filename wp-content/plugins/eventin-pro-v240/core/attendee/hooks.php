<?php

namespace Etn_Pro\Core\Attendee;
use \Etn_Pro\Utils\Helper;

defined( 'ABSPATH' ) || exit;

class Hooks {
    use \Etn_Pro\Traits\Singleton;

    public function init() {
        
        //filter attendee with event name
        add_action( 'restrict_manage_posts', [$this, 'show_attendee_report_filter'] );
        add_filter( 'parse_query', [$this, 'attendee_report_filter_result'] );

        // add bulk action to update attendee post status
        add_filter( 'bulk_actions-edit-etn-attendee', [$this, 'attendee_bulk_action_change_status_to_publish'] );
        add_filter( 'handle_bulk_actions-edit-etn-attendee', [$this, 'attendee_bulk_action_change_to_publish'], 10, 3 );
        add_action( 'admin_notices', [$this, 'attendee_show_notice_after_change_to_publish'] );

        // add bulk action to download attendee details as csv
        add_filter( 'bulk_actions-edit-etn-attendee', [$this, 'attendee_bulk_action_download_csv'] );
        add_filter( 'handle_bulk_actions-edit-etn-attendee', [$this, 'attendee_handle_bulk_action_download_csv'], 10, 3 );
        add_action( 'admin_notices', [$this, 'attendee_show_notice_after_download_csv'] );

        add_filter( 'etn_attendee_fields', [$this, 'etn_attendee_fields_add_extra'] );
    }

    /**
     * Add extra fields to attendee cpt metabox
     *
     * @param [type] $default_attendee_fields
     * @return void
     */
    public function etn_attendee_fields_add_extra( $default_attendee_fields ){
        
        $settings                           = Helper::get_settings();
        $attendee_extra_fields_labels       = !empty( $settings['attendee_extra_label'] ) ? $settings['attendee_extra_label'] : [];
        $attendee_extra_fields_type         = !empty( $settings['attendee_extra_type'] ) ? $settings['attendee_extra_type'] : [];
        $attendee_extra_fields_place_holder = !empty( $settings['attendee_extra_place_holder'] ) ? $settings['attendee_extra_place_holder'] : [];
        if( is_array( $attendee_extra_fields_labels ) && !empty( $attendee_extra_fields_labels[0] )){
            $total_extra_field_count = count( $attendee_extra_fields_labels );
            for( $extra_field_index = 0; $extra_field_index < $total_extra_field_count; $extra_field_index++ ){
                $extra_field_label  = $attendee_extra_fields_labels[$extra_field_index];
                $extra_field_name   = Helper::generate_name_from_label("etn_attendee_extra_field_", $extra_field_label);
                $extra_field_type   = $attendee_extra_fields_type[$extra_field_index];
                $extra_field_desc   = $attendee_extra_fields_place_holder[$extra_field_index];
                $default_attendee_fields[$extra_field_name]   = [
                    'label' => esc_html( $extra_field_label ),
                    'type'  => $extra_field_type,
                    'value' => '',
                    'desc'  => $extra_field_desc,
                    'attr'  => ['class' => 'etn-label-item'],
                ];

            }
        }

        return $default_attendee_fields;
    }


    /**
     * Update query
     * @since 1.1.0
     * @return void
     */
    function attendee_report_filter_result( $query ) {

        if (!(is_admin()) && $query->is_main_query()) {
            return $query;
        }
        
        $event_id       = isset($_GET['event_id']) && $_GET['event_id'] !=="" ? sanitize_text_field($_GET['event_id']) : null;
        $etn_status     = isset($_GET['etn_status']) && $_GET['etn_status'] !=="" ? sanitize_text_field($_GET['etn_status']) : null;
        $etn_attendeee_status = isset($_GET['etn_attendeee_ticket_status']) && $_GET['etn_attendeee_ticket_status'] !=="" ? sanitize_text_field($_GET['etn_attendeee_ticket_status']) : null;

        if ( !isset($query->query['post_type']) || ('etn-attendee' !== $query->query['post_type'])  || ( !isset( $event_id ) && !isset( $etn_status ) && !isset( $etn_attendeee_status ) ) ) {
            return $query;
        }
        
        $relation = []; $meta_etn_status = []; $meta_attendeee_status=[]; $meta_event_name =[];

        if ( isset( $event_id ) && ( isset( $etn_status ) || isset( $etn_attendeee_status ) ) ) {
            $relation = ['relation' => 'OR'];

            if ( isset( $etn_status ) ) {
                $meta_etn_status = array(
                    'key'       =>   'etn_status',
                    'value'     =>  $etn_status ,
                    'compare'   => "=",
                );
            }
            if ( isset( $etn_attendeee_status ) ) {
                $meta_attendeee_status = array(
                    'key'       =>   'etn_attendeee_ticket_status',
                    'value'     =>  $etn_attendeee_status ,
                    'compare'   => "=",
                );
            }
        }
        if ( empty( $event_id ) &&  empty( $etn_status ) && !empty( $etn_attendeee_status )  ) {
            $meta_attendeee_status = array(
                'key'       => 'etn_attendeee_ticket_status',
                'value'     =>  $etn_attendeee_status ,
                'compare'   => "=",
            );
        }
        
        if ( isset( $etn_status ) && !isset( $event_id )  && !isset( $etn_attendeee_status )  ) {
            $meta_etn_status = array(
                'key'       => 'etn_status',
                'value'     =>  $etn_status ,
                'compare'   => "LIKE",
            );
        }

        if ( isset( $event_id ) ) {
            // setup this functions meta values
            $meta_event_name = array(
                'key'       =>  'etn_event_id',
                'value'     =>  $event_id ,
                'compare'   => "=",
            );
        }
        
        if (!isset($query->query_vars['meta_query'])) {
            
            $query->query_vars['meta_query'] = array();
            if ( count( $relation )>0 ) {
                $query->query_vars['meta_query'] = array( $relation );
            }

            // append to meta_query array
            if ( count( $meta_event_name )> 0 ) {
                $query->query_vars['meta_query'][] = $meta_event_name;
            }

            if ( count( $meta_etn_status )> 0 ) {
                $query->query_vars['meta_query'][] = $meta_etn_status;
            }

            if ( count( $meta_attendeee_status )> 0 ) {
                $query->query_vars['meta_query'][] = $meta_attendeee_status;
            }

        }
        return $query;
    }

    /**
     * Filter slugs
     * @since 1.1.0
     * @return void
     */
    function show_attendee_report_filter() {
        global $typenow;

        if ( $typenow == 'etn-attendee' ) {
            //Filter by event
            $all_events = get_posts( [ 'post_type' => 'etn' ] );
            
            $events = [];

            foreach ( $all_events as $key => $value ) {
                $id          = $value->ID;
                $title       = $value->post_title;
                $events[$id] = $title;
            }

            $current_event_name = '';

            if ( isset( $_GET['event_id'] ) ) {
                $current_event_name = sanitize_text_field( $_GET['event_id'] ); // Check if option has been selected
            }
            ?>

            <select name="event_id" id="event_id">
                <option value="" <?php selected( 'all_events', $current_event_name );?>>
                    <?php echo esc_html__( 'All Events', 'eventin-pro' ); ?>
                </option>
                <?php
                foreach ( $events as $key => $value ) {
                    ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $current_event_name );?>>
                        <?php echo esc_attr( $value ); ?>
                    </option>
                    <?php
                }
                ?>
            </select>

            <?php
            // Payment status
            $all_status = [
                'success' => esc_html__('Success', 'eventin-pro'),
                'failed'  => esc_html__('Failed', 'eventin-pro'),
            ];

            $current_status = '';

            if ( isset( $_GET['etn_status'] ) ) {
                $current_status = sanitize_text_field( $_GET['etn_status'] );
            }

            ?>

            <select name='etn_status' id='etn_status'>
                <option value='' <?php selected( 'etn_status', $current_status );?>><?php echo esc_html__( 'All Payment Status', 'eventin-pro' ); ?></option>
                <?php
                    foreach ( $all_status as $key => $value ) {
                        ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $current_status ); ?>><?php echo esc_html( $value ); ?></option>
                        <?php
                    }
                ?>
            </select>

            <?php
            // Ticket using status
            $all_status = [
                'unused' => esc_html__( 'Unused', 'eventin-pro' ),
                'used'   => esc_html__( 'Used', 'eventin-pro' ),
            ];

            $current_ticket_status = '';

            if ( isset( $_GET['etn_attendeee_ticket_status'] ) ) {
                $current_ticket_status = sanitize_text_field( $_GET['etn_attendeee_ticket_status'] );
            }

            ?>

            <select name="etn_attendeee_ticket_status" id="etn_attendeee_ticket_status">
                <option value="" <?php selected( 'all_ticket', $current_ticket_status );?>>
                    <?php echo esc_html__( 'All Ticket Status', 'eventin-pro' ); ?>
                </option>
                <?php
                foreach ( $all_status as $key => $value ) {
                    ?>
                    <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $current_ticket_status );?>>
                        <?php echo esc_attr( $value ); ?>
                    </option>
                    <?php
                }
                ?>
            </select>

            <?php
        }

    }
    
    /**
     * Show notice after post status changed to published
     *
     * @return void
     */
    function attendee_show_notice_after_change_to_publish() {

        if ( !empty( $_REQUEST['changed-to-published'] ) ) {
            $num_changed = (int) $_REQUEST['changed-to-published'];
            printf( '<div id="message" class="updated notice is-dismissable"><p>' . __( 'Published %d posts.', 'eventin-pro' ) . '</p></div>', $num_changed );
        }

    }

    /**
     * Change multiple post status to Publish
     *
     * @param [type] $redirect_url
     * @param [type] $action
     * @param [type] $post_ids
     * @return void
     */
    function attendee_bulk_action_change_to_publish( $redirect_url, $action, $post_ids ) {

        if ( $action == 'change-to-published' ) {

            foreach ( $post_ids as $post_id ) {
                wp_update_post( [
                    'ID'          => $post_id,
                    'post_status' => 'publish',
                ] );
            }

            $redirect_url = add_query_arg( 'changed-to-published', count( $post_ids ), $redirect_url );
        }

        return $redirect_url;
    }

    /**
     * add custom bulk action to attendee dashboard
     *
     * @param [type] $bulk_actions
     * @return void
     */
    public function attendee_bulk_action_change_status_to_publish( $bulk_actions ) {
        $bulk_actions['change-to-published'] = esc_html__( 'Change to published', 'eventin-pro' );
        return $bulk_actions;
    }



    /**
     * add custom bulk action to attendee dashboard
     *
     * @param [type] $bulk_actions
     * @return void
     */
    public function attendee_bulk_action_download_csv( $bulk_actions ) {
        $bulk_actions['download-attendee-csv'] = esc_html__( 'Download Details as CSV', 'eventin-pro' );
        return $bulk_actions;
    }

    /**
     * Undocumented function
     *
     * @param [type] $redirect_url
     * @param [type] $action
     * @param [type] $post_ids
     * @return void
     */
    function attendee_handle_bulk_action_download_csv( $redirect_url, $action, $post_ids ) {

        if ( $action == 'download-attendee-csv' ) {

            $settings                           = \Etn\Core\Settings\Settings::instance()->get_settings_option();
            $attendee_extra_fields_labels       = !empty( $settings['attendee_extra_label'] ) ? $settings['attendee_extra_label'] : [];
            $extra_field_array                  = [];

            if( is_array( $attendee_extra_fields_labels ) && !empty( $attendee_extra_fields_labels[0] )){
                foreach( $attendee_extra_fields_labels as $label ){
                    $name_from_label['label']   = $label;
                    $name_from_label['name']    = \Etn_Pro\Utils\Helper::generate_name_from_label("etn_attendee_extra_field_", $label);
                    array_push( $extra_field_array, $name_from_label );
                }
            }

            $attendee_array =  [];
            foreach ( $post_ids as $post_id ) {
                //create attendee array
                $attendee_array[$post_id]['etn_name']       =  get_the_title( $post_id );

                if( !empty(Helper::get_option('reg_require_email')) ){
                    $attendee_array[$post_id]['etn_email']      =  get_post_meta( $post_id, 'etn_email', true );
                }
                
                if( !empty(Helper::get_option('reg_require_phone')) ){
                    $attendee_array[$post_id]['etn_phone']      =  get_post_meta( $post_id, 'etn_phone', true );
                }

                $attendee_array[$post_id]['event_name']     =  get_the_title( get_post_meta( $post_id, 'etn_event_id', true ) );
                $attendee_array[$post_id]['payment_status'] =  get_post_meta( $post_id, 'etn_status', true );
                $attendee_array[$post_id]['ticket_status']  =  get_post_meta( $post_id, 'etn_attendeee_ticket_status', true );
                
            }

            $this->download_attendee_information_csv( $attendee_array, $extra_field_array );

            $redirect_url = add_query_arg( 'download-attendee-csv', count( $post_ids ), $redirect_url );
        }

        return $redirect_url;
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    function attendee_show_notice_after_download_csv() {

        if ( !empty( $_REQUEST['download-attendee-csv'] ) ) {
            $num_downloaded = (int) $_REQUEST['download-attendee-csv'];
            printf( '<div id="message" class="updated notice is-dismissable"><p>' . esc_html__( 'Downloaded %d attendee information.', 'eventin-pro' ) . '</p></div>', $num_downloaded );
        }

    }

    /**
     * Export CSV file with selected attendees
     *
     * @param [type] $attendee_array
     * @return void
     */
    public function download_attendee_information_csv( $attendee_array, $extra_field_array ) {

        $generated_date = date( 'd-m-Y His' ); //Date will be part of file name.
        $table_title_array[] = esc_html__('Id', 'eventin-pro');
        $table_title_array[] = esc_html__('Name', 'eventin-pro');
        if( !empty(Helper::get_option('reg_require_email')) ){
            $table_title_array[] = esc_html__('Email', 'eventin-pro');
        }
        if( !empty(Helper::get_option('reg_require_phone')) ){
            $table_title_array[] = esc_html__('Phone', 'eventin-pro');
        }
        $table_title_array[] = esc_html__('Event Name', 'eventin-pro');
        $table_title_array[] = esc_html__('Payment Status', 'eventin-pro');
        $table_title_array[] = esc_html__('Ticket Status', 'eventin-pro');
        //add extra fields label to csv file header row 
        foreach( $extra_field_array as $extra_field ){
            array_push( $table_title_array, $extra_field['label'] );
        }

        header( "Content-type: text/csv" );
        header( "Content-Disposition: attachment; filename=\"etn_attendee_info_" . $generated_date . ".csv\";" );
        ob_end_clean();

        // create a file pointer connected to the output stream
        $output = fopen( 'php://output', 'w' ) or die( "Can\'t open php://output" );

        // output the column headings
        fputcsv(
            $output,
            $table_title_array
        );

        foreach ( $attendee_array as $key => $value ) {
            $table_content_row = [];
            array_push( $table_content_row, $key );
            array_push( $table_content_row, $value['etn_name'] );
            if( !empty(Helper::get_option('reg_require_email')) ){
                array_push( $table_content_row, $value['etn_email'] );
            }
            if( !empty(Helper::get_option('reg_require_phone')) ){
                array_push( $table_content_row, "=\"" . $value['etn_phone'] . "\"" );
            }
            array_push( $table_content_row, $value['event_name'] );
            array_push( $table_content_row, $value['payment_status'] );
            array_push( $table_content_row, $value['ticket_status'] );

            //add extra field data to row
            foreach( $extra_field_array as $extra_field ){
                $extra_field_meta_key                       = $extra_field['name'];
                array_push( $table_content_row, "=\"" . get_post_meta( $key, $extra_field_meta_key, true ) . "\"" );
            }

            fputcsv(
                $output,
                $table_content_row
            );

        }

        // Close output file stream
        fclose( $output );

        die();
    }

}
