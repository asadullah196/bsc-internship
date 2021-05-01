<?php

add_action( "eventin/after_thankyou", "etn_thankyou_extra_options" );

if( class_exists( 'WooCommerce' ) ){
    add_filter( 'woocommerce_thankyou_order_received_text', 'etn_thank_you_title', 20, 2 );
    add_filter( 'woocommerce_endpoint_order-received_title', 'etn_thank_you_title_details' );
}

function etn_thank_you_title( $thank_you_title, $order ) {
    $thank_you_markup = strtoupper( "Invoice: " . $order->get_order_key() );
    return $thank_you_markup;
}

function etn_thank_you_title_details( $old_title ) {
    return "Order Received";
}

function etn_thankyou_extra_options() {
    ?>
    <div class="extra-buttons">
        <button class="etn-btn etn-primary" onclick="etn_pro_pirnt_content_area('woocommerce-order');"><?php echo esc_html__( "Print", "eventin-pro" ); ?></button>
        <a class="etn-btn etn-primary download-invoice-pdf" href="javascript:etn_pro_download_pdf()" ><?php echo esc_html__( "Download", "eventin-pro" ); ?></a>
    </div>
    <?php
}