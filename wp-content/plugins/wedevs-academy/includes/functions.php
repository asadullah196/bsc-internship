<?php

function wd_ac_insert_address( $args = [] ) {
     global $wpdb;

     $defults = [
         'name' => '',
         'address' => '',
         'phone' => '',
         'created_by' => get_current_user_id(),
         'created_at' => current_time( 'mysql' ),
     ];

     $data = wp_parse_args ( $args, $defults ); 

     $wpdb->insert(
         "{$wpdb->prefix}ac_addresses",
         $data,
         $format
     );
}