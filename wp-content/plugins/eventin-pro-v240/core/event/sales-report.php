<?php
namespace Etn_Pro\Core\Event;
use Etn_Pro\Utils\Helper;

defined('ABSPATH') || exit;

if ( ! class_exists( 'WP_List_Table' )){
    require_once ABSPATH . 'wp-admin/inclueds/class-wp-list-table.php';
}

class Sales_Report extends \WP_List_Table{

    public $singular_name;
    public $plural_name;
    public $id = '';
    
    /**
     * Show list
     */
    function __construct($all_data_of_table){

        $this->singular_name = $all_data_of_table['singular_name'];
        $this->plural_name   = $all_data_of_table['plural_name'];

        parent::__construct( [
            'singular' => $this->singular_name ,
            'plural'   => $this->plural_name ,
            'ajax'     => true ,
        ]);
    }
    
    /**
     * Get column header function
     */
    public function get_columns(){

        return [
            'cb'                => '<input type="checkbox" />',
            'title'             => esc_html__( 'Event name' ,  'eventin-pro'  ),
            'available_ticket'  => esc_html__( 'Total ticket' ,  'eventin-pro'  ),
            'sold_ticket'       => esc_html__( 'Total tickets sold' ,  'eventin-pro'  ),
            'remaining_ticket'  => esc_html__( 'Remaining ticket' ,  'eventin-pro'  ),
            'sale_price'        => esc_html__( 'Total price sold' ,  'eventin-pro'  ),
        ];
    }

    /**
     * Display all row function
     */
    protected function column_default( $item , $column_name ){
        $symbol = '';
        if ( class_exists('Wocommerce') ) {
            $symbol = get_woocommerce_currency_symbol();
        }
        switch( $column_name ) { 
            case $column_name:
                if ( $column_name =='sale_price' ) {
                    echo esc_html( $symbol . $item[ $column_name ] );
                }
                else {
                    return $item[ $column_name ];
                }
            default:
                isset( $item[ $column_name ] ) ? $item[ $column_name ]: '';
            break;
          }
    }

    /**
     * Show checkbox function
     */
    protected function column_cb( $item ){
        return sprintf(
            '<input type="checkbox" name="event_id[]" value="">', esc_url(admin_url('#', $item['event_id'] ))
       );
    }

    /**
     * Show checkbox function
     */
    public function column_title( $item ){
        $url = admin_url('admin.php?page=etn_sales_report&event_id=' . $item['event_id'] );
        return sprintf('<a href='.esc_url( $url ).'>'.$item['title'] .'</a>');
    }

    /**
     * Sortable column function
     */
    public function get_sortable_columns() {
        $sortable_columns = array(
          'title'        => array('title',true),
        );

        return $sortable_columns;
    }
    /**
     * Event filter block
     *
     */
    public function event_filter(){
        // select event
        $query = array(
            'post_type'      => 'etn',
            'post_status'    => 'publish',
            'posts_per_page' => -1
        );
        $get_all_posts = get_posts( $query );
        if ( count($get_all_posts)>0 ) {
            ?>
            <select name="event_name" >
                <option value=""><?php echo esc_html__( 'Select event',  'eventin-pro'  )?></option>
            <?php
            foreach ($get_all_posts as $key => $value) {
                ?>
                <option value="<?php echo esc_html( get_the_title( $value->ID ) );?>"
                <?php echo selected( get_the_title( $value->ID ) , $this->get_event_name_filter() , true )?>
                >
                <?php echo esc_html__( get_the_title( $value->ID ) ,  'eventin-pro'  )?></option>
                <?php
            }
            ?>
            </select>
            <?php
        }                    
        // select category
        $etn_cat = Helper::get_custom_texonomy( 'etn_category' );
        if ( count($etn_cat)>0 ) {
            ?>
            <select name="etn_cat">
                <option value=""><?php echo esc_html__( 'Select category',  'eventin-pro'  )?></option>
            <?php
            foreach ($etn_cat as $key => $value) {
                ?>
                <option value="<?php echo esc_html( $value->name )?>"
                    <?php echo selected( $value->name , $this->get_event_cat_name_filter() , true )?>
                >
                <?php echo esc_html__( $value->name,  'eventin-pro'  )?></option>
                <?php
            }
            ?>
            </select>
            <?php
        }
        // select tag
        $etn_tag = Helper::get_custom_texonomy( 'etn_tags' );
        if ( count($etn_tag)>0 ) {
            ?>
            <select name="etn_tag" >
                <option value=""><?php echo esc_html__( 'Select tag',  'eventin-pro'  )?></option>
            <?php
            foreach ($etn_tag as $key => $value) {
                ?>
                <option value="<?php echo esc_html( $value->name )?>"
                <?php echo selected( $value->name , $this->get_event_tag_name_filter() , true )?>
                >
                <?php echo esc_html__( $value->name,  'eventin-pro'  )?></option>
                <?php
            }
            ?>
            </select>
            <?php
        }
    }

    /**
     * Get filter event name
     *
     */
	protected function get_filter_action() {
        return ( empty( $_POST['filter_action'] ) ) ? '' : sanitize_text_field( $_POST['filter_action'] );
    }

    /**
     * Get filter event name
     *
     */
	protected function get_event_name_filter() {
        return ( empty( $_POST['event_name'] ) ) ? '' : sanitize_text_field( $_POST['event_name'] );
    }

    /**
     * Get filter event name
     *
     */
	protected function get_event_cat_name_filter() {
        return ( empty( $_POST['etn_cat'] ) ) ? '' : sanitize_text_field( $_POST['etn_cat'] );
    }

    /**
     * Get filter event name
     *
     */
	protected function get_event_tag_name_filter() {
        return ( empty( $_POST['etn_tag'] ) ) ? '' : sanitize_text_field( $_POST['etn_tag'] );
    }

    /**
	 * Display extra filtering options.
	 */
	protected function extra_tablenav( $which ) {
		// Only display on the top of the table
		if ( 'top' != $which ) {
			return;
		}
		?>
		<div class="alignleft actions">
		<?php
		// Add a dange range filter
		$this->event_filter();
		submit_button( esc_html__( 'Filter', 'eventin-pro' ), 'button', 'filter_action', false, array( 'id' => 'post-query-submit' ) );
		?>
		</div>
		<?php
    }
    
    /**
     * Main query and show function
     */
    
    public function preparing_items(){
        $per_page = 5;
        $column   = $this->get_columns();
        $hidden   = [];
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = [ $column , $hidden , $sortable ];
        $current_page = $this->get_pagenum();
        $offset       = ( $current_page - 1 ) * $per_page;

        if ( isset( $_REQUEST['orderby']) && isset( $_REQUEST['order']) ){
            $args['orderby'] = sanitize_text_field( $_REQUEST['orderby'] );
            $args['order']   = sanitize_text_field( $_REQUEST['order'] );
        } 
        // search result
        $event_name = $this->get_event_name_filter();
        $cat_name   = $this->get_event_cat_name_filter();
        $tag_name   = $this->get_event_tag_name_filter();
        $filter_name= $this->get_filter_action();

        $args['filter_name']    = $filter_name;
        $args['event_name']     = $event_name;
        $args['taxonomy_cat']   = $cat_name;
        $args['taxonomy_tag']   = $tag_name;
        $args['limit']          = $per_page;
        $args['offset']         = $offset;
        $purchase_history   = \Etn_Pro\Core\Action::instance()->purchase_history( $args );

        $this->set_pagination_args( [
            'total_items'   => $purchase_history['count'],
            'per_page'      => $per_page,
        ] );
        $this->items =  $purchase_history['data'];
    }

}