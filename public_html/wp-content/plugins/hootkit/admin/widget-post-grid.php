<?php
/**
 * Post Grid Widget
 *
 * @package           Hootkit
 * @subpackage        Hootkit/admin
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Class HootKit_Post_Grid_Widget
 */
class HootKit_Post_Grid_Widget extends HootKit_WP_Widget {

	function __construct() {

		$settings['id'] = 'hootkit-posts-grid';
		$settings['name'] = __( 'HootKit > Posts Grid', 'hootkit' );
		$settings['widget_options'] = array(
			'description'	=> __( 'Display Posts in a Grid', 'hootkit' ),
			// 'classname'		=> 'hoot-post-grid-widget', // CSS class applied to frontend widget container via 'before_widget' arg
		);
		$settings['control_options'] = array();
		$settings['form_options'] = array(
			//'name' => can be empty or false to hide the name
			'title' => array(
				'name'		=> __( 'Title (Optional)', 'hootkit' ),
				'type'		=> 'text',
			),
			'columns' => array(
				'name'		=> __( 'Number Of Columns', 'hootkit' ),
				'desc'		=> __( "First post takes up 2 columns by default. <br/> (You can change it to standard 1x1 size below in 'First Grid Post' options)", 'hootkit' ),
				'type'		=> 'smallselect',
				'std'		=> '4',
				'options'	=> array(
					// '1'	=> __( '1', 'hootkit' ),
					'2'	=> __( '2', 'hootkit' ),
					'3'	=> __( '3', 'hootkit' ),
					'4'	=> __( '4', 'hootkit' ),
					'5'	=> __( '5', 'hootkit' ),
				),
			),
			// 'rows' => array(
			// 	'name'		=> __( 'Number of Rows', 'hootkit' ),
			// 	'desc'		=> __( "Default: 2 Rows <br/> First post takes up 2 rows by default. <br/> (You can change it to standard 1x1 size below in 'First Grid Post' options)", 'hootkit' ),
			// 	'type'		=> 'text',
			// 	'std'		=> '2',
			// 	'settings'	=> array( 'size' => 3, ),
			// 	'sanitize'	=> 'absint',
			// ),
			'rows' => array(
				'name'		=> __( 'Number of Rows', 'hootkit' ),
				'desc'		=> __( "First post takes up 2 rows by default. <br/> (You can change it to standard 1x1 size below in 'First Grid Post' options)", 'hootkit' ),
				'type'		=> 'smallselect',
				'std'		=> '3',
				'options'	=> array(
					'1'	=> __( '1', 'hootkit' ),
					'2'	=> __( '2', 'hootkit' ),
					'3'	=> __( '3', 'hootkit' ),
					'4'	=> __( '4', 'hootkit' ),
					'5'	=> __( '5', 'hootkit' ),
					'6'	=> __( '6', 'hootkit' ),
					'7'	=> __( '7', 'hootkit' ),
					'8'	=> __( '8', 'hootkit' ),
					'9'	=> __( '9', 'hootkit' ),
					'10'=> __( '10', 'hootkit' ),
					'11'=> __( '11', 'hootkit' ),
					'12'=> __( '12', 'hootkit' ),
					'13'=> __( '13', 'hootkit' ),
					'14'=> __( '14', 'hootkit' ),
					'15'=> __( '15', 'hootkit' ),
					'16'=> __( '16', 'hootkit' ),
					'17'=> __( '17', 'hootkit' ),
					'18'=> __( '18', 'hootkit' ),
					'19'=> __( '19', 'hootkit' ),
					'20'=> __( '20', 'hootkit' ),
					'21'=> __( '21', 'hootkit' ),
					'22'=> __( '22', 'hootkit' ),
					'23'=> __( '23', 'hootkit' ),
					'24'=> __( '24', 'hootkit' ),
					'25'=> __( '25', 'hootkit' ),
				),
			),
			// 'count' => array(
			// 	'name'		=> __( 'Number of Posts (Grid Units) to show', 'hootkit' ),
			// 	'desc'		=> __( 'Default: 7 (Posts without a featured image are skipped)', 'hootkit' ),
			// 	'type'		=> 'text',
			// 	'settings'	=> array( 'size' => 3, ),
			// 	'sanitize'	=> 'absint',
			// ),
			'category' => array(
				'name'		=> __( 'Category (Optional)', 'hootkit' ),
				'desc'		=> __( 'Only include posts from these categories. Leave empty to display posts from ALL categories.', 'hootkit' ),
				'type'		=> 'multiselect',
				'options'	=> (array)Hoot_List::categories('category'),
			),
			'exccategory' => array(
				'name'		=> __( 'Exclude Category (Optional)', 'hootkit' ),
				'desc'		=> __( 'Exclude posts from these categories.', 'hootkit' ),
				'type'		=> 'multiselect',
				'options'	=> (array)Hoot_List::categories('category'),
			),
			'viewall' => array(
				'name'		=> __( "'View All Posts' link", 'hootkit' ),
				'desc'		=> __( 'Links to your Blog page. If you have a Category selected below, then this will link to the Category Archive page.', 'hootkit' ),
				'type'		=> 'select',
				'std'		=> 'none',
				'options'	=> array(
					'none'		=> __( 'Do not display', 'hootkit' ),
					'top'		=> __( 'Show at Top', 'hootkit' ),
					'bottom'	=> __( 'Show at Bottom', 'hootkit' ),
				),
			),
			'unitheight' => array(
				'name'		=> __( 'Grid Unit (Post Image) Size', 'hootkit' ),
				'desc'		=> __( 'Default: 215 (in pixels)', 'hootkit' ),
				'type'		=> 'text',
				'settings'	=> array( 'size' => 3, ),
				'sanitize'	=> 'absint',
			),
			'show_title' => array(
				'name'		=> __( 'Display Post Titles', 'hootkit' ),
				'type'		=> 'checkbox',
				'std'		=> 1,
			),
			'seppost' => array(
				'name'		=> __( 'Individual Posts:', 'hootkit' ),
				// 'desc'		=> __( 'INDIVIDUAL POSTS', 'hootkit' ),
				'type'		=> 'separator',
			),
			'show_author' => array(
				'name'		=> __( 'Show Author', 'hootkit' ),
				'type'		=> 'checkbox',
			),
			'show_date' => array(
				'name'		=> __( 'Show Post Date', 'hootkit' ),
				'type'		=> 'checkbox',
			),
			'show_comments' => array(
				'name'		=> __( 'Show number of comments', 'hootkit' ),
				'type'		=> 'checkbox',
			),
			'show_cats' => array(
				'name'		=> __( 'Show Categories', 'hootkit' ),
				'type'		=> 'checkbox',
			),
			'show_tags' => array(
				'name'		=> __( 'Show tags', 'hootkit' ),
				'type'		=> 'checkbox',
			),
			'firstpost' => array(
				'name'		=> __( 'First Grid Post', 'hootkit' ),
				'type'		=> 'collapse',
				'settings'	=> array( 'state' => 'open' ),
				'fields'	=> array(
					'standard' => array(
						'name'		=> __( 'Display as Standard 1x1 Size', 'hootkit' ),
						'desc'		=> __( 'By default, first post is double in size and takes up space of 2 Columns x 2 Rows', 'hootkit' ),
						'type'		=> 'checkbox',
					),
					'author' => array(
						'name'		=> __( 'Show Author', 'hootkit' ),
						'type'		=> 'checkbox',
						'std'		=> 1,
					),
					'date' => array(
						'name'		=> __( 'Show Post Date', 'hootkit' ),
						'type'		=> 'checkbox',
						'std'		=> 1,
					),
					'comments' => array(
						'name'		=> __( 'Show number of comments', 'hootkit' ),
						'type'		=> 'checkbox',
					),
					'cats' => array(
						'name'		=> __( 'Show Categories', 'hootkit' ),
						'type'		=> 'checkbox',
					),
					'tags' => array(
						'name'		=> __( 'Show tags', 'hootkit' ),
						'type'		=> 'checkbox',
					),
					'count' => array(
						'name'		=> __( 'Number of Posts', 'hootkit' ),
						'desc'		=> __( 'Selecting more than 1 post will <strong>convert the first grid into a SLIDER</strong>', 'hootkit' ),
						'type'		=> 'smallselect',
						'std'		=> '1',
						'options'	=> array(
							'1'	=> __( '1', 'hootkit' ),
							'2'	=> __( '2', 'hootkit' ),
							'3'	=> __( '3', 'hootkit' ),
							'4'	=> __( '4', 'hootkit' ),
							'5'	=> __( '5', 'hootkit' ),
							'6'	=> __( '6', 'hootkit' ),
							'7'	=> __( '7', 'hootkit' ),
							'8'	=> __( '8', 'hootkit' ),
							'9'	=> __( '9', 'hootkit' ),
							'10'=> __( '10', 'hootkit' ),
						),
					),
					'category' => array(
						'name'		=> __( 'Category (Optional)', 'hootkit' ),
						'desc'		=> __( 'Leave empty to let this post follow the post order of the remaining widget. Adding categories here will exclude those categories from the remaining widget grids.', 'hootkit' ),
						'type'		=> 'multiselect',
						'options'	=> (array)Hoot_List::categories('category'),
					),
					'fix' => array(
						'type'		=> '<input type="hidden" name="%name%" id="%id%" value="na" class="%class%">',
						// Bugfix: This field is added since all the fields in collapsible are checkboxes. So when all checkbox are unchecked, value for "widget-hoot-post-grid-widget[N][firstpost]" in the instance is returned as false by the browsers instead of an array with all emements = 0 (empty string value is ok, but we still add a dummy value)
					),
				),
			),
			'sepcss' => array(
				'type'		=> 'separator',
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

		if ( !in_array( 'post-grid-firstpost-category', hootkit()->get_config( 'supports' ) ) )
			unset( $settings['form_options']['firstpost']['fields']['category'] ); // Currently not supported by themes as this complicates the option. Can be turned on by request
		if ( !in_array( 'post-grid-firstpost-slider', hootkit()->get_config( 'supports' ) ) )
			unset( $settings['form_options']['firstpost']['fields']['count'] );

		$settings = apply_filters( 'hootkit_post_grid_widget_settings', $settings );

		parent::__construct( $settings['id'], $settings['name'], $settings['widget_options'], $settings['control_options'], $settings['form_options'] );

	}

	/**
	 * Display the widget content
	 */
	function display_widget( $instance, $before_title = '', $title = '', $after_title = '' ) {
		// Allow theme/child-themes to use their own template
		$widget_template = hoot_get_widget( 'post-grid', false );
		// Use Hootkit template if theme does not have one
		$widget_template = ( $widget_template ) ? $widget_template : hootkit()->dir . 'template/widget-post-grid.php';
		// Fire up the template
		extract( $instance, EXTR_SKIP );
		if ( is_string( $widget_template ) && file_exists( $widget_template ) ) include ( $widget_template );
	}

}

/**
 * Register Widget
 */
function hootkit_post_grid_widget_register(){
	register_widget( 'HootKit_Post_Grid_Widget' );
}
add_action( 'widgets_init', 'hootkit_post_grid_widget_register' );