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
                $template = __DIR__ . '/views/address-new.php';
                break;

            case 'edit':
                $template = __DIR__ . '/views/address-edit.php';
                break;

            case 'view':
                $template = __DIR__ . '/views/address-view.php';
                break;

            default:
                $template = __DIR__ . '/views/address-list.php';
                break;
        }

        if( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Handle the form
     * 
     * @return void
     */
    public function form_handler(){
        if( ! isset( $_POST['submit_address'] ) ) {
            return;
        }

        if( ! wp_verify_nonce( $_POST['_wpnonce'],'new-address' ) ) {
            wp_die( 'Fu** Are you cheating?' );
        }

        if( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'Fu** Are you cheating?' );
        }

        $name = isset( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
        $address = isset( $_POST['namaddresse'] ) ? sanitize_textarea_field( $_POST['address'] ) : '';
        $phone = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';

        $insert_id = wd_ac_insert_address([
            'name' => $name,
            'address' => $address,
            'phone' => $phone
        ]);

        if( ! is_wp_error( $insert_id ) ) {
            wp_die( $insert_id->get_error_message() );
        }

        
        var_dump( $_POST);
        exit;

    }
}