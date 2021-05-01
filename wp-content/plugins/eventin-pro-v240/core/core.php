<?php
namespace Etn_Pro\Core;

defined( 'ABSPATH' ) || exit;

use Etn_Pro\Core\Event\Event;
use Etn_Pro\Core\Metaboxs\Speaker_meta;
use Etn_Pro\Core\Metaboxs\Event_meta;
use Etn_Pro\Core\Event\Single_Page_View;
use Etn_Pro\Core\Shortcodes\Hooks;

class Core {
    
    use \Etn\Traits\Singleton;

    /**
     * Call all hooks
     *
     * @return void
     */
    public function init() {
        // call events cpt hook
        Event::instance()->init();

        // call shortcode hooks
        Hooks::instance()->init();

        // call speaker hooks
        Speaker_meta::instance()->init();

        // call event-metabox hooks
        Event_meta::instance()->init();

        //call event single-page view hook
        Single_Page_View::instance()->init();

        if ( file_exists(ETN_PRO_DIR ."/core/speaker/views/template-hooks.php") ) {
            include_once ETN_PRO_DIR ."/core/speaker/views/template-hooks.php";
        }

       if ( file_exists(ETN_PRO_DIR ."/core/speaker/views/template-functions.php") ) {
           include_once ETN_PRO_DIR ."/core/speaker/views/template-functions.php";
       }

    }
}