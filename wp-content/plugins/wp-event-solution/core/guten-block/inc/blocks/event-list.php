<?php

use \Etn\Utils\Helper as Helper;

//register event block
function etn_register_event_list_block() {
    register_block_type(
        'etn/event-list',
        [
            // Enqueue blocks.style.build.css on both frontend & backend.
            'style'           => 'eventin-block-style-css',
            // Enqueue blocks.editor.build.css in the editor only.
            'editor_style'    => 'eventin-block-editor-style-css',
            // Enqueue blocks.build.js in the editor only.
            'editor_script'   => 'eventin-block-js',
            'render_callback' => 'etn_event_list_callback',
            'attributes'      => [
                'etn_event_style' => [
                    'type'    => 'string',
                    'default' => 'event-1',
                ],
                'etn_event_cat'   => [
                    'type'    => 'array',
                    'default' => []
                ],
                'etn_event_tag'   => [
                    'type'    => 'array',
                    'default' => []
                ],
                'etn_event_count' => [
                    'type'    => 'integer',
                    'default' => 20,
                ],

                'etn_desc_limit'  => [
                    'type'    => 'integer',
                    'default' => 20,
                ],
                'etn_event_col'   => [
                    'type'    => 'string',
                    'default' => '4',
                ],
                'order'           => [
                    'type'    => 'string',
                    'default' => 'DESC',
                ],
            ],
        ]
    );
}
add_action( 'init', 'etn_register_event_list_block' );

// event list block callback
function etn_event_list_callback( $settings ) {

    $style              = $settings["etn_event_style"];
    $event_cat          = $settings["etn_event_cat"];
    $event_tag          = $settings["etn_event_tag"];
    $event_count        = $settings["etn_event_count"];
    $etn_event_col      = $settings["etn_event_col"];
    $etn_desc_limit     = $settings["etn_desc_limit"];
    $order              = ( isset( $settings["order"] ) ? $settings["order"] : 'DESC' );
    $post_attributes    = ['title', 'ID', 'name', 'post_date'];
    $orderby            = !empty( $settings["orderby"] ) ? $settings["orderby"] : 'title';
    $orderby_meta       = in_array($orderby, $post_attributes) ? false : 'meta_value';

    ob_start();
    ?>
	<div class="guten-event-blocks">
		<?php
		if( file_exists( ETN_DIR . "/widgets/events/style/{$style}.php" ) ){
			include ETN_DIR . "/widgets/events/style/{$style}.php";
		}
    	?>
	</div>
	<?php

    return ob_get_clean();
}
