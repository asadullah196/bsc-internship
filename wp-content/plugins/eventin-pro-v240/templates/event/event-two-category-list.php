<?php

defined( 'ABSPATH' ) || exit;

?>
<div class="etn-event-meta">
    <?php
    $etn_cat_terms = wp_get_post_terms($single_event_id, 'etn_category');
    if ($etn_cat_terms) {
        $output = array();
        if( is_array( $etn_cat_terms ) ){
            foreach ($etn_cat_terms as $term) {
                $term_link =  get_term_link($term->slug, 'etn_category');
                $output[] = '<a class="etn-event-single-category-list" href="' . $term_link . '">' . $term->name . '</a>';
            }
        }
        echo "<span>" . wp_kses_post( join(' ', $output) ) . "</span>";
    }
    ?>
</div>