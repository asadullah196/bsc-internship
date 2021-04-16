<?php

namespace weDevs\Academy\Admin;

/**
 * Addressbook handler class
 */
class Addressbook {
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';

        switch ( $action ){
            case 'new':
                $template = __DIR__ . '/view/address-new.php';
                break;

            case 'edit':
                $template = __DIR__ . '/view/address-edit.php';
                break;

            case 'view':
                $template = __DIR__ . '/view/address-view.php';
                break;

            default:
                $template = __DIR__ . '/view/address-list.php';
                break;
        }

        if( file_exists( $template ) ) {
            include $template;
        }
    }
}