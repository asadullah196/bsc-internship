<?php

namespace weDevs\Academy\Admin;

/**
 * Addressbook handler class
 */
class Addressbook {
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
    }
}