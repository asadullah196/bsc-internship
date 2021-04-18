<?php

namespace weDevs\Academy\Admin;

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once ABSPATH. 'wp-admin/includes/class-wp-list-table.php';
}

class Address_List extends \WP_List_Table {
    function __construct() {
        parrent::__construct([
            'singular' => 'contact',
            'plural' => 'contacts',
            'ajax' => false
        ]);
    }
}