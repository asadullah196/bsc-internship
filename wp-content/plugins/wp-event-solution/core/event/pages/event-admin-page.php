<?php

namespace Etn\Core\Event\Pages;

defined( 'ABSPATH' ) || exit;

class Event_Admin_Page {

    public function add_admin_pages() {

        if ( current_user_can( 'editor' ) || current_user_can( 'administrator' ) ) {
            add_menu_page(
                'Eventin Event Manager',
                'Eventin',
                'read',
                'etn-events-manager',
                '',
                'dashicons-calendar',
                10
            );
        }
    }

}
