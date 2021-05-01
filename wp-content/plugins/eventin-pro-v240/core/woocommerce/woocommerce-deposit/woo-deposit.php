<?php

defined('ABSPATH') || exit;

if ( !class_exists( 'WC_Product' ) || !class_exists('WC_Order_Item_Product')) {
    return;
}

if( class_exists( 'WooCommerce' ) && class_exists( 'WC_Deposits' ) ) {
    add_filter( 'woocommerce_product_class','etn_woo_product_class',25,3 );
    add_filter( 'woocommerce_product_get_regular_price', 'etn_woocommerce_product_get_price', 10, 2 );
    add_filter( 'woocommerce_product_type_query','etn_woo_product_type',12,2 );
    add_filter( 'woocommerce_checkout_create_order_line_item_object', 'etn_woocommerce_checkout_create_order_line_item_object', 20, 4 );
    add_action( 'woocommerce_checkout_create_order_line_item', 'etn_woocommerce_checkout_create_order_line_item', 20, 4 );
    add_filter( 'woocommerce_get_order_item_classname', 'etn_woocommerce_get_order_item_classname', 20, 3 );
}
class Etn_Woo_Product extends WC_Product  {

    protected $post_type = 'etn';

    public function get_type() {
        return 'etn';
    }

    public function __construct( $product = 0 ) {
        $this->supports[]   = 'ajax_add_to_cart';
        parent::__construct( $product );

    }
    // maybe overwrite other functions from WC_Product

}
class Etn_WC_Order_Item_Product extends WC_Order_Item_Product {
    public function set_product_id( $value ) {
        if ( $value > 0 && 'etn' !== get_post_type( absint( $value ) ) ) {
            $this->error( 'order_item_product_invalid_product_id', __( 'Invalid product ID', 'eventin-pro' ) );
        }
        $this->set_prop( 'product_id', absint( $value ) );
    }
}

function etn_woo_product_class( $class_name ,  $product_type ,  $product_id ) {
    if ($product_type == 'etn')
        $class_name = 'Etn_Woo_Product';
    return $class_name; 
}

function etn_woo_product_type($false,$product_id) { 
    if ($false === false) { // don't know why, but this is how woo does it
        global $post;
        // maybe redo it someday?!
        if (is_object($post) && !empty($post)) { // post is set
            if ($post->post_type == 'etn' && $post->ID == $product_id) 
                return 'etn';
            else {
                $product = get_post( $product_id );
                if (is_object($product) && !is_wp_error($product)) { // post not set but it's a etn
                    if ($product->post_type == 'etn') 
                        return 'etn';
                } // end if 
            }
        } else if(wp_doing_ajax()) { // has post set (usefull when adding using ajax)
            $product_post = get_post( $product_id );
            if ($product_post->post_type == 'etn') 
                return 'etn';
        } else { 
            $product = get_post( $product_id );
            if (is_object($product) && !is_wp_error($product)) { // post not set but it's a etn
                if ($product->post_type == 'etn') 
                    return 'etn';
            } // end if 
        } // end if  // end if 
    } // end if 
    return false;
}

function etn_woocommerce_checkout_create_order_line_item_object($item, $cart_item_key, $values, $order) {

    $product = $values['data'];
    if ($product->get_type() ==  'etn') {
        return new Etn_WC_Order_Item_Product();
    } // end if 
    return $item ;
}   


function etn_woocommerce_checkout_create_order_line_item($item,$cart_item_key,$values,$order) {
    if ($values['data']->get_type() ==  'etn') {
        $item->update_meta_data( '_etn', 'yes' ); // add a way to recognize custom post type in ordered items
        return;
    } // end if 

}


function etn_woocommerce_get_order_item_classname($classname, $item_type, $id) {
    global $wpdb;
    $is_IA = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}woocommerce_order_itemmeta WHERE order_item_id = {$id} AND meta_key = '_etn'");

    if ('yes' === $is_IA) { // load the new class if the item is our custom post
        $classname = 'Etn_WC_Order_Item_Product';
    } // end if 
    return $classname;
}
?>