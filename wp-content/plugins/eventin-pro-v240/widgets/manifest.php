<?php
namespace Etn_Pro\Widgets;

use Etn_Pro\Utils\Helper;

defined( 'ABSPATH' ) || exit;

Class Manifest{
	use \Etn\Traits\Singleton;
	
	private $categories = ['event' => 'Eventin event'];

	/**
	 * Main function
	 *
	 * @return void
	 */
	public function init(){
		add_action('elementor/elements/categories_registered', [$this, 'add_elementor_widget_categories']);
		add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
	}

	/**
	 * Returns list of all available widgets
	 *
	 * @return void
	 */
	public function get_input_widgets(){
		return [
			'organizers',
			'speakers',
			'speakers-slider',
			'events-pro',
			'events-slider',
			'related-events',
			'event-ticket',
			'countdown-timer',
			'schedule-tab',
			'schedule-list',
			'attendee-list'
		];
	}

	/**
	 * Register all elementor widgets dynamically
	 */
	public function register_widgets(){

		$input_widgets = $this->get_input_widgets();

		if( is_array( $input_widgets ) && !empty( $input_widgets ) ){

			foreach ( $input_widgets as $v ) :
				$files = plugin_dir_path(__FILE__) . $v . '/' . $v . '.php';
				if (file_exists($files)) {
					require_once $files;
					$class_name = '\Elementor\Etn_Pro_' . Helper::make_classname( $v );
					\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new $class_name());
				}
			endforeach;
		}

	}

	/**
	 * Register elementor widget catefgories 
	 *
	 * @param [type] $elements_manager
	 * @return void
	 */
	public function add_elementor_widget_categories($elements_manager){
		
		$widget_categories = $this->categories;

		if( is_array( $widget_categories ) && !empty( $widget_categories ) ){

			foreach ( $widget_categories as $k => $v) {
				$elements_manager->add_category(
					'etn-pro-' . $k,
					[
						'title' => esc_html__($v, 'eventin-pro'),
						'icon' => 'fa fa-plug',
					]
				);
			}
		}
	}

}

