<?php

use \Etn_Pro\Utils\Helper;

$data = Helper::post_data_query( 'etn-speaker' , $speaker_count, $speaker_order, $categories_id, 'etn_speaker_category', null, null, null, $orderby_meta, $orderby  );

if ( !empty( $data ) ) { ?>
    <div class='etn-row etn-speaker-wrapper speaker-style2'>
        <?php
        foreach( $data as $value ) {
            $speaker_designation = get_post_meta( $value->ID, 'etn_speaker_designation', true);
            $social = get_post_meta( $value->ID, 'etn_speaker_socials', true);
            ?>
            <div class="etn-col-lg-<?php echo esc_attr( $speaker_col ); ?> etn-col-md-6">
                <div class="etn-single-speaker-item">
                    <div class="etn-speaker-thumb">
                        <?php if ( esc_url( get_the_post_thumbnail_url( $value->ID ) ) ) { ?>
                            <a href="<?php echo esc_url( get_the_permalink( $value->ID ) ); ?>" class="etn-img-link">
                                <img src="<?php echo esc_url( get_the_post_thumbnail_url( $value->ID ) ); ?>" alt="<?php the_title_attribute($value->ID); ?>">
                            </a>
                        <?php } ?>
                    </div>
                    <!-- content -->
                    <div class="etn-speaker-content">
                        <h3 class="etn-title etn-speaker-title"><a href="<?php echo esc_url( get_the_permalink( $value->ID ) ); ?>"> <?php echo esc_html( get_the_title( $value->ID ) ); ?></a> </h3>
                        <?php if ($show_designation == 'yes') { ?>
                            <p>
                                <?php echo Helper::kses( $speaker_designation ); ?>
                            </p>
                        <?php } ?>
                        <!-- social -->
                        <?php if ($show_social == 'yes') { ?>
                            <div class="etn-speakers-social">
                                <?php if( is_array( $social ) && !empty( $social ) ) { ?>
                                    <?php foreach ($social as $social_value) {  ?>
                                        <a href="<?php echo esc_url($social_value["etn_social_url"]); ?>" title="<?php echo esc_attr($social_value["etn_social_title"]); ?>">
                                            <i class="<?php echo esc_attr($social_value["icon"]); ?>"></i>
                                        </a>
                                    <?php  } ?>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- speaker end -->
            </div>
            <!-- col end -->
        <?php } ?>
    </div>
<?php } ?>