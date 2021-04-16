<?php
defined( 'ABSPATH' ) || exit;
?>

<?php do_action( 'etn_before_event_archive_container' ); ?>

<div class="etn-event-archive-wrap">
    <div class="etn-container">
        <div class="etn-row etn-event-wrapper">

            <?php do_action( 'etn_before_event_archive_item' ); ?>

            <?php
            if (have_posts()) {

                while (have_posts()) {
                    the_post();
                    ?>
                    <div class="etn-col-md-6 etn-col-lg-<?php echo esc_attr( apply_filters( 'etn_event_archive_column', '4' ) ); ?>">

                        <div class="etn-event-item">

                            <?php do_action( 'etn_before_event_archive_content', get_the_ID(  ) ); ?>

                            <!-- content start-->
                            <div class="etn-event-content">
                                
                                <?php do_action( 'etn_before_event_archive_title', get_the_ID(  ) ); ?>
                                
                                <h3 class="etn-title etn-event-title">
                                    <a href="<?php echo esc_url(get_the_permalink()) ?>">
                                        <?php echo esc_html(get_the_title()); ?>
                                    </a> 
                                </h3>
                                
                                <?php do_action( 'etn_after_event_archive_title', get_the_ID(  ) ); ?>
                            </div>
                            <!-- content end-->

                            <?php do_action( 'etn_after_event_archive_content', get_the_ID(  ) ); ?>

                        </div>
                        <!-- etn event item end-->
                    </div>
                    <?php
                }
            }
            ?>

            <?php do_action( 'etn_after_event_archive_item' ); ?>

        </div>
    </div>
</div>

<?php do_action( 'etn_after_event_archive_container' ); ?>