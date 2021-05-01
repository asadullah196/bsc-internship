<?php

defined( 'ABSPATH' ) || exit;


$etn_faqs = get_post_meta( $single_event_id, 'etn_event_faq', true );

?>
<div class="etn-accordion-wrap etn-event-single-content-wrap">
    <h3 class="etn-faq-heading"><?php 
    $event_faq_title = apply_filters( 'etn_event_faq_title', esc_html__( "frequently asked questions", "eventin-pro" ));
    echo esc_html( $event_faq_title ); ?></h3>
    <?php
        if ( is_array( $etn_faqs ) && !empty( $etn_faqs ) ) {
            foreach ( $etn_faqs as $key => $faq ) {
                $acc_class = ( $key == 0 ) ? 'active' : '';
                ?>
                <div class="etn-content-item">
                    <h4 class="etn-accordion-heading <?php echo esc_attr( $acc_class ); ?>">
                        <?php echo esc_html( $faq["etn_faq_title"] ); ?>
                        <i class="fa fa-plus"></i>
                    </h4>
                    <p class="etn-acccordion-contents <?php echo esc_attr( $acc_class ); ?>">
                        <?php echo esc_html( $faq["etn_faq_content"] ); ?>
                    </p>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="etn-event-faq-body">
                <?php echo esc_html__( "No FAQ found!", "eventin-pro" ); ?>
            </div>
            <?php
        }
    ?>
</div>

<?php return; ?>