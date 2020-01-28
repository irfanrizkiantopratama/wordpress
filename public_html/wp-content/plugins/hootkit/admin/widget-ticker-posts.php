<?php
/**
 * Ticker Posts Widget
 *
 * @package           Hootkit
 * @subpackage        Hootkit/admin
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Class HootKit_Ticker_Posts_Widget
 */
class HootKit_Ticker_Posts_Widget extends HootKit_WP_Widget {

	function __construct() {

		$settings['id'] = 'hootkit-ticker-posts';
		$settings['name'] = __( 'HootKit > Posts Ticker', 'hootkit' );
		$settings['widget_options'] = array(
			'description'	=> __( 'Animated horizontal scrolling posts', 'hootkit' ),
			// 'classname'		=> 'hoot-ticker-posts-widget', // CSS class applied to frontend widget container via 'before_widget' arg
		);
		$settings['control_options'] = array();
		$settings['form_options'] = array(
			//'name' => can be empty or false to hide the name
			'title' => array(
				'name'		=> __( 'Title (optional)', 'hootkit' ),
				'type'		=> 'text',
				'std'		=> __( 'Trending', 'hootkit' ),
			),
			'category' => array(
				'name'		=> __( 'Category (Optional)', 'hootkit' ),
				'desc'		=> __( 'Only include posts from these categories. Leave empty to display posts from all categories.', 'hootkit' ),
				'type'		=> 'multiselect',
				'options'	=> (array)Hoot_List::categories('category'),
			),
			'exccategory' => array(
				'name'		=> __( 'Exclude Category (Optional)', 'hootkit' ),
				'desc'		=> __( 'Exclude posts from these categories.', 'hootkit' ),
				'type'		=> 'multiselect',
				'options'	=> (array)Hoot_List::categories('category'),
			),
			'count' => array(
				'name'		=> __( 'Number of Posts to show', 'hootkit' ),
				'desc'		=> __( 'Default: 10', 'hootkit' ),
				'type'		=> 'text',
				'settings'	=> array( 'size' => 3, ),
				'sanitize'	=> 'absint',
			),
			'speed' => array(
				'name'		=> __( 'Ticker Speed', 'hootkit' ),
				'type'		=> 'smallselect',
				'std'		=> '5',
				'options'	=> array(
					'1'		=> __( '1 (Slowest)', 'hootkit' ),
					'2'		=> __( '2', 'hootkit' ),
					'3'		=> __( '3', 'hootkit' ),
					'4'		=> __( '4', 'hootkit' ),
					'5'		=> __( '5', 'hootkit' ),
					'6'		=> __( '6', 'hootkit' ),
					'7'		=> __( '7', 'hootkit' ),
					'8'		=> __( '8', 'hootkit' ),
					'9'		=> __( '9', 'hootkit' ),
					'10'	=> __( '10 (Fastest)', 'hootkit' ),
				),
			),
			'width' => array(
				'name'		=> __( 'Ticker Width (Optional)', 'hootkit' ),
				'desc'		=> __( '(in pixels) Leave empty for full width', 'hootkit' ),
				'type'		=> 'text',
				// 'std'		=> '350',
				'settings'	=> array( 'size' => 9, ),
				'sanitize'	=> 'absint',
			),
			'thumbheight' => array(
				'name'		=> __( 'Thumbnail height', 'hootkit' ),
				'desc'		=> __( 'Default: 30', 'hootkit' ),
				'type'		=> 'text',
				'settings'	=> array( 'size' => 9, ),
				'sanitize'	=> 'absint',
			),
			'background' => array(
				'name'		=> __( 'Background (optional)', 'hootkit' ),
				'desc'		=> __( 'Leave empty for no background.', 'hootkit' ),
				// 'std'		=> '#f1f1f1',
				'type'		=> 'color',
			),
			'fontcolor' => array(
				'name'		=> __( 'Font Color (optional)', 'hootkit' ),
				'desc'		=> __( 'Leave empty to use default font colors.', 'hootkit' ),
				// 'std'		=> '#333333',
				'type'		=> 'color',
			),
			'customcss' => array(
				'name'		=> __( 'Widget Options', 'hootkit' ),
				'type'		=> 'collapse',
				'fields'	=> array(
					'class' => array(
						'name'		=> __( 'Custom CSS Class', 'hootkit' ),
						'desc'		=> __( 'Give this widget a custom css classname', 'hootkit' ),
						'type'		=> 'text',
					),
					'mt' => array(
						'name'		=> __( 'Margin Top', 'hootkit' ),
						'desc'		=> __( '(in pixels) Leave empty to load default margins', 'hootkit' ),
						'type'		=> 'text',
						'settings'	=> array( 'size' => 3 ),
						'sanitize'	=> 'integer',
					),
					'mb' => array(
						'name'		=> __( 'Margin Bottom', 'hootkit' ),
						'desc'		=> __( '(in pixels) Leave empty to load default margins', 'hootkit' ),
						'type'		=> 'text',
						'settings'	=> array( 'size' => 3 ),
						'sanitize'	=> 'integer',
					),
				),
			),
		);

		$settings = apply_filters( 'hootkit_ticker_posts_widget_settings', $settings );

		parent::__construct( $settings['id'], $settings['name'], $settings['widget_options'], $settings['control_options'], $settings['form_options'] );

	}

	/**
	 * Display the widget content
	 */
	function display_widget( $instance, $before_title = '', $title = '', $after_title = '' ) {
		// Allow theme/child-themes to use their own template
		$widget_template = hoot_get_widget( 'ticker-posts', false );
		// Use Hootkit template if theme does not have one
		$widget_template = ( $widget_template ) ? $widget_template : hootkit()->dir . 'template/widget-ticker-posts.php';
		// Fire up the template
		extract( $instance, EXTR_SKIP );
		if ( is_string( $widget_template ) && file_exists( $widget_template ) ) include ( $widget_template );
	}

}

/**
 * Register Widget
 */
function hootkit_ticker_posts_widget_register(){
	register_widget( 'HootKit_Ticker_Posts_Widget' );
}
add_action( 'widgets_init', 'hootkit_ticker_posts_widget_register' );