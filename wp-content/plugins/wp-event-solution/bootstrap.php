<?php

namespace Etn;

defined( 'ABSPATH' ) || exit;

include_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * Plugin final Class.
 * Handles dynamically loading classes only when needed. CheFck Elementor Plugin.
 *
 * @since 1.0.0
 */
final class Bootstrap {

    private static $instance;
    private $event;
    private $speaker;
    private $schedule;
    private $attendee;
    private $has_pro;

    /**
     * __construct function
     * @since 1.0.0
     */
    public function __construct() {
        // load autoload method
        Autoloader::run();
    }

    /**
     * Public function version.
     * set for plugin version
     *
     * @since 1.0.0
     */
    public function version() {
        return '2.3.9';
    }

    /**
     * Public function name.
     * set for plugin name
     *
     * @since 1.0.0
     */
    public function name() {
        return __( "WP Event Solution", "eventin" );
    }

    /**
     * Public function init.
     * call function for all
     *
     * @since 1.0.0
     */
    public function init() {
        
        
        $this->_action_create_table();

        include_once ABSPATH . 'wp-admin/includes/plugin.php';

        //handle woocommerce notice depending on settings
        $this->handle_woo_dependency();

        $this->has_pro = defined('ETN_PRO_FILES_LOADED');

        //handle buy-pro notice
        $this->handle_buy_pro_module();

        // check permission for manage user
        if ( current_user_can( 'manage_options' ) ) {
            add_action( 'admin_menu', [$this, 'register_admin_menu'] );
        }

        //register all styles and scripts
        add_action( 'admin_enqueue_scripts', [$this, 'js_css_admin'] );
        add_action( 'wp_enqueue_scripts', [$this, 'js_css_public'] );
        add_action( 'elementor/frontend/before_enqueue_scripts', [$this, 'elementor_js'] );
        
        // Initialize plugin settings module
        Core\Settings\Settings::instance()->init( $this->name(), $this->version() );

        // Initialize event module
        Core\Event\Hooks::instance()->init();

        // Initialize attendee module
        Core\Attendee\Hooks::instance()->init();
        Core\Attendee\Attendee_List::instance()->init();

        // Initialize schedule module
        Core\Schedule\Hooks::instance()->init();

        // Initialize speaker module
        Core\Speaker\Hooks::instance()->init();

        // Iinitialize event ticket registration module
        Core\Event\Registration::instance()->init();

        // Initialize attendee information-update module
        Core\Attendee\InfoUpdate::instance()->init();

        // Initialize woocommerce module
        Core\Woocommerce\Base::instance()->init();

        // initialize niche shortcode
        Core\Shortcodes\Hooks::instance()->init();

        // initialize zoom module
        Core\Zoom_Meeting\Hooks::instance()->init();

        // initialize elementor widget
        Widgets\Manifest::instance()->init();

        //make admin menu open if custom taxonomy is selected
        add_action( 'parent_file', [$this, 'keep_taxonomy_menu_open'] );

        // add minicart to header
        add_action('wp_head', [$this, 'etn_custom_inline_css']);

        load_plugin_textdomain('eventin', false, ETN_DIR . '/languages/');


           // register gutenberg blocks
           if( file_exists( ETN_DIR . '/core/guten-block/inc/init.php' )){
            include_once ETN_DIR . '/core/guten-block/inc/init.php';
        } 

    }


    /**
     * Handle woocommerce admin notice depending on settings
     *
     * @return void
     */
    public function handle_woo_dependency(){
        
        $eventin_global_settings = \Etn\Utils\Helper::get_settings();
        $sell_tickets            = !empty( $eventin_global_settings["sell_tickets"] ) ? true : false;

        if( $sell_tickets && !is_plugin_active( 'woocommerce/woocommerce.php' )){
            add_action( 'admin_head',[$this, 'admin_notice_wc_not_active'] );
            return;
        }
    }

    /**
     * Show buy-pro menu if pro plugin not active
     *
     * @return void
     */
    public function handle_buy_pro_module(){
        if ( !$this->has_pro ) {

            /**
            * Show WPMET banner (codename: jhanda)
            */
            \Wpmet\Libs\Banner::instance('eventin')
            // ->is_test(true)
            ->set_api_url('https://api.wpmet.com/public/jhanda')
            ->set_plugin_screens('edit-etn')
            ->set_plugin_screens('edit-etn-attendee')
            ->set_plugin_screens('edit-etn_category')
            ->set_plugin_screens('edit-etn_tags')
            ->set_plugin_screens('edit-etn-schedule')
            ->set_plugin_screens('edit-etn_speaker_category')
            ->set_plugin_screens('edit-etn-speaker')
            ->set_plugin_screens('eventin_page_etn-event-settings')
            ->set_plugin_screens('eventin_page_etn_sales_report')
            ->set_plugin_screens('edit-etn-zoom-meeting')
            ->set_plugin_screens('eventin_page_eventin_get_help')
            ->call();

        }
        
        //show get-help and upgrade-to-premium menu
        $this->handle_get_help_and_upgrade_menu();
    }

    /**
     * Show menu for get-help
     * Show menu for upgrade-te-premium if pro version not active
     *
     * @return void
     */
    public function handle_get_help_and_upgrade_menu(){

        /**
         * Show go Premium menu
         */
        \Wpmet\Libs\Pro_Awareness::instance('eventin')
        ->set_parent_menu_slug('etn-events-manager')
        ->set_plugin_file('wp-event-solution/eventin.php')
        ->set_pro_link( $this->has_pro ? "" : 'https://themewinter.com/eventin/' )
        ->set_default_grid_thumbnail( ETN_PATH . '/utils/pro-awareness/assets/support.png' )
        ->set_default_grid_link('http://support.themewinter.com/support-center/login')
        ->set_page_grid([
            'url' => 'https://www.facebook.com/groups/1319571704894531',
                'title' => 'Join the Community',
                'thumbnail' => ETN_PATH . '/utils/pro-awareness/assets/community.png',
        ])
        ->set_page_grid([
            'url' => 'https://www.youtube.com/channel/UCfdo_ujAqztsz4QnjkrrPlw',
                'title' => 'Video Tutorials',
                'thumbnail' => ETN_PATH . '/utils/pro-awareness/assets/video_tutorial.png',
        ])
        ->set_page_grid([
            'url' => 'https://themewinter.com/eventin-roadmaps/#ideas',
                'title' => 'Feature Request',
                'thumbnail' => ETN_PATH . '/utils/pro-awareness/assets/feature_request.png',
        ])
        ->set_page_grid([
            'url' => 'https://support.themewinter.com/docs/plugins/docs-category/eventin/',
            'title' => 'Documentation',
            'thumbnail' => ETN_PATH . '/utils/pro-awareness/assets/documentation.png',
        ])
        ->set_plugin_row_meta('Documentation','https://support.themewinter.com/docs/plugins/docs-category/eventin/', ['target'=>'_blank'])
        ->set_plugin_row_meta('Facebook Community','https://www.facebook.com/groups/wpmet', ['target'=>'_blank'])
        ->set_plugin_action_link('Settings', admin_url() . 'admin.php?page=etn-event-settings')
        ->set_plugin_action_link( ( $this->has_pro ? '' : 'Go Premium'),'https://themewinter.com/eventin/', ['target'=>'_blank', 'style' => 'color: #FCB214; font-weight: bold;'])
        ->call();
    }

        /**
     * Show notice if woocommerce not active
     */
    public function admin_notice_pro_not_active() {

        if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$btn = [
            'default_class' => 'button',
            'class' => 'button-primary '
        ];
        if ( file_exists( WP_PLUGIN_DIR . '/eventin-pro/eventin-pro.php' ) ) {
            $btn['text'] = esc_html__( 'Activate Eventin Pro', 'eventin' );
            $btn['url']   = wp_nonce_url( 'plugins.php?action=activate&plugin=eventin-pro/eventin-pro.php&plugin_status=all&paged=1', 'activate-plugin_eventin-pro/eventin-pro.php' );
        } else {
            $btn['text'] = esc_html__( 'Buy Eventin Pro', 'eventin' );
            $btn['url']   = esc_url( $this->get_pro_link() );
        }

		\Oxaim\Libs\Notice::instance('eventin', 'buy-eventin-pro')
		->set_class( 'error' )
        ->set_dismiss( 'global', ( 3600 * 24 * 30 ) )
		->set_message( sprintf( esc_html__( 'Get Eventin Pro for more exciting features.', 'eventin' ) ) )
		->set_button( $btn )
		->call();
    }

    /**
     * Undocumented function
     *
     * @param [type] $parent_file
     * @return void
     */
    public function keep_taxonomy_menu_open( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;
        $eligible_taxonomies = ['etn_category', 'etn_tags', 'etn_speaker_category'];

        if ( in_array($taxonomy, $eligible_taxonomies ) ) {
            $parent_file = 'etn-events-manager';
        }

        return $parent_file;
    }

    /**
     * Show notice if woocommerce not active
     */
    public function admin_notice_wc_not_active() {

        if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
		$btn = [
            'default_class' => 'button',
            'class' => 'button-primary '
        ];
        if ( file_exists( WP_PLUGIN_DIR . '/woocommerce/woocommerce.php' ) ) {
            $btn['text'] = esc_html__( 'Activate WooCommerce', 'eventin' );
            $btn['url']   = wp_nonce_url( 'plugins.php?action=activate&plugin=woocommerce/woocommerce.php&plugin_status=all&paged=1', 'activate-plugin_woocommerce/woocommerce.php' );
        } else {
            $btn['text'] = esc_html__( 'Install WooCommerce', 'eventin' );
            $btn['url']   = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
        }

		\Oxaim\Libs\Notice::instance('eventin', 'unsupported-woocommerce-version')
		->set_class('error')
        ->set_dismiss('global', (3600 * 24 * 30))
		->set_message(sprintf( esc_html__( 'Eventin requires WooCommerce to get all features, which is currently NOT RUNNING.', 'eventin' ) ) )
		->set_button($btn)
		->call();
    }

    /**
     * Public function package_type.
     * set for plugin package type
     *
     * @since 1.0.0
     */
    public function package_type() {
        return 'free';
    }
    
    public function text_domain() {
        return 'eventin';
    }

    /**
     * Public function js_css_public .
     * Include public function
     */
    public function js_css_public() {

        if ( is_rtl() ) {
            wp_enqueue_style( 'etn-rtl', ETN_ASSETS . 'css/rtl.css' );
        }

        wp_enqueue_style( 'etn-public-css', ETN_ASSETS . 'css/event-manager-public.css', [], $this->version(), 'all' );
        wp_enqueue_style( 'fontawesome', ETN_ASSETS . 'css/font-awesome.css', [], '5.0', 'all' );
        wp_enqueue_script( 'etn-public', ETN_ASSETS . 'js/event-manager-public.js', ['jquery'], $this->version(), true );
    }

    public function elementor_js() {
        wp_enqueue_script( 'etn-elementor-inputs', ETN_ASSETS . 'js/elementor.js', ['elementor-frontend'], $this->version(), true );
    }

    public function js_css_admin() {

        // get screen id
        $screen    = get_current_screen();
        $screen_id = $screen->id;

        $allowed_screen_ids = [
            'post',
            'page',
            'etn',
            'edit-etn',
            'etn-attendee',
            'edit-etn-attendee',
            'edit-etn_category',
            'edit-etn_tags',
            'etn-schedule',
            'edit-etn-schedule',
            'edit-etn_speaker_category',
            'etn-speaker',
            'edit-etn-speaker',
            'etn-zoom-meeting',
            'edit-etn-zoom-meeting',
            'eventin_page_etn-event-settings',
            'eventin_page_etn_sales_report',
            'eventin_page_eventin_get_help',
            'eventin_page_etn-license',
        ];

        if( in_array($screen_id, $allowed_screen_ids) ){

            $form_cpt = $this->event;

            if ( !wp_style_is( 'wp-color-picker', 'enqueued' ) ) {
                wp_enqueue_style( 'wp-color-picker' );
            }

            wp_enqueue_style( 'thickbox' );
            wp_enqueue_style( 'select2', ETN_ASSETS . 'css/select2.min.css', [], '4.0.10', 'all' );

            wp_enqueue_style( 'fontawesome', ETN_ASSETS . 'css/font-awesome.css', [], '5.0', 'all' );
            wp_enqueue_style( 'etn-ui', ETN_ASSETS . 'css/etn-ui.css', [], $this->version(), 'all' );
            wp_enqueue_style( 'etn-icon', ETN_ASSETS . 'css/etn-icon.css', [], $this->version(), 'all' );
            wp_enqueue_style( 'jquery-ui', ETN_ASSETS . 'css/jquery-ui.css', ['wp-color-picker'], $this->version(), 'all' );
            wp_enqueue_style( 'admin-datetime', ETN_ASSETS . 'css/jquery.datetimepicker.min.css', [], $this->version(), 'all' );
            wp_enqueue_style( 'event-manager-admin', ETN_ASSETS . 'css/event-manager-admin.css', [], $this->version(), 'all' );
            wp_enqueue_style( 'etn-common', ETN_ASSETS . 'css/event-manager-public.css', [], $this->version(), 'all' );

            if ( !did_action( 'wp_enqueue_media' ) ) {
                wp_enqueue_media();
            }

            // js
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_script( 'media-upload' );
            wp_enqueue_script( 'thickbox' );
            wp_enqueue_script( 'jquery-ui-datepicker' );

            wp_enqueue_script( 'jquery-ui', ETN_ASSETS . 'js/etn-ui.min.js', ['jquery'], '4.0.10', true );
            wp_enqueue_script( 'popper', ETN_ASSETS . 'js/Popper.js', ['jquery'], '4.0.10', false );
            wp_enqueue_script( 'etn', ETN_ASSETS . 'js/event-manager-admin.js', ['jquery'], $this->version(), false );
            wp_enqueue_script( 'select2', ETN_ASSETS . 'js/select2.min.js', ['jquery'], '4.0.10', false );
            wp_enqueue_script( 'jquery-repeater', ETN_ASSETS . 'js/jquery.repeater.min.js', ['jquery'], '4.0.10', true );
            wp_enqueue_script( 'admin-datetime', ETN_ASSETS . 'js/jquery.datetimepicker.full.min.js', ['jquery'], $this->version(), true );
            // locallize data
            $settings                                 = \Etn\Core\Settings\Settings::instance()->get_settings_option();
            $form_data                                = [];
            $form_data['ajax_url']                    = admin_url( 'admin-ajax.php' );
            $form_data['zoom_connection_check_nonce'] = wp_create_nonce( 'zoom_connection_check_nonce' );
            $form_data['zoom_module']                 = empty( $settings['etn_zoom_api'] ) ? "no" : "yes";
            $form_data['attendee_module']             = empty( $settings['attendee_registration'] ) ? "no" : "yes";
    
            wp_localize_script( 'etn', 'form_data', $form_data );
        }
    }

    function register_admin_menu() {
        $admin_page = new \Etn\Core\Event\Pages\Event_Admin_Page();
        $admin_page->add_admin_pages();
        $settings = Core\Settings\Settings::instance()->init( $this->name(), $this->version() );
    }

    public function flush_rewrites() {
        $event = new Core\Event\Cpt();
        $event->flush_rewrites();
        $speaker = new Core\Speaker\Cpt();
        $speaker->flush_rewrites();
        $schedule = new Core\Schedule\Cpt();
        $schedule->flush_rewrites();
        
        // flush cpt for attendee
        $attendee = new Core\Attendee\Cpt();
        $attendee->flush_rewrites();
    }

    public static function instance() {

        if ( !self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Create plugin specific tables to store data
     *
     * @return void
     */
    public function _action_create_table() {
        global $wpdb;
        $tableName       = $wpdb->prefix . 'etn_events';
        $charset_collate = $wpdb->get_charset_collate();
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        // create table for donation
        if ( $wpdb->get_var( "SHOW TABLES LIKE '$tableName'" ) != $tableName ) {

            // create fundraising table
            $wdp_sql = "CREATE TABLE IF NOT EXISTS `$tableName` (
			  `event_id` mediumint(9) NOT NULL AUTO_INCREMENT,
			  `post_id` bigint(20) NOT NULL COMMENT 'This id is teh event id',
			  `form_id` bigint(20) NOT NULL COMMENT 'This id From wp post table',
			  `invoice` varchar(150) NOT NULL,
			  `event_amount` double NOT NULL DEFAULT '0',
			  `user_id` mediumint(9) NOT NULL,
			  `email` varchar(200) NOT NULL,
			  `event_type` ENUM('ticket') DEFAULT 'ticket',
			  `payment_type` ENUM('woocommerce') DEFAULT 'woocommerce',
			  `pledge_id` varchar(20) NOT NULL DEFAULT '0',
			  `payment_gateway` ENUM('offline_payment', 'online_payment', 'bank_payment', 'check_payment', 'stripe_payment', 'other_payment') default 'online_payment',
			  `date_time` datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			  `status` ENUM('Active','Review', 'DeActive', 'Failed', 'Processing', 'Pending', 'Hold', 'Refunded', 'Delete', 'Completed', 'Cancelled') DEFAULT 'Pending',
			  PRIMARY KEY (`event_id`)
			) $charset_collate;";
            dbDelta( $wdp_sql );

            // create meta table
            $tableNameMeta = $wpdb->prefix . 'etn_trans_meta';

            $wdp_meta = "
				CREATE TABLE IF NOT EXISTS `$tableNameMeta`(
					`meta_id` mediumint NOT NULL AUTO_INCREMENT,
					`event_id` mediumint NOT NULL,
					`meta_key` varchar(255),
					`meta_value` longtext,
					PRIMARY KEY(`meta_id`)
				) $charset_collate;
			";
            dbDelta( $wdp_meta );

            update_option( 'etn_version', \Etn\Bootstrap::instance()->version() );
        }
        

        //run table column migration for older version than 2.3.3 
        if( version_compare(get_option( 'etn_version'), '2.3.3', '<' )){

            $migration_query = "ALTER TABLE `$tableName` MODIFY COLUMN `status` ENUM('Failed', 'Processing', 'Pending', 'Hold', 'Refunded', 'Completed', 'Cancelled') DEFAULT 'Pending';";

            $wpdb->query( $migration_query );
        }

    }

    /**
     * Custom inline css
     */
    public function etn_custom_inline_css(){
      $settings =  \Etn\Core\Settings\Settings::instance()->get_settings_option();
      $etn_custom_css = '';
      $primary_color = "#5D78FF";
      $secondary_color = "";

        // cart bg color
        if( !empty( $settings['etn_primary_color'] ) ){
        $primary_color =  $settings['etn_primary_color'] ;
        } 

        // cart icon color
        if( !empty( $settings['etn_secondary_color'] ) ){
        $secondary_color = $settings['etn_secondary_color'] ;
        }

      $etn_custom_css.="
        .etn-event-single-content-wrap .etn-event-meta .etn-event-category span,
        .etn-event-item .etn-event-footer .etn-atend-btn .etn-btn-border,
        .etn-btn.etn-btn-border, .attr-btn-primary.etn-btn-border, 
        .etn-attendee-form .etn-btn.etn-btn-border, 
        .etn-ticket-widget .etn-btn.etn-btn-border,
        .etn-settings-dashboard .button-primary.etn-btn-border,
        .etn-single-speaker-item .etn-speaker-content a:hover,
        .etn-event-style2 .etn-event-date,
        .etn-event-style3 .etn-event-content .etn-title a:hover,
        .etn-event-item:hover .etn-title a{
            color: {$primary_color}; 
        }
        .etn-event-item .etn-event-category span,
        .etn-btn, .attr-btn-primary, 
        .etn-attendee-form .etn-btn, 
        .etn-ticket-widget .etn-btn,
        .schedule-list-1 .schedule-header,
        .speaker-style4 .etn-speaker-content .etn-title a,
        .etn-speaker-details3 .speaker-title-info,
        .etn-event-slider .swiper-pagination-bullet, .etn-speaker-slider .swiper-pagination-bullet,
        .etn-event-slider .swiper-button-next, .etn-event-slider .swiper-button-prev,
         .etn-speaker-slider .swiper-button-next, .etn-speaker-slider .swiper-button-prev,
        .etn-single-speaker-item .etn-speaker-thumb .etn-speakers-social a,
        .etn-event-header .etn-event-countdown-wrap .etn-count-item, 
        .schedule-tab-1 .etn-nav li a.etn-active,
        .etn-settings-dashboard .button-primary{
            background-color: {$primary_color}; 
        }

        .etn-event-item .etn-event-footer .etn-atend-btn .etn-btn-border,
        .etn-btn.etn-btn-border, .attr-btn-primary.etn-btn-border,
        .etn-attendee-form .etn-btn.etn-btn-border,
        .etn-ticket-widget .etn-btn.etn-btn-border,
        .etn-settings-dashboard .button-primary.etn-btn-border{
            border-color: {$primary_color}; 
        }
        .schedule-tab-wrapper .etn-nav li a.etn-active{
            border-bottom-color: {$primary_color}; 
        }
        .schedule-tab-wrapper .etn-nav li a:after,
        .schedule-tab-1 .etn-nav li a.etn-active:after{
            border-color: {$primary_color} transparent transparent transparent;
        }
        
        .etn-event-item .etn-event-location,
        .etn-event-tag-list a:hover,
        .etn-schedule-wrap .etn-schedule-info .etn-schedule-time{
            color: {$secondary_color}; 
        }
        .etn-event-tag-list a:hover{
            border-color: {$secondary_color}; 
        }
        .etn-btn:hover, .attr-btn-primary:hover,
        .etn-attendee-form .etn-btn:hover,
        .etn-ticket-widget .etn-btn:hover,
        .speaker-style4 .etn-speaker-content p,
        .etn-single-speaker-item .etn-speaker-thumb .etn-speakers-social a:hover,
        .etn-settings-dashboard .button-primary:hover{
            background-color: {$secondary_color}; 
        }";

      // add inline css
      wp_register_style('etn-custom-css', false);
      wp_enqueue_style('etn-custom-css');
      wp_add_inline_style('etn-custom-css', $etn_custom_css);
    }

    public function get_pro_link(){
        return 'https://themewinter.com/eventin/';
    }

    /**
     * migrate event price into woocommerce product price
     *
     * @return void
     */
    public function migrate_event_price(){
        $migration_done = !empty( get_option( "etn_event_price_migration_done" ) ) ? true : false;
        
        if( !$migration_done ){
            $all_events = \Etn\Utils\Helper::get_events();
            if( is_array($all_events) && !empty($all_events) ){
                foreach( $all_events as $event_id => $event_title ){
                    $event_price = get_post_meta( $event_id, "etn_ticket_price", true );
                    update_post_meta( $event_id, "_price", $event_price );
                    update_post_meta( $event_id, "_regular_price", $event_price );
                    update_post_meta( $event_id, "_sale_price", $event_price );
                }
            }

            update_option( "etn_event_price_migration_done", true );
        }
    }

}
