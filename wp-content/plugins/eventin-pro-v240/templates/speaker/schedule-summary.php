<?php
defined( 'ABSPATH' ) || exit;

$etn_speaker_summary            = get_post_meta(get_the_id(), 'etn_speaker_summery', true);
if( !empty( $etn_speaker_summary ) ){
    ?>
    <div class="speaker-summery">
        <p class="etn-speaker-desc"> <?php echo \Etn_Pro\Utils\Helper::render($etn_speaker_summary); ?></p>
    </div>
    <?php
}