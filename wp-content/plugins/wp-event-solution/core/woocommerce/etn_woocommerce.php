<?php

use Etn\Utils\Helper;

defined('ABSPATH') || exit;

if ( !class_exists( 'WC_Product_Data_Store_CPT' ) ) {
    return;
}

class Etn_Product_Data_Store_CPT extends WC_Product_Data_Store_CPT implements WC_Object_Data_Store_Interface, WC_Product_Data_Store_Interface {

    /**
     * Method to read a product from the database.
     * @param WC_Product
     */
    public function read( &$product ) {

        $product->set_defaults();

        if ( !$product->get_id() || !( $post_object = get_post( $product->get_id() ) ) || !in_array( $post_object->post_type, ['etn', 'product'] ) ) {
            throw new Exception( esc_html__( 'Invalid product.', 'eventin' ) );
        }

        $id = $product->get_id();

        $product->set_props( [
            'name'              => $post_object->post_title,
            'slug'              => $post_object->post_name,
            'date_created'      => 0 < $post_object->post_date_gmt ? wc_string_to_timestamp( $post_object->post_date_gmt ) : null,
            'date_modified'     => 0 < $post_object->post_modified_gmt ? wc_string_to_timestamp( $post_object->post_modified_gmt ) : null,
            'status'            => $post_object->post_status,
            'description'       => $post_object->post_content,
            'short_description' => $post_object->post_excerpt,
            'parent_id'         => $post_object->post_parent,
            'menu_order'        => $post_object->menu_order,
            'reviews_allowed'   => 'open' === $post_object->comment_status,
        ] );

        $this->read_attributes( $product );
        $this->read_downloads( $product );
        $this->read_visibility( $product );
        $this->read_product_data( $product );
        $this->read_extra_data( $product );
        $product->set_object_read( true );
    }

    /**
     * Get the product type based on product ID.
     */
    public function get_product_type( $product_id ) {

        $post_type = get_post_type( $product_id );

        if ( 'product_variation' === $post_type ) {
            return 'variation';
        } elseif ( in_array( $post_type, ['etn', 'product'] ) ) {
            $terms = get_the_terms( $product_id, 'product_type' );
            return !empty( $terms ) ? sanitize_title( current( $terms )->name ) : 'etn';
        } else {
            return false;
        }

    }

}

    /**
     * returns the price of the custom product
     * product is the custom post we are creating
     */
    function etn_woocommerce_product_get_price( $price, $product ) {
        $product_id = $product->get_id();

        if ( get_post_type( $product_id ) == 'etn' ) {
            $price = get_post_meta( $product_id, 'etn_ticket_price', true );
            $price = isset( $price ) ? ( floatval( $price ) ) : 0;
        }

        return $price;
    }

    /**
     * overwrite woocommerce store and make our custom post as a product
     */
    function etn_woocommerce_data_stores( $stores ) {
        $stores['product'] = 'Etn_Product_Data_Store_CPT';

        return $stores;
    }

    /**
     * Return product quantity
     */
    function wc_cart_item_quantity( $product_quantity, $cart_item_key, $cart_item ) {

        // deactivate product quantity
        if ( is_cart() ) {
            if ( get_post_type( $cart_item['product_id'] ) == 'etn' ) {

                $product_quantity = sprintf( '%2$s <input type="hidden" name="cart[%1$s][qty]" value="%2$s" />', $cart_item_key, $cart_item['quantity'] );
            }

        }

        return $product_quantity;
    }

    /**
     * aftersuccessfull checkout, some data are returned from woocommerce
     * we can use these data to update our own data storage / tables
     */
    function etn_checkout_callback( $order_id ) {

        if ( !$order_id ) {
            return;
        }

        global $wpdb;
        $order = wc_get_order( $order_id );
        if ( $order->is_paid() ) {
            $paid = 'Paid';
        } else {
            $paid = 'Unpaid';
        }

        // Allow code execution only once
        if ( !get_post_meta( $order_id, '_thankyou_action_done', true ) ) {

            $userId = 0;
            if ( is_user_logged_in() ) {
                $userId = get_current_user_id();
            }
            foreach ( $order->get_items() as $item_id => $item ) {
                // Get the product name
                $product_name     = $item->get_name();
                $product_quantity = (int) $item->get_quantity();
                $product_total    = $item->get_total();
                $my_post          = get_page_by_title( $product_name, OBJECT, 'etn' );                

                if ( !empty( $my_post ) ) {

                    $post_id              = $my_post->ID;
                    $etn_sold_tickets     = get_post_meta( $post_id, 'etn_sold_tickets', true );
                    $etn_sold_tickets     = isset( $etn_sold_tickets ) ? intval( $etn_sold_tickets ) : 0;
                    $updated_sold_tickets = $etn_sold_tickets + intval( trim( $product_quantity ) );
                    update_post_meta( $post_id, 'etn_sold_tickets', $updated_sold_tickets );

                    $post_status = isset( $my_post->post_status ) ? $my_post->post_status : '';

                    if ( $post_status == 'wc-pending' ) {
                        $status = 'Pending';
                    } else

                    if ( $post_status == 'wc-processing' ) {
                        $status = 'Review';
                    } else

                    if ( $post_status == 'wc-on-hold' ) {
                        $status = 'Review';
                    } else

                    if ( $post_status == 'wc-completed' ) {
                        $status = 'Active';
                    } else

                    if ( $post_status == 'wc-refunded' ) {
                        $status = 'Refunded';
                    } else

                    if ( $post_status == 'wc-failed' ) {
                        $status = 'DeActive';
                    } else {
                        $status = 'Pending';
                    }

                    $paymentType = get_post_meta( $order_id, '_payment_method', true );

                    if ( $paymentType == 'cod' ) {
                        $etn_payment_method = 'offline_payment';
                    } else

                    if ( $paymentType == 'bacs' ) {
                        $etn_payment_method = 'bank_payment';
                    } else

                    if ( $paymentType == 'cheque' ) {
                        $etn_payment_method = 'check_payment';
                    } else

                    if ( $paymentType == 'stripe' ) {
                        $etn_payment_method = 'stripe_payment';
                    } else {
                        $etn_payment_method = 'online_payment';
                    }

                    $pledge_id = "";

                    $insert_post_id         = $post_id;
                    $insert_form_id         = $order_id;
                    $insert_invoice         = get_post_meta( $order_id, '_order_key', true );
                    $insert_event_amount    = $product_total;
                    $insert_user_id         = $userId;
                    $insert_email           = get_post_meta( $order_id, '_billing_email', true );
                    $insert_event_type      = "ticket";
                    $insert_payment_type    = 'woocommerce';
                    $insert_pledge_id       = $pledge_id;
                    $insert_payment_gateway = $etn_payment_method;
                    $insert_date_time       = date( "Y-m-d" );
                    $insert_status          = $status;
                    $inserted               = $wpdb->query( "INSERT INTO `" . $wpdb->prefix . "etn_events` (`post_id`, `form_id`, `invoice`, `event_amount`, `user_id`, `email`, `event_type`, `payment_type`, `pledge_id`, `payment_gateway`, `date_time`, `status`) VALUES ('$insert_post_id', '$insert_form_id', '$insert_invoice', '$insert_event_amount', '$insert_user_id', '$insert_email', '$insert_event_type', '$insert_payment_type', '$insert_pledge_id', '$insert_payment_gateway', '$insert_date_time', '$insert_status')" );
                    $id_insert              = $wpdb->insert_id;

                    if ( $inserted ) {
                        $metaKey                              = [];
                        $metaKey['_etn_first_name']           = get_post_meta( $order_id, '_billing_first_name', true );
                        $metaKey['_etn_last_name']            = get_post_meta( $order_id, '_billing_last_name', true );
                        $metaKey['_etn_email']                = get_post_meta( $order_id, '_billing_email', true );
                        $metaKey['_etn_post_id']              = $post_id;
                        $metaKey['_etn_order_key']            = '_etn_' . $id_insert;
                        $metaKey['_etn_order_shipping']       = get_post_meta( $order_id, '_order_shipping', true );
                        $metaKey['_etn_order_shipping_tax']   = get_post_meta( $order_id, '_order_shipping_tax', true );
                        $metaKey['_etn_order_qty']            = $product_quantity;
                        $metaKey['_etn_order_total']          = $product_total;
                        $metaKey['_etn_order_tax']            = get_post_meta( $order_id, '_order_tax', true );
                        $metaKey['_etn_addition_fees']        = 0;
                        $metaKey['_etn_addition_fees_amount'] = 0;
                        $metaKey['_etn_addition_fees_type']   = '';
                        $metaKey['_etn_country']              = get_post_meta( $order_id, '_billing_country', true );
                        $metaKey['_etn_currency']             = get_post_meta( $order_id, '_order_currency', true );
                        $metaKey['_etn_date_time']            = date( "Y-m-d H:i:s" );

                        foreach ( $metaKey as $k => $v ) {
                            $data               = [];
                            $data["event_id"]   = $id_insert;
                            $data["meta_key"]   = $k;
                            $data["meta_value"] = $v;
                            $wpdb->insert( $wpdb->prefix . "etn_trans_meta", $data );
                        }
                    }

                    // ========================== Attendee related works start ========================= //
                    $settings               = Helper::get_settings();
                    $attendee_reg_enable    = !empty( $settings["attendee_registration"] ) ? true : false;
                    if( $attendee_reg_enable ){
                        // update attendee status and send ticket to email
                        $event_location   = !is_null( get_post_meta( $my_post->ID , 'etn_event_location', true ) ) ? get_post_meta( $my_post->ID , 'etn_event_location', true ) : "";
                        $etn_ticket_price = !is_null( get_post_meta( $my_post->ID , 'etn_ticket_price', true ) ) ? get_post_meta( $my_post->ID , 'etn_ticket_price', true ) : "";
                        $etn_start_date   = !is_null( get_post_meta( $my_post->ID , 'etn_start_date', true ) ) ? get_post_meta( $my_post->ID , 'etn_start_date', true ) : "";
                        $etn_end_date     = !is_null( get_post_meta( $my_post->ID , 'etn_end_date', true ) ) ? get_post_meta( $my_post->ID , 'etn_end_date', true ) : "";
                        $etn_start_time   = !is_null( get_post_meta( $my_post->ID , 'etn_start_time', true ) ) ? get_post_meta( $my_post->ID , 'etn_start_time', true ) : "";
                        $etn_end_time     = !is_null( get_post_meta( $my_post->ID , 'etn_end_time', true ) ) ? get_post_meta( $my_post->ID , 'etn_end_time', true ) : "";
                        $update_key       = !is_null( $item->get_meta( 'etn_status_update_key', true ) ) ? $item->get_meta( 'etn_status_update_key', true ) : "";
                        $insert_email     = !is_null( get_post_meta( $order_id, '_billing_email', true ) ) ? get_post_meta( $order_id, '_billing_email', true ) : "";
            
                        $pdf_data = [
                            'order_id'          => $order_id,
                            'event_name'        => $product_name ,
                            'update_key'        => $update_key ,
                            'user_email'        => $insert_email , 
                            'event_location'    => $event_location , 
                            'etn_ticket_price'  => $etn_ticket_price,
                            'etn_start_date'    => $etn_start_date,
                            'etn_end_date'      => $etn_end_date,
                            'etn_start_time'    => $etn_start_time,
                            'etn_end_time'      => $etn_end_time  
                        ];
                        
                        mail_attende_report( $pdf_data );
                    }
                    // ========================== Attendee related works start ========================= //
                }
            }
            $order->update_meta_data( '_thankyou_action_done', true );
            $order->save();
        }
        ?>
        <div class="etn-thankyou-page-order-details">
            <?php echo esc_html__( "Order ID: ", "eventin" ) . esc_html( $order_id ); ?> | <?php echo esc_html__("Order Status: ", "eventin") . esc_html( $order->get_status() ); ?> | <?php echo esc_html__( "Order is Payment Status: ", "eventin" ) . esc_html( $paid ); ?>
        </div>
        <?php
        //checking for zoom event
        show_zoom_events_details( $order );

        do_action("eventin/after_thankyou");

    }

    /**
     * update attendee status and send ticket to email
     */
    function mail_attende_report( $pdf_data ){

        global $wpdb;

        if( is_array( $pdf_data ) &&  !empty( $pdf_data['update_key'] ) ){
            $prepare_guery              = $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta where meta_key ='etn_status_update_token' and meta_value = '%s' ", $pdf_data['update_key'] );
            $current_order_attendees    = $wpdb->get_col( $prepare_guery );
            $order                      = wc_get_order( $pdf_data['order_id'] );
            $order_status               = $order->get_status();

            
            ob_start();
            if( is_array($current_order_attendees) && !empty( $current_order_attendees ) ){
                foreach ($current_order_attendees as $key => $value) {
                    $attendee_id    = intval($value) ;

                    //update attendee status
                    update_post_meta(  $attendee_id, 'etn_attendee_order_id' , $pdf_data['order_id'] );
                    Helper::update_attendee_payment_status( $attendee_id, $order_status );

                    //generate email content markup
                    $attendee_name  = get_the_title( $attendee_id );
                    $edit_token     = get_post_meta( $attendee_id , 'etn_info_edit_token' , true );

                    $base_url               = home_url( );
                    $attendee_cpt           = new \Etn\Core\Attendee\Cpt();
                    $attendee_endpoint      = $attendee_cpt->get_name();
                    $action_url             = $base_url . "/" . $attendee_endpoint;
                    $ticket_download_link   = $action_url . "?etn_action=". urlencode('download_ticket') ."&attendee_id=" . urlencode($attendee_id) . "&etn_info_edit_token=" . urlencode($edit_token); 
                    $edit_information_link  = $action_url . "?etn_action=". urlencode('edit_information') ."&attendee_id=" . urlencode($attendee_id) . "&etn_info_edit_token=" . urlencode($edit_token); 
                    ?>
                    <div class="etn-attendee-details-button-parent">
                        <div class="etn-attendee-details-name"><?php echo esc_html__('Attendee: ','eventin') . esc_html( $attendee_name ) ;?></div>
                        <div class="etn-attendee-details-button-download">
                            <a class="etn-btn etn-success download-details" target="_blank" href="<?php echo esc_url( $ticket_download_link ); ?>"><?php  echo esc_html__('Download Ticket','eventin');?></a>
                             | 
                            <a class="etn-btn etn-success edit-information" target="_blank" href="<?php echo esc_url( $edit_information_link ); ?>"><?php  echo esc_html__('Edit Information','eventin');?></a>
                        </div>
                    </div>
                    <?php
                }
            }
            $content            = ob_get_clean();
            $mail_content       = Helper::kses( $content );
            $settings_options   = Helper::get_settings();
    
            if ( is_array($pdf_data) && !empty( $settings_options['admin_mail_address'] ) && !empty( $pdf_data['user_email'] ) ) {
                $to         = $pdf_data['user_email'];
                $subject    = esc_html__( 'Event Ticket', "eventin" );
                $from       = $settings_options['admin_mail_address'];
                $from_name  = get_bloginfo( "name" );
                Helper::send_email( $to, $subject, $mail_content, $from, $from_name );
            }
        }
    }

    /**
     * after successful checkout, customize data after table in email 
     */
    function etn_email_after_order_table( $order, $sent_to_admin, $plain_text, $email ) {
        show_zoom_events_details( $order );
    }


    /**
     * check if any zoom meeting exists in order
     */
    function show_zoom_events_details( $order ) {
        
        foreach ( $order->get_items() as $item_id => $item ) {
            // Get the product name
            $product_name     = $item->get_name();
            $product_post     = get_page_by_title( $product_name, OBJECT, 'etn' );

            if ( !empty( $product_post ) ) {
                $post_id = $product_post->ID;
                process_zoom_events($post_id);
            }
        }
    }

    /**
     * check if provided event is zoom, if so then print zoom meeting join url
     */
    function process_zoom_events( $event_id ){

        $is_zoom_event = get_post_meta( $event_id, 'etn_zoom_event', true );
        if(isset( $is_zoom_event ) && "on" == $is_zoom_event){
            $zoom_meeting_id = get_post_meta( $event_id, 'etn_zoom_id', true );
            if(isset( $zoom_meeting_id ) && "" != $zoom_meeting_id){
                $event_name = get_the_title( $event_id );
                $zoom_meeting_url = get_post_meta( $zoom_meeting_id, 'zoom_join_url', true );
                ?>
                <div class="etn-invoice-zoom-event">
                    <span class="etn-invoice-zoom-event-title"><?php echo esc_html( $event_name ); ?></span> <?php echo esc_html__(" zoom meeting URL : ", "eventin"); ?>
                    <a target="_blank" href="<?php echo esc_url( $zoom_meeting_url ); ?>"> <?php echo esc_html( $zoom_meeting_url ); ?></a>
                </div>
                <?php
            }
        }
    }


    //all hooks required to hook our event as woocommerce product
    add_filter( 'woocommerce_data_stores', 'etn_woocommerce_data_stores' );
    add_filter( 'woocommerce_product_get_price', 'etn_woocommerce_product_get_price', 10, 2 );
    add_filter( 'woocommerce_cart_item_quantity', 'wc_cart_item_quantity', 10, 3 );
    add_action( 'woocommerce_email_after_order_table', 'etn_email_after_order_table', 10, 4 );
    add_action( 'woocommerce_thankyou', 'etn_checkout_callback', 10, 1 );
