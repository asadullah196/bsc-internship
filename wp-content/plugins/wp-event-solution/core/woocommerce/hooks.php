<?php

namespace Etn\Core\Woocommerce;

use Etn\Utils\Helper;

defined( 'ABSPATH' ) || exit;

class Hooks {

    use \Etn\Traits\Singleton;

    public $action;
    public $base;

    public function Init() {

        $_speaker  = new \Etn\Core\Metaboxs\Speaker_meta();
        $_schedule = new \Etn\Core\Metaboxs\Schedule_meta();

        add_filter( 'wp_insert_post_data', [$_speaker, 'etn_set_speaker_title'], 500, 2 );
        add_filter( 'wp_insert_post_data', [$_schedule, 'etn_set_schedule_title'], 500, 2 );
        add_filter( 'woocommerce_cart_item_name', [$this, 'etn_cart_item_name'], 10, 3 );
        add_filter( 'woocommerce_cart_item_price', [$this, '_cart_item_price'], 10, 3 );
        add_action( 'add_meta_boxes', [$this, 'etn_generate_report'] );

        // add the filter 
        add_action('woocommerce_order_status_changed', [$this, 'change_attendee_payment_status_on_order_status_update' ], 10, 3);
        add_action('woocommerce_order_status_changed', [$this, 'change_purchase_report_status_on_order_status_update' ], 10, 3);
        add_action('woocommerce_order_status_changed', [$this, 'email_zoom_event_details_on_order_status_update' ], 10, 3);

        // ====================== Attendee registration related hooks for woocommerce start ======================== //
        {
            // insert attendee data into database before add-to-cart
            add_action( 'woocommerce_add_to_cart', [$this, 'insert_attendee_before_add_to_cart'], 0 );
            // insert attendee data into cart item object
            add_filter( 'woocommerce_add_cart_item_data', [$this, 'add_cart_item_data'], 10, 3 );
            // Hide order item meta data (in thank you  and order page)
            add_filter( 'woocommerce_order_item_get_formatted_meta_data', [$this, 'hidden_order_itemmeta'], 10, 2 );
            // save cart item data while checkout
            add_action( 'woocommerce_checkout_create_order_line_item', [$this, 'save_update_status_key'], 10, 4 );
        }
        
        // ===================== Attendee registration related hooks for woocommerce end ========================== //

    }

    /**
     * Send Zoom Event Details On Status CHange
     *
     * @param [type] $order_id
     * @param [type] $old_order_status
     * @param [type] $new_order_status
     * @return void
     */
    function email_zoom_event_details_on_order_status_update(  $order_id, $old_order_status, $new_order_status ) {
         
        $payment_success_status_array = [
            // 'pending', 'on-hold',
            'processing',
            'completed',
            // 'cancelled','refunded', 'failed',
        ];

        $zoom_email_sent = Helper::check_if_zoom_email_sent_for_order( $order_id );

        if( !$zoom_email_sent && in_array($new_order_status, $payment_success_status_array)){

            //email not sent yet and order order status is paid, so proceed..
            $order = wc_get_order( $order_id );
            Helper::send_email_with_zoom_meeting_details( $order_id, $order );
        }
    }

    /**
     * Change attandee payment status
     *
     * @param [type] $order_id
     * @param [type] $old_order_status
     * @param [type] $new_order_status
     * @return void
     */
    function change_attendee_payment_status_on_order_status_update(  $order_id, $old_order_status, $new_order_status ) {
        $order_attendees = Helper::get_attendee_by_woo_order( $order_id );
        if( is_array( $order_attendees ) && !empty( $order_attendees )){
            foreach($order_attendees as $attendee_id){
                Helper::update_attendee_payment_status($attendee_id, $new_order_status);
            }
        }
    }



    function change_purchase_report_status_on_order_status_update( $order_id, $old_order_status, $new_order_status ) {

        $order_status_array = [
            'pending'   => "Pending",
            'processing'=> "Processing",
            'on-hold'   => "Hold",
            'completed' => "Completed",
            'cancelled' => "Cancelled",
            'refunded'  => "Refunded",
            'failed'    => "Failed",
        ];

        global $wpdb;
        $table_name  = $wpdb->prefix . "etn_events";
        $order_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE form_id = '$order_id'" );

        if ( $order_count > 0 ) {
            $data  = ['status'  => $order_status_array[$new_order_status]];
            $where = ['form_id' => $order_id];
            $wpdb->update( $table_name, $data, $where );
        }

        return;

    }

    /**
     * Display custom cart item meta data (in cart and checkout)
     */
    public function hidden_order_itemmeta( $formatted_meta, $item ) {

        foreach ( $formatted_meta as $key => $meta ) {

            if ( isset( $meta->key ) && 'etn_status_update_key' == $meta->key ) {
                unset( $formatted_meta[$key] );
            }

        }

        return $formatted_meta;
    }

    /**
     * save cart item custom meta as order item_meta to show in thank you and order page
     */
    public function save_update_status_key( $item, $cart_item_key, $values, $order ) {

        if ( isset( $values['etn_status_update_key'] ) ) {
            $item->update_meta_data( 'etn_status_update_key', $values['etn_status_update_key'] );
        }

    }

    /**
     * function etn_generate_report
     *  used for generating report inside metabox
     */
    public function etn_generate_report() {
        add_meta_box(
            'etn-report',
            esc_html__( 'Order Report', 'eventin' ),
            [$this, 'etn_report_callback'],
            'etn'
        );
    }

    /**
     * function etn_report_callback
     * gets the current event id,
     * gets all details of this event, calculates total sold quantity and price
     * then finally generates report
     */
    public function etn_report_callback() {
        $report_options    = get_option( "etn_event_report_etn_options" );
        $report_sorting    = isset( $report_options["event_list"] ) ? strtoupper( $report_options["event_list"] ) : "DESC";
        $ticket_qty        = get_post_meta( get_the_ID(), "etn_sold_tickets", true );
        $total_sold_ticket = isset( $ticket_qty ) ? intval( $ticket_qty ) : 0;
        $data              = Helper::get_tickets_by_event( get_the_ID(), $report_sorting );

        if ( isset( $data['all_sales'] ) && is_array( $data['all_sales'] ) && count( $data['all_sales'] ) > 0 ) {

            foreach ( $data['all_sales'] as $single_sale ) {
                ?>
                <div>
                    <div class="etn-report-row">
                    <strong ><?php echo esc_html__( "invoice no.", "eventin" ); ?></strong> <?php echo esc_html( $single_sale->invoice ); ?>
                    <strong class="etn-report-cell"><?php echo esc_html__( "total qty:", "eventin" ); ?></strong> <?php echo esc_html( $single_sale->single_sale_meta ); ?>
                    <strong class="etn-report-cell"><?php echo esc_html__( "total amount:", "eventin" ); ?></strong> <?php echo esc_html( $single_sale->event_amount ); ?>
                    <strong class="etn-report-cell"><?php echo esc_html__( "email:", "eventin" ); ?></strong> <?php echo esc_html( $single_sale->email ); ?>
                    <strong class="etn-report-cell"><?php echo esc_html__( "status:", "eventin" ); ?></strong> <?php echo esc_html( $single_sale->status ); ?>
                    <strong class="etn-report-cell"><?php echo esc_html__( "payment type:", "eventin" ); ?></strong> <?php echo esc_html( $single_sale->payment_gateway ); ?>
                    </div>
                </div>
                <hr>
                <?php
            }

        }

        ?>
        <div>
          <strong><?php echo esc_html__( "Total tickets sold:", "eventin" ); ?></strong> <?php echo esc_html( $total_sold_ticket ); ?>
        </div>
        <div>
          <strong><?php echo esc_html__( "Total price sold:", "eventin" ); ?></strong> <?php echo isset( $data['total_sale_price'] ) ? esc_html( $data['total_sale_price'] ) : 0; ?>
        </div>
        <?php
    }

    /**
     * Get event price
     */
    public function _cart_item_price( $price, $cart_item, $cart_item_key ) {
        return $price;
    }

    /**
     * Get event name
     */
    public function etn_cart_item_name( $product_title, $cart_item, $cart_item_key ) {

        if ( get_post_type( $cart_item['product_id'] ) == 'etn' ) {
            $_product          = $cart_item['data'];
            $return_value      = $_product->get_title();
            $product_permalink = $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '';

            if ( !$product_permalink ) {
                $return_value = $_product->get_title() . '&nbsp;';
            } else {
                $return_value = sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() );
            }

            return $return_value;
        } else {

            return $product_title;
        }

    }

    /**
     * Post attendee data
     */
    public function insert_attendee_before_add_to_cart() {

        if ( isset( $_POST['ticket_purchase_next_step'] ) && $_POST['ticket_purchase_next_step'] === "three" ) {
            $post_arr = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );
            $check    = wp_verify_nonce( $post_arr['ticket_purchase_next_step_three'], 'ticket_purchase_next_step_three' );

            if ( $check && !empty( $post_arr['attendee_info_update_key'] )
                && !empty( $post_arr["add-to-cart"] ) && !empty( $post_arr["quantity"] )
                && !empty( $post_arr["attendee_name"] ) ) {

                $access_token   = $post_arr['attendee_info_update_key'];
                $event_id       = $post_arr["add-to-cart"];
                $total_attendee = $post_arr["quantity"];
                $payment_token  = md5( 'etn-payment-token' . $access_token . time() . rand( 1, 9999 ) );
                $ticket_price   = get_post_meta( $event_id, "etn_ticket_price", true );

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
                
                //insert attendee custom post
                for ( $i = 0; $i < $total_attendee; $i++ ) {
                    $attendee_name  = !empty( $post_arr["attendee_name"][$i] ) ? $post_arr["attendee_name"][$i] : "";
                    $attendee_email = !empty( $post_arr["attendee_email"][$i] ) ? $post_arr["attendee_email"][$i] : "";
                    $attendee_phone = !empty( $post_arr["attendee_phone"][$i] ) ? $post_arr["attendee_phone"][$i] : "";

                    $post_id = wp_insert_post( [
                        'post_title'  => $attendee_name,
                        'post_type'   => 'etn-attendee',
                        'post_status' => 'publish',
                    ] );

                    if ( $post_id ) {
                        $info_edit_token = md5( 'etn-edit-token' . $post_id . $access_token . time() );
                        $data            = [
                            'etn_status_update_token' => $access_token,
                            'etn_payment_token'       => $payment_token,
                            'etn_info_edit_token'     => $info_edit_token,
                            'etn_timestamp'           => time(),
                            'etn_name'                => $attendee_name,
                            'etn_email'               => $attendee_email,
                            'etn_phone'               => $attendee_phone,
                            'etn_status'              => 'failed',
                            'etn_attendeee_ticket_status'   => 'unused',
                            'etn_ticket_price'              => (float) $ticket_price,
                            'etn_event_id'                  => intval( $event_id ),
                        ];
                        
                        //check and insert attendee extra field data from attendee form
                        if( is_array( $extra_field_array ) && !empty( $extra_field_array ) ){
                            foreach( $extra_field_array as $key => $value ){
                                $data[$value['name']] = $post_arr[$value['name']][$i];
                            }
                        }

                        foreach ( $data as $key => $value ) {
                            // insert post meta data of attendee
                            update_post_meta( $post_id, $key, $value );
                        }

                        // Write post content (triggers save_post).
                        wp_update_post( ['ID' => $post_id] );
                    }

                }

                unset( $_POST['ticket_purchase_next_step'] );
            } else {
                wp_redirect( get_permalink() );
            }

        }

    }

    /**
     * get attendee info update token
     *
     */
    public function add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {

        $post_arr = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

        if ( isset( $post_arr['attendee_info_update_key'] ) ) {

            $cart_item_data['etn_status_update_key'] = $post_arr['attendee_info_update_key'];
        }

        return $cart_item_data;
    }

}
