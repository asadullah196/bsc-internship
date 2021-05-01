<?php
namespace Etn_Pro\Utils\License;

class License {
    use \Etn_Pro\Traits\Singleton;

    public function init() {
        // THE AJAX ADD ACTIONS
        add_action( 'wp_ajax_activate_license', [$this, 'activate_license'] );
        add_action( 'wp_ajax_nopriv_activate_license', [$this, 'activate_license'] );

        add_action( 'wp_ajax_deactivate_license', [$this, 'deactivate_license'] );
        add_action( 'wp_ajax_nopriv_deactivate_license', [$this, 'deactivate_license'] );

        add_action( 'wp_ajax_save_market_place', [$this, 'save_market_place'] );
        add_action( 'wp_ajax_nopriv_save_market_place', [$this, 'save_market_place'] );

    }

    public function activate_license() {

        $edd_action_type = !empty( $_POST["edd_action_type"] ) ? trim( $_POST["edd_action_type"] ) : "";
        $license_key     = !empty( $_POST["license_key"] ) ? trim( $_POST["license_key"] ) : "";
        $item_id         = \Etn_Pro\Bootstrap::instance()->product_id();
        $store_url       = \Etn_Pro\Bootstrap::instance()->store_url();

        if ( empty( $edd_action_type ) || empty( $license_key ) || empty( $item_id ) || empty( $store_url ) ) {
            echo "invalid";
        } else {

            $item_id    = $item_id;
            $license    = $license_key;
            $api_params = [
                'edd_action' => $edd_action_type,
                'license'    => urlencode($license),
                'item_id'    => urlencode( $item_id ),
                'url'        => home_url(),
            ];

            $response = wp_remote_get( $store_url, ['body' => $api_params, 'timeout' => 15, 'redirection' => 3, 'sslverify' => false] );

            if ( is_wp_error( $response ) ) {
                echo "error";
                wp_die();
            }

            $body         = wp_remote_retrieve_body( $response );
            $license_data = json_decode( $body );

            if ( $license_data->license == 'valid' ) {
                $license        = $license_key;
                $license_status = 'valid';

                update_option( "etn_license_key", $license );
                update_option( "etn_license_status", $license_status );
                $this->global_var_cache_set( 'eventin_license_status', $license_status );

                echo "valid";

            } else {
                echo "invalid";
            }

        }

        exit;

    }

    public function save_market_place() {

        $market_place = !empty( $_POST["market_place"] ) ? trim( $_POST["market_place"] ) : "";

        if ( empty( $market_place ) ) {
            echo "invalid";
        } else {

            if ( update_option( "etn_premium_marketplace", $market_place ) ) {
                echo "valid";
            } else {
                echo "invalid";
            }

        }

        exit;

    }

    public function check_license_validity( $license_key ) {
        $edd_action_type = 'check_license';
        $item_id         = \Etn_Pro\Bootstrap::instance()->product_id();
        $store_url       = \Etn_Pro\Bootstrap::instance()->store_url();

        if ( empty( $edd_action_type ) || empty( $license_key ) || empty( $item_id ) || empty( $store_url ) ) {
            echo "invalid";
        } else {
            $item_id    = $item_id;
            $license    = $license_key;
            $api_params = [
                'edd_action' => $edd_action_type,
                'license'    => urlencode($license),
                'item_id'    => urlencode( $item_id ),
                'url'        => home_url(),
            ];

            $response = wp_remote_get( $store_url, ['body' => $api_params, 'timeout' => 15, 'redirection' => 3, 'sslverify' => false] );

            if ( is_wp_error( $response ) ) {
                echo "error";
                wp_die();
            }

            $body         = wp_remote_retrieve_body( $response );
            $license_data = json_decode( $body );

            if ( $license_data->license == 'valid' ) {
                return true;
            } else {
                return false;
            }

        }

        // exit;
    }

    public function deactivate_license() {
        $edd_action_type = !empty( $_POST["edd_action_type"] ) ? trim( $_POST["edd_action_type"] ) : '';
        $license_key     = get_option( 'etn_license_key' );
        $item_id         = \Etn_Pro\Bootstrap::instance()->product_id();
        $store_url       = \Etn_Pro\Bootstrap::instance()->store_url();

        if ( empty( $edd_action_type ) || empty( $license_key ) || empty( $item_id ) || empty( $store_url ) ) {
            echo "invalid";
        } else {

            $item_id    = $item_id;
            $license    = $license_key;
            $api_params = [
                'edd_action' => $edd_action_type,
                'license'    => urlencode($license),
                'item_id'    => urlencode( $item_id ),
                'url'        => home_url(),
            ];

            $response = wp_remote_get( $store_url, ['body' => $api_params, 'timeout' => 15, 'redirection' => 3, 'sslverify' => false] );

            if ( is_wp_error( $response ) ) {
                echo "error";
                wp_die();
            }

            $body         = wp_remote_retrieve_body( $response );
            $license_data = json_decode( $body );

            if ( $license_data->license == 'deactivated' ) {
                $license_status = 'invalid';

                delete_option( 'etn_license_key' );
                delete_option( 'etn_license_status' );
                $this->global_var_cache_set( 'eventin_license_status', $license_status );

                echo 'deactivated';

            } else {
                echo 'deactivated';
            }

        }

        exit;
    }

    public function global_var_cache_get( $key ) {
        global $etn_global_var_cache;

        if ( isset( $etn_global_var_cache[$key] ) ) {
            return $etn_global_var_cache[$key];
        }

        return null;
    }

    public function global_var_cache_set( $key, $value ) {
        global $etn_global_var_cache;
        $etn_global_var_cache[$key] = $value;

        return true;
    }

    public function status() {
        $cached = $this->global_var_cache_get( 'eventin_license_status' );
        //return cached data if any
        if ( null !== $cached ) {
            return $cached;
        }

        //check if any license data is stored
        $license_key    = get_option( 'etn_license_key' );
        $license_status = get_option( 'etn_license_status' );
        $status         = 'invalid';

        // check if stored data is valid
        if ( 'valid' == $license_status && !empty( $license_key ) ) {
            //check if license active and update local storage
            $is_license_key_valid   = $this->check_license_validity( $license_key );

            if( $is_license_key_valid ){
                $status = 'valid';
            } else {
                delete_option( 'etn_license_key' );
                delete_option( 'etn_license_status' );
            }
        }
        $this->global_var_cache_set( 'eventin_license_status', $status );

        return $status;
    }

}

?>