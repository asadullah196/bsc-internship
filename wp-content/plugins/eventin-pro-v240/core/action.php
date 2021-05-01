<?php
namespace Etn_Pro\Core;

defined( 'ABSPATH' ) || exit;

class Action {

    use \Etn\Traits\Singleton;

    public $etn_pro_attende_report;
    public $search_count;

    /**
     * Query to get attendee list
     */
    public function attendee_list( $id, $args ) {

        global $wpdb;
        $defaults = [
            'limit'   => 999999999999,
            'offset'  => 0,
            'orderby' => 'event_id',
            'order'   => 'DESC',
        ];
        $args  = wp_parse_args( $args, $defaults );
        $items = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}etn_events
            WHERE post_id = $id
            ORDER BY {$args['orderby']} {$args['order']}
            LIMIT %d, %d", $args['offset'], $args['limit']
            ) );
        $tickets = 0;

        if ( class_exists( 'Woocommerce' ) && is_array( $items ) && !empty( $items ) ) {

            foreach ( $items as &$value ) {
                $order_id = wc_get_order_id_by_order_key( $value->invoice );

                if ( !empty( $order_id ) ) {
                    $order = wc_get_order( $order_id );

                    foreach ( $order->get_items() as $item_id => $item ) {
                        $tickets = (int) $item->get_quantity();
                    }

                }

                $value->no_of_tickets = $tickets;
                $value->full_name = $order->get_billing_first_name() . " " . $order->get_billing_last_name();
            }

        }

        return $items;
    }

    /**
     * Count attendee
     */
    public function total_attendee( $id, $email_remaindar = false ) {
        global $wpdb;

        if ( $email_remaindar ) {
            $items = $wpdb->get_results(
                "SELECT * FROM {$wpdb->prefix}etn_events
                WHERE post_id = $id" );
            return $items;
        } else {
            $items = $wpdb->get_var(
                "SELECT  COUNT(*) FROM {$wpdb->prefix}etn_events
                 WHERE post_id = $id"
            );
            return $items;
        }

    }

    /**
     * Purchase history
     */
    public function purchase_history( $args ) {
        $data     = [];
        $defaults = [
            'limit'        => 999999999999,
            'offset'       => 0,
            'taxonomy_cat' => '',
            'taxonomy_tag' => '',
            'event_name'   => '',
            'order_by'     => 'title',
            'order'        => 'DESC',
        ];

        $args             = wp_parse_args( $args, $defaults );
        $purchase_history = [];
        $query            = [
            'post_type'      => 'etn',
            'post_status'    => 'publish',
            'orderby'        => [$args['order_by'] => $args['order']],
            'posts_per_page' => $args['limit'],
            'offset'         => $args['offset'],
        ];

        if ( $args['taxonomy_cat'] !== '' ) {
            $query['tax_query'] = [
                [
                    'taxonomy' => 'etn_category',
                    'field'    => 'name',
                    'terms'    => $args['taxonomy_cat'],
                ]];
        }

        if ( $args['taxonomy_tag'] !== '' ) {
            $query['tax_query'] = [
                [
                    'taxonomy' => 'etn_tags',
                    'field'    => 'name',
                    'terms'    => $args['taxonomy_tag'],
                ]];
        }

        if ( $args['event_name'] !== '' ) {
            $query['s'] = $args['event_name'];
        }

        $get_all_posts      = get_posts( $query );
        $this->search_count = count( $get_all_posts );

        if ( is_array( $get_all_posts ) && count( $get_all_posts ) > 0 ) {

            foreach ( $get_all_posts as $key => $post ) {
                $post_id                            = $post->ID;
                $purchase_history[$key]['event_id'] = $post_id;
                $purchase_history[$key]['title']    = get_the_title( $post_id );

                $total_sold_ticket = get_post_meta( $post_id, "etn_sold_tickets", true );
                $available_ticket  = get_post_meta( $post_id, "etn_avaiilable_tickets", true );
                $available_ticket  = isset( $available_ticket ) && ( "" != $available_ticket ) ? intval( $available_ticket ) : 0;
                $total_sold_ticket = isset( $total_sold_ticket ) && ( "" != $total_sold_ticket ) ? intval( $total_sold_ticket ) : 0;

                $purchase_history[$key]['available_ticket'] = $available_ticket;
                $purchase_history[$key]['sold_ticket']      = $total_sold_ticket;

                $all_sales        = \Etn_Pro\Core\Action::instance()->get_all_event( $post_id );
                $total_sale_price = 0;

                if ( is_array( $all_sales ) && count( $all_sales ) > 0 ) {

                    foreach ( $all_sales as $single_sale ) {

                        if ( is_object( $single_sale ) ) {
                            $total_sale_price += $single_sale->event_amount;
                        }

                    }

                }

                $remaining_ticket = $available_ticket - $total_sold_ticket;

                $purchase_history[$key]['sale_price']       = $total_sale_price;
                $purchase_history[$key]['remaining_ticket'] = $remaining_ticket;
            }

        }

        wp_reset_postdata();

        $data['data'] = $purchase_history;

        if ( $args['filter_name'] === 'Filter' ) {
            $data['count'] = $this->total_purchase( false, true );
        } else {
            $data['count'] = $this->total_purchase( false, false );
        }

        return $data;
    }

    /**
     * Count purchase history
     *
     * @return void
     */
    public function total_purchase( $summary = false, $search = false ) {
        $query = [
            'post_type'      => 'etn',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ];
        $get_all_posts = get_posts( $query );
        $events        = count( $get_all_posts );

        if ( $summary == true ) {
            $purhcase_summary = [];
            $total_sale_price = 0;
            $tickets          = 0;

            if ( is_array( $get_all_posts ) && !empty( $get_all_posts ) ) {

                foreach ( $get_all_posts as $key => $post ) {
                    $all_sales = \Etn_Pro\Core\Action::instance()->get_all_event( $post->ID );

                    foreach ( $all_sales as $single_sale ) {

                        if ( is_object( $single_sale ) ) {
                            $total_sale_price += $single_sale->event_amount;

                            if ( class_exists( 'Woocommerce' ) ) {
                                $order_id = wc_get_order_id_by_order_key( $single_sale->invoice );

                                if ( !empty( $order_id ) ) {
                                    $order = wc_get_order( $order_id );

                                    foreach ( $order->get_items() as $item_id => $item ) {
                                        $tickets += (int) $item->get_quantity();
                                    }

                                }

                            }

                        }

                    }

                }

                $sale_tickets = $tickets;
                $sale_price   = $total_sale_price;
            } else {
                $sale_tickets = 0;
                $sale_price   = 0;
            }

            $purhcase_summary['events']       = $events;
            $purhcase_summary['sale_tickets'] = $sale_tickets;
            $purhcase_summary['sale_price']   = $sale_price;

            return $purhcase_summary;
        } elseif ( $search == true ) {
            return $this->search_count;
        } else {
            return $events;
        }

        wp_reset_postdata();
    }

    public function purchase_summary() {
        return $this->total_purchase( true );
    }

    /**
     * get event by id function
     */
    public function get_all_event( $post_id ) {
        global $wpdb;
        $all_sales = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}etn_events WHERE post_id = $post_id order by event_id DESC" );

        return $all_sales;
    }

    /**
     * Export attendee function
     */
    public function csv_export_attendee_report( $id ) {

        // Check for current user privileges
        if ( !current_user_can( 'manage_options' ) || !is_admin() ) {
            return;
        }

        $attendee_report = $this->attendee_list( $id, [] );

        if ( is_array( $attendee_report ) && !empty( $attendee_report ) ) {

            $generated_date = date( 'd-m-Y His' ); //Date will be part of file name.


            header( "Content-type: text/csv" );
            header( "Content-Disposition: attachment; filename=\"etn_attendee_" . $generated_date . ".csv\";" );

            ob_end_clean();
            // create a file pointer connected to the output stream
            $output = fopen( 'php://output', 'w' ) or die( "Can\'t open php://output" );

            // output the column headings
            fputcsv( 
                $output, 
                [
                    'Invoice', 
                    "Email", 
                    "Payment", 
                    "No of tickets", 
                    "Date", 
                    "Status"
                ]
            );

            foreach ( $attendee_report as $key => $value ) {
                fputcsv( 
                    $output,
                    [
                        $value->invoice, 
                        $value->email, 
                        $value->payment_gateway,
                        $value->no_of_tickets, 
                        "=\"" . $value->date_time . "\"", 
                        $value->status
                    ]
                );

            }

            // Close output file stream
            fclose( $output );

            die();
        } else {
            ?>
            <div class=""><?php echo esc_html__( 'No data found.', 'eventin-pro' ) ?></div>
            <?php
        }

    }

}
