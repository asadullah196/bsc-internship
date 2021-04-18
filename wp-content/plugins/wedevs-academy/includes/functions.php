<?php

/**
 * Insert a new address 
 * 
 * @param array $args
 * 
 * @return int/WP_Error
 */
function wd_ac_insert_address( $args = [] ) {
     global $wpdb;

     if( empty( $args['name'] ) ) {
        return new \WP_Error( 'no-name', __('You must provide your name', 'wedevs-academy' ) );
     }

     $defults = [
         'name' => '',
         'address' => '',
         'phone' => '',
         'created_by' => get_current_user_id(),
         'created_at' => current_time( 'mysql' ),
     ];

     $data = wp_parse_args( $args, $defults ); 

     $inserted = $wpdb->insert(
         $wpdb->prefix . 'ac_addresses',
         $data,
         [
             '%s',
             '%s',
             '%s',
             '%d',
             '%s'
         ]
     );

    if ( ! $inserted ) {
        return new \WP_Error( 'failed-to-insert', __( 'Failed to insert data', 'wedevs-academy' ) );
    }

    return $wpdb->insert_id;
}

/**
 * Fetch Addresses
 * 
 * @param array $args
 * 
 * @return array
 */
function wd_ac_get_addresses( $args = [] ) {
    global $wpdb;

    $defults = [
        'number' => 20,
        'offset' => 0,
        'orderby' => 'id',
        'order' => 'ASC'
    ];

    $args = wp_parse_args( $args, $defults );

    $items = $wpdb->get_results(
        $wpdb -> prepare(
            "SELECT * FROM {$wpdb->prefix}ac_adresses
            ORDER BY %s %s
            LIMIT %d, %d",
            $args['orderby'], $args['order'], $args['offset'], $args['number']
        )
    );

    return $items;
}

/**
 * Get the count of total address
 * 
 * @return int
 */
function wd_ac_address_count( ) {
    global $wpdb;

    return (int) $wpdb->get_var( "SELECT count(id) FROM {$wpdb->prefix}ac_adresses" );
}