<?php
defined('ABSPATH') || exit;

$single_event_id = get_the_id();

if( ( ETN_DEMO_SITE === false ) || ( ETN_DEMO_SITE == true && ETN_EVENT_TEMPLATE_ONE_ID != get_the_ID(  ) && ETN_EVENT_TEMPLATE_TWO_ID != get_the_ID(  )) ){
    
    
?>

<?php do_action("etn_before_single_event_details", $single_event_id); ?>

<!-- body content area -->
<div class="etn-event-single-wrap etn-container etn-event-single2 etn-event-single3">
            
    <?php  do_action("etn_before_single_event_container", $single_event_id); ?>

    <!-- Row start -->
    <div class="etn-row">
        <div class="etn-col-lg-8">

            <?php do_action( "etn_before_single_event_content_wrap", $single_event_id ); ?>

            <!-- etn-content-wrap -->
            <div class="etn-content-wrap">
                <div class="etn-event-single-content-wrap no-shadow pb-0">

                    <?php do_action("etn_before_single_event_content_body", $single_event_id); ?>

                    <div class="etn-event-content-body">
                        <?php the_content(); ?>
                    </div>

                    <?php do_action("etn_after_single_event_content_body", $single_event_id); ?>

                </div>
            </div>
            <!-- etn-content-wrap -->

            <?php do_action( "etn_after_single_event_content_wrap", $single_event_id ); ?>

        </div><!-- col end -->

        <div class="etn-col-lg-4">
            <div class="etn-sidebar">
                
                <?php do_action("etn_before_single_event_meta", $single_event_id); ?>

                <!-- event schedule meta start -->
                <?php do_action("etn_single_event_meta", $single_event_id); ?> 
                <!-- event schedule meta end -->

                <?php do_action("etn_after_single_event_meta", $single_event_id); ?>
            </div>
            <!-- etn sidebar end -->
        </div>
        <!-- col end -->
    </div>
    <!-- Row end -->

    <?php  do_action("etn_after_single_event_container", $single_event_id); ?>

</div>

<?php do_action("etn_after_single_event_details", $single_event_id); ?>

<?php } ?>