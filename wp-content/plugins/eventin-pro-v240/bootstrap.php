<?php
namespace Etn_Pro;

defined( 'ABSPATH' ) || exit;

use Etn_Pro\Core\Core;
use Etn_Pro\Core\Settings\Settings;
use Etn_Pro\Core\Woocommerce\Woocommerce_Deposit\Woocommerce_Deposit;
use Etn_Pro\Utils\Plugin_Installer;

final class Bootstrap {

    private static $instance;

    private $entries;
    private $forms;
    private $failed;

    public function __construct() {
        Autoloader::run();
    }

    public function version() {
        return '2.4.0';
    }

    public function package_type() {
        return 'pro';
    }

    public function product_id() {
        return '1013';
    }

    public function store_url() {
        return 'https://themewinter.com';
    }

    public function marketplace() {
        return 'themewinter';
    }

    public function author_name() {
        return 'themewinter';
    }

    public function account_url() {
        return 'https://account.themewinter.com';
    }

    public function api_url() {
        return 'https://api.themewinter.com/public/';
    }

    public static function instance() {

        if ( !self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Main function
     *
     * @return void
     */
    public function init() {
        //make eventin free ready
        $this->prepare_eventin();

        // check if eventin installed and activated
        if ( !did_action( 'eventin/after_load' ) ) {
            add_action( 'admin_notices', [$this, 'missing_eventin'] );
            $this->failed = true;
        }

        if ( $this->failed == true ) {
            return;
        }

        //initialize license if only multisite is enabled and current site is main network site
        if ( (!is_multisite()) || (is_multisite() && is_main_network() && is_main_site() && defined( 'MULTISITE' )) ) {
            $this->initialize_license_module();
        }

        include_once ABSPATH . 'wp-admin/includes/plugin.php';

        // fire up elementor widgets
        Widgets\Manifest::instance()->init();

        // fire up pro settings
        Settings::instance()->init();

        add_action( 'admin_enqueue_scripts', [$this, 'js_css_admin'] );
        add_action( 'wp_enqueue_scripts', [$this, 'js_css_public'] );
        add_action( 'elementor/frontend/before_enqueue_scripts', [$this, 'etn_elementor_js'] );

        // load plugin text domain
        load_plugin_textdomain( 'eventin-pro', false, ETN_PRO_DIR . '/languages/' );

        //fire-up all woocommerce related hooks
        if ( file_exists( ETN_PRO_DIR . '/core/woocommerce/hooks.php' ) ) {
            include_once ETN_PRO_DIR . '/core/woocommerce/hooks.php';
        }

        //  fire up all actions
        Core::instance()->init();

        if ( class_exists( 'WC_Deposits' ) ) {

            if ( file_exists( ETN_PRO_DIR . '/core/woocommerce/woocommerce-deposit/woo-deposit.php' ) ) {
                include_once ETN_PRO_DIR . '/core/woocommerce/woocommerce-deposit/woo-deposit.php';
            }

            Woocommerce_Deposit::instance()->init();
        }

        \Etn_Pro\Core\Attendee\Hooks::instance()->init();

    }

    public function initialize_license_module(){
        
        //add submenu for license
        add_action( "admin_menu", [$this, "add_submenu_for_license"], 99 );

        //handle license notice
        $this->manage_license_notice();

        //fire up edd update module
        Utils\Updater\Init::instance()->init();
    }

    /**
     * Add admin submenu page for license
     */
    public function add_submenu_for_license() {
        //add submenu page for go-pro
        add_submenu_page(
            'etn-events-manager',
            __( 'License', 'eventin-pro' ),
            __( 'License', 'eventin-pro' ),
            'manage_options',
            'etn-license',
            [$this, 'etn_license_page']
        );
    }

    public function etn_license_page() {
        $file_path = plugin_dir_path( __FILE__ ) . "/core/settings/views/license-settings-view.php";

        if ( file_exists( $file_path ) ) {
            include_once $file_path;
        }

    }

    public function manage_license_notice() {
        $license_settings = \Etn_Pro\Utils\Helper::get_option( "license" );
        $enable_license   = ( !empty( $license_settings ) ? true : false );

        // Register license module
        $license = \Etn_Pro\Utils\License\License::instance();

        //fire up edd license module
        $license->init();

        $settings              = get_option( "etn_premium_marketplace" );
        $selected_market_place = empty( $settings ) ? "" : $settings;

        if ( !$enable_license || $selected_market_place == "codecanyon" ) {
            return;
        }

        if ( $license->status() != 'valid' ) {
            \Oxaim\Libs\Notice::instance( 'eventin-pro', 'pro-not-active' )
                ->set_class( 'error' )
                ->set_dismiss( 'global', ( 3600 * 24 * 7 ) )
                ->set_message( esc_html__( 'Please activate Eventin Pro to get automatic updates and premium support.', 'eventin-pro' ) )
                ->set_button( [
                    'url'   => self_admin_url( 'admin.php?page=etn-license' ),
                    'text'  => 'Activate License Now',
                    'class' => 'button-primary',
                ] )
                ->call();
        }

    }

    /**
     * Prepare wp-cafe free version if not activated
     *
     * @return void
     */
    private function prepare_eventin() {

        // if eventin not installed
        if ( !did_action( 'eventin/after_load' ) ) {

            if ( Plugin_Installer::instance()->make_eventin_ready() ) {
                // redirect to plugin dashboard
                wp_safe_redirect( "admin.php?page=etn-event-settings" );
            }

        }

    }

    /**
     * Push notice if eventin free is missing
     *
     * @return void
     */
    public function missing_eventin() {

        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }

        if ( file_exists( WP_PLUGIN_DIR . '/eventin/eventin.php' ) ) {
            $btn['label'] = esc_html__( 'Activate Eventin', 'eventin-pro' );
            $btn['url']   = wp_nonce_url( 'plugins.php?action=activate&plugin=eventin/eventin.php&plugin_status=all&paged=1', 'activate-plugin_eventin/eventin.php' );
        } else {
            $btn['label'] = esc_html__( 'Install Eventin', 'eventin-pro' );
            $btn['url']   = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=eventin' ), 'install-plugin_eventin' );
        }

        Utils\Notice::push(
            [
                'id'          => 'unsupported-eventin-version',
                'type'        => 'error',
                'dismissible' => true,
                'btn'         => $btn,
                'message'     => sprintf( esc_html__( 'Eventin Pro required Eventin, which is currently NOT RUNNING. ', 'eventin-pro' ) ),
            ]
        );
    }

    public function js_css_public() {

        wp_enqueue_style( 'swiper-bundle-min', ETN_PRO_ASSETS . 'css/swiper-bundle.min.css', [], $this->version(), 'all' );
        wp_enqueue_style( 'jquery-countdown', ETN_PRO_ASSETS . 'css/jquery.countdown.css', [], $this->version(), 'all' );
        wp_enqueue_style( 'etn-public', ETN_PRO_ASSETS . 'css/etn-public.css', [], $this->version(), 'all' );

        if ( is_rtl() ) {
            wp_enqueue_style( 'etn-rtl-pro', ETN_PRO_ASSETS . 'css/rtl.css' );
        }

        wp_enqueue_script( 'pdfmake', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js', ['jquery'], $this->version(), true );
        wp_enqueue_script( 'html2canvas', 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js', ['jquery'], $this->version(), true );
        wp_enqueue_script( 'swiper-bundle-min', ETN_PRO_ASSETS . 'js/swiper-bundle.min.js', ['jquery'], $this->version(), false );
        wp_enqueue_script( 'jquery-countdown', ETN_PRO_ASSETS . 'js/jquery.countdown.min.js', ['jquery'], $this->version(), false );
        wp_enqueue_script( 'etn-public-pro', ETN_PRO_ASSETS . 'js/etn-public.js', ['jquery'], $this->version(), false );

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
            wp_enqueue_style( 'etn-admin', ETN_PRO_ASSETS . 'css/etn-admin.css', [], $this->version(), 'all' );
            wp_enqueue_script( 'etn-admin-pro', ETN_PRO_ASSETS . 'js/etn-admin.js', ['jquery', 'wp-color-picker'], $this->version(), false );

            // locallize data
            $license_settings = \Etn_Pro\Utils\Helper::get_option( "license" );
            $enable_license   = ( !empty( $license_settings ) ? "yes" : "no" );
            $array            = [
                'ajax_url'       => admin_url( 'admin-ajax.php' ),
                'license_module' => $enable_license,
            ];
            wp_localize_script( 'etn-admin-pro', 'admin_object', $array );
        }
    }

    public function etn_elementor_js() {
        wp_enqueue_script( 'etn-elementor-pro-inputs', ETN_PRO_ASSETS . 'js/elementor.js', ['elementor-frontend'], $this->version(), true );
    }

    /**
     * Define plugin constants
     *
     * @return void
     */
    public function define_constants() {

        // define constant
        define( "ETN_PRO_FILES_LOADED", true );
        define( 'ETN_PRO_PATH', plugin_dir_url( __FILE__ ) );
        define( 'ETN_PRO_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
        define( 'ETN_PRO_ASSETS', ETN_PRO_PATH . 'assets/' );
        define( 'ETN_PRO_CORE', ETN_PRO_PATH . 'core/' );
        define( 'ETN_PRO_PLUGIN_TEMPLATE_DIR', ETN_PRO_DIR . '/templates/' );

    }

}
