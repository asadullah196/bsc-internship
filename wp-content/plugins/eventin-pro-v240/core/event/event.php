<?php

namespace Etn_Pro\Core\Event;
use Etn_Pro\Utils\Helper;
use Etn\Core\Settings\Settings as SettingsFree;

defined('ABSPATH') || exit;

class Event{

    use \Etn\Traits\Singleton;

    /**
     * Call hooks
     */
    public function init(){
        //Add column
        add_filter('manage_etn_posts_columns', [$this, 'attende_header_column']);

        // Add the data to the custom columns for the etn post type:
        add_action('manage_etn_posts_custom_column', [$this, 'custom_attende_column'], 10, 2);

        // filter query for past/present/upcoming
        add_action('restrict_manage_posts', [$this, 'event_type_filter']);

        add_filter('parse_query', [$this, 'event_filter_request_query']);
        
        // add email remainder 
        \Etn_Pro\Core\Event\Cron::instance()->init();
        
        // check permission for manage user
        if (current_user_can('manage_options')) {

            add_action('admin_menu', [$this, 'admin_attendee_menu']);
            
        }
        //  remove date column
        add_action( 'admin_init' , [$this,'remove_column_init'] );

        $this->initialize_template_hooks();
    }
    

    public function initialize_template_hooks(){
        include_once ETN_PRO_DIR . '/core/event/template-hooks.php';
        include_once ETN_PRO_DIR . '/core/event/template-functions.php';
    }

    /**
     * Fire hook for removing column
     */
    public function remove_column_init() {
        add_filter( 'manage_etn_posts_columns' , [$this,'remove_comments_column'] );
    }

    /**
     * Remove date column
     */
    public function remove_comments_column( $columns ) {
        unset($columns['date']);

        return $columns;
    }

    /**
     * Header of column
     */
    public function attende_header_column($columns){
        $columns['attendee'] = esc_html__('Report',  'eventin-pro' );
        $columns['status']   = esc_html__('Status',  'eventin-pro' );
        $columns['seats']    = esc_html__('Booked Seats',  'eventin-pro' );
        $columns['etn_start_date'] = esc_html__('Start date',  'eventin-pro' );
        return $columns;
    }

    /**
     * Render columns
     */
    public function custom_attende_column($column, $post_id){
        switch ($column) {
            case 'attendee':
                $url = admin_url('admin.php?page=etn_sales_report&event_id=' . $post_id);
                ?>
                <a href="<?php echo esc_url($url); ?>"><?php echo esc_html__('Purchase report',  'eventin-pro' ) ?></a>
                <?php
                break;
            case 'seats':
                $total_ticket_count      = $this->get_event_total_ticket_count($post_id);
                $total_sold_ticket_count = $this->get_event_sold_ticket_count($post_id);
                echo esc_html($total_sold_ticket_count . " / " . $total_ticket_count);
                break;
            case 'status':
                $current_status = $this->get_event_status($post_id);
                echo esc_html($current_status);
                break;
            case 'etn_start_date':
                echo esc_html( get_post_meta($post_id,'etn_start_date',true).' '.get_post_meta($post_id,'etn_start_time',true) );
                break;
        }
    }

    /**
     * Create attende list page function
     */
    public function admin_attendee_menu(){
        if (current_user_can('editor') || current_user_can('administrator')) {

            add_submenu_page(
                'etn-events-manager',
                __( 'Purchase report' , 'eventin-pro' ),
                __( 'Purchase report' , 'eventin-pro' ),
                'read',
                'etn_sales_report',
                [$this, 'sales_report'],
                10
            );
        }
    }

    /**
     * Show purchase report function
     *
     * @return void
     */
    public function sales_report(){
        $id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;
        if (isset($_GET['event_id']) && intval($id) !== 0) {
            $count_attendee = \Etn_Pro\Core\Action::instance()->total_attendee($id);
            if ((int) $count_attendee > 0) {
                ?>
                <p>
                    <a href="<?php echo admin_url('admin.php?page=etn_sales_report') ?>&action=etn_pro_download_report_attendee&attendee_event_id=<?php echo esc_attr($id); ?>&_wpnonce=<?php echo wp_create_nonce('etn_pro_download_report_attendee') ?>" class="etn-btn etn-btn-primary button-large">
                        <?php echo esc_html__('Export to CSV', 'eventin-pro'); ?>
                    </a>
                </p>
                <?php
            }
            $event_name            = get_the_title($id);
            $etn_pro_attendee_list = array(
                'singular_name' => esc_html__('Purchase list', 'eventin-pro'),
                'plural_name'   => esc_html__('Purchase lists', 'eventin-pro'),
                'event_id'      => $id,
            );
            ?>
            <h1 class="wp-heading-inline"><?php echo esc_html__('Purchase report of ' . $event_name . '',  'eventin-pro' ) ?></h1>
            <div class="wrap etn-atendee-list-report">
                <form method="POST">
                    <?php
                    $table = new \Etn_Pro\Core\Event\Attendee_List($etn_pro_attendee_list);
                    $table->preparing_items();
                    $table->display();
                    ?>
                </form>
            </div>
            <?php
        } elseif (isset($_GET['action']) && sanitize_text_field($_GET['action']) == 'etn_pro_download_report_attendee') {
            // Add action hook only if action=etn_pro_download_report_attendee
            $etn_pro_event_id  = intval($_GET['attendee_event_id']);
            \Etn_Pro\Core\Action::instance()->csv_export_attendee_report($etn_pro_event_id);
        } else {
            $purchase_summary = \Etn_Pro\Core\Action::instance()->purchase_summary();
            if ( count( $purchase_summary )>0 ) {
            ?>
            <!-- event sales report header -->
            <div class="event-sales-report-head">
                <div class="attr-row">
                    <div class="attr-col-md-4">
                        <div class="sales-report-head-item">
                            <div class="sales-report-icon">
                                <img src="<?php echo esc_url(ETN_PRO_ASSETS . 'images/icon1.png'); ?>" alt="<?php echo esc_attr__('report settings icon', 'eventin-pro'); ?>">
                            </div>
                            <h4 class="sales-info">
                                <?php echo esc_html__('Total Events', 'eventin-pro'); ?>
                                <span class="total-count"><?php echo esc_html( $purchase_summary['events'] ) ?></span>
                            </h4>
                        </div>
                    </div>
                    <div class="attr-col-md-4">
                        <div class="sales-report-head-item report-head2">
                            <div class="sales-report-icon">
                                <img src="<?php echo esc_url(ETN_PRO_ASSETS . 'images/icon2.png'); ?>" alt="<?php echo esc_attr__('report settings icon', 'eventin-pro'); ?>">
                            </div>
                            <h4 class="sales-info">
                                <?php echo esc_html__('Total sold tickets', 'eventin-pro'); ?>
                                <span class="total-count"><?php echo esc_html( $purchase_summary['sale_tickets'] ) ?></span>
                            </h4>
                        </div>
                    </div>
                    <div class="attr-col-md-4">
                        <div class="sales-report-head-item report-head3">
                            <div class="sales-report-icon">
                                <img src="<?php echo esc_url(ETN_PRO_ASSETS . 'images/icon3.png'); ?>" alt="<?php echo esc_attr__('report settings icon', 'eventin-pro'); ?>">
                            </div>
                            <h4 class="sales-info">
                                <?php echo esc_html__('Total sold price', 'eventin-pro'); ?>
                                <span class="total-count"><?php echo esc_html( $purchase_summary['sale_price'] ) ?></span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>        
            <div class="wrap etn-sales-report">
                <h3><?php echo esc_html__('Purchase history',   'eventin-pro' ); ?></h3>
                <form method="POST">
                    <?php
                    $sales_reports = array(
                        'singular_name' => esc_html__('Sales Report','eventin-pro' ),
                        'plural_name'   => esc_html__('Sales Reports','eventin-pro' ),
                        'name'          => 'etn_category',
                    );
                    $table = new \Etn_Pro\Core\Event\Sales_Report( $sales_reports );
                    $table->preparing_items();
                    $table->display();
                    ?>
                </form>
            </div>
            <?php
        }
    }

    /**
     * Returns event totaL sold ticket count
     */
    public function get_event_sold_ticket_count($post_id){
        $ticket_qty        = get_post_meta($post_id, "etn_sold_tickets", true);
        $total_sold_ticket = isset($ticket_qty) && is_numeric($ticket_qty) ? intval($ticket_qty) : 0;

        return $total_sold_ticket;
    }

    /**
     * Returns event total ticket
     */
    public function get_event_total_ticket_count($post_id){
        $ticket_qty        = get_post_meta($post_id, "etn_avaiilable_tickets", true);
        $total_ticket      = isset($ticket_qty) && is_numeric($ticket_qty) ? intval($ticket_qty) : 0;

        return $total_ticket;
    }


    /**
     * Returns event current status. Upcoming / Ongoing / Expired
     *
     */
    public function get_event_status($post_id){
        $selected_expiry_point  = Helper::get_expiry_date();
        $event_expire_date_time = "";
        $event_status = "";

        if ($selected_expiry_point == "start") {
            //event start date-time
            $event_expire_date = !empty(get_post_meta($post_id, "etn_start_date", true)) && !is_null(get_post_meta($post_id, "etn_start_date", true)) ? get_post_meta($post_id, "etn_start_date", true) : "";
            $event_expire_time = !empty(get_post_meta($post_id, "etn_start_time", true)) && !is_null(get_post_meta($post_id, "etn_start_time", true)) ? get_post_meta($post_id, "etn_start_time", true) : "";
            $event_expire_date_time = trim($event_expire_date . " " . $event_expire_time);
        } elseif ($selected_expiry_point == "end") {
            //event end date-time
            $event_expire_date = !empty(get_post_meta($post_id, "etn_end_date", true)) && !is_null(get_post_meta($post_id, "etn_end_date", true)) ? get_post_meta($post_id, "etn_end_date", true) : "";
            $event_expire_time = !empty(get_post_meta($post_id, "etn_end_time", true)) && !is_null(get_post_meta($post_id, "etn_end_time", true)) ? get_post_meta($post_id, "etn_end_time", true) : "";
            $event_expire_date_time = trim($event_expire_date . " " . $event_expire_time);
        }

        if ("" == $event_expire_date_time) {
            return esc_html__("Time undefined", "eventin-pro");
        }

        $current_time_string = time();
        $event_expire_date_time_string = strtotime($event_expire_date_time);
        $time_difference = $current_time_string - $event_expire_date_time_string;
        // $time_difference_day = abs( round( $time_difference / (60 * 60 * 24) ) );
        // $time_difference_hours = abs( round( ( $time_difference - ( $time_difference_day * 60 * 60 * 24 ) ) / ( 60 * 60 ) ) );

        if ($time_difference < 0) {
            $event_status = esc_html__("Upcoming: ","eventin-pro") . $this->seconds_to_human(abs($time_difference));
        } elseif ($time_difference > 0) {
            $event_status = esc_html__("Expired","eventin-pro");
        } else {
            $event_status = esc_html__("Ongoing","eventin-pro");
        }

        return $event_status;
    }

    /**
     * Takes seconds and returns human readable time
     */
    public function seconds_to_human($seconds){
        // $s = $seconds % 60;
        // $m = floor( ( $seconds % 3600 ) / 60);
        $h = floor(($seconds % 86400) / 3600);
        $d = floor(($seconds % 2592000) / 86400);
        $M = floor($seconds / 2592000);

        return "$M months, $d days, $h hours";
    }

    /**
     * Event wise filtering function
     *
     */
    public function event_type_filter(){
        global $typenow;
        if ($typenow == 'etn') {
            $filter_option = array('Past', 'Ongoing', 'Upcoming');
            $selected = '';
            if ((isset($_GET['event_type']))  && isset($_GET['post_type'])
                && !empty(sanitize_text_field($_GET['event_type'])) &&  sanitize_text_field($_GET['post_type']) == 'etn'
            ) {
                $selected = sanitize_text_field($_GET['event_type']);
            }
            ?>
            <select name="event_type">
                <?php
                foreach ($filter_option as $value) :
                    $select = ($value == $selected) ? ' selected="selected"' : '';
                    ?>
                    <option value="<?php echo esc_html( $value ); ?>" <?php echo esc_html($select) ?>><?php echo esc_html__($value, 'eventin-pro'); ?></option>
                    <?php
                endforeach;
                ?>
            </select>
            <?php
        }
    }

    /**
     * Result of query
     */
    public function event_filter_request_query($query){
        if (!(is_admin()) && $query->is_main_query()) {
            return $query;
        }
        $search_value = isset($_GET['event_type']) ? sanitize_text_field($_GET['event_type']) : null;
        if (!isset($query->query['post_type']) || ('etn' !== $query->query['post_type']) || !isset($search_value) ) {
            return $query;
        }

        $selected_expiry_point  = Helper::get_expiry_date();
        $key = '';
        if ($selected_expiry_point == '' || $selected_expiry_point == 'start') {
            $key = 'etn_start_date';
        } else {
            $key = 'etn_end_date';
        }
        if ($key != '') {
            // compare sign
            switch ($search_value) {
                case 'Past':
                    $compare_sign = '<';
                    break;
                case 'Ongoing':
                    $compare_sign = '=';
                    break;
                case 'Upcoming':
                    $compare_sign = '>';
                    break;
                default:
                    $compare_sign = '';
                    break;
            }

            if (!isset($query->query_vars['meta_query'])) {
                $query->query_vars['meta_query'] = array();
            }
            // setup this functions meta values
            $meta = array(
                'key'       =>   $key,
                'value'     =>   date('Y-m-d'),
                'compare'   => $compare_sign,
                'type'      => 'DATE'
            );
            // append to meta_query array
            $query->query_vars['meta_query'][] = $meta;
        }
        return $query;
    }

}
