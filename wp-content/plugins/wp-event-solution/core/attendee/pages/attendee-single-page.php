<?php

namespace Etn\Core\Attendee\Pages;

defined( 'ABSPATH' ) || exit;

class Attendee_Single_Page {

    use \Etn\Traits\Singleton;

    function __construct() {
        add_action( 'archive_template', [$this, 'attendee_archive_template'] );
    }
    
    function attendee_archive_template( $template ) {

        if ( is_post_type_archive( 'etn-attendee' ) ) {
            if ( file_exists( ETN_DIR . '/core/attendee/views/single/attendee-archive-page.php' ) ) {
                return ETN_DIR . '/core/attendee/views/single/attendee-archive-page.php';
            }
        }

        return $template;
    }

}
