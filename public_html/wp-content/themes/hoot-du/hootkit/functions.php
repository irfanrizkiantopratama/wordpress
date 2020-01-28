<?php
/**
 * This file contains functions and hooks for styling Hootkit plugin
 *   Hootkit is a free plugin released under GPL license and hosted on wordpress.org.
 *   It is recommended to the user via wp-admin using TGMPA class
 *
 * This file is loaded at 'after_setup_theme' action @priority 10 ONLY IF hootkit plugin is active
 *
 * @package    Hoot Du
 * @subpackage HootKit
 */

// Register HootKit
add_filter( 'hootkit_register', 'hootdu_register_hootkit', 5 );

// Add hootkit styles. Set priority to @11 (unlike other scripts/styles @10)
// However we set stylesheet dependency to main stylesheet so hootkit css is loaded afterwards.
// Hootkit plugin loads its styles at default @10 (we skip this using config 'theme_css')
// The theme's main style is loaded @12 (Hence dynamic styles are loaded after -> now hooked to hootkit)
// The theme's main script is loaded @11
add_action( 'wp_enqueue_scripts', 'hootdu_enqueue_hootkit', 11 );
// Set dynamic css handle to hootkit
add_filter( 'hoot_style_builder_inline_style_handle', 'hootdu_dynamic_css_hootkit_handle', 5 );

// Add dynamic CSS for hootkit
add_action( 'hoot_dynamic_cssrules', 'hootdu_hootkit_dynamic_cssrules' );

/**
 * Register Hootkit
 *
 * @since 1.0
 * @param array $config
 * @return string
 */
if ( !function_exists( 'hootdu_register_hootkit' ) ) :
function hootdu_register_hootkit( $config ) {
	// Array of configuration settings.
	$config = array(
		'nohoot'    => false,
		'theme_css' => true,
		'modules'   => array(
			'sliders' => array( 'image', 'postimage' ),
			'widgets' => array( 'announce', 'content-blocks', 'content-posts-blocks', 'cta', 'icon', 'post-grid', 'post-list', 'social-icons', 'ticker', 'ticker-posts', 'profile', ),
		),
		'supports'  => array( 'post-grid-firstpost-slider', 'announce-headline' ),
	);
	return $config;
}
endif;

/**
 * Enqueue Scripts and Styles
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_enqueue_hootkit' ) ) :
function hootdu_enqueue_hootkit() {

	/* Load Hootkit Style - Add dependency so that hotkit is loaded after */
	$style_uri = hoot_locate_style( 'hootkit/hootkit' );
	wp_enqueue_style( 'hootdu-hootkit', $style_uri, array( 'hoot-style' ), hoot_data()->template_version );

	/* Load Hootkit Javascript */
	// $script_uri = hoot_locate_script( 'hootkit/hootkit' );
	// wp_enqueue_script( 'hootdu-hootkit', $script_uri, array( 'jquery' ), hoot_data()->template_version, true );

}
endif;

/**
 * Set dynamic css handle to hootkit
 *
 * @since 1.0
 * @access public
 * @return void
 */
if ( !function_exists( 'hootdu_dynamic_css_hootkit_handle' ) ) :
function hootdu_dynamic_css_hootkit_handle( $handle ) {
	return 'hootdu-hootkit';
}
endif;

/**
 * Custom CSS built from user theme options for hootkit features
 * For proper sanitization, always use functions from library/sanitization.php
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hootdu_hootkit_dynamic_cssrules' ) ) :
function hootdu_hootkit_dynamic_cssrules() {

	// Get user based style values
	$styles = hootdu_user_style(); // echo '<!-- '; print_r($styles); echo ' -->';
	extract( $styles );

	/*** Add Dynamic CSS ***/

	/* Light Slider */

	hoot_add_css_rule( array(
						'selector'  => '.lSSlideOuter ul.lSPager.lSpg > li:hover a, .lSSlideOuter ul.lSPager.lSpg > li.active a',
						'property'  => 'background-color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );


	/* Sidebars and Widgets */

	hoot_add_css_rule( array(
						'selector'  => '.widget .view-all a:hover',
						'property'  => 'color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) ); // Overridden in premium
	// hoot_add_css_rule( array(
	// 					'selector'  => '.sidebar .view-all-top.view-all-withtitle a, .sub-footer .view-all-top.view-all-withtitle a, .footer .view-all-top.view-all-withtitle a, .sidebar .view-all-top.view-all-withtitle a:hover, .sub-footer .view-all-top.view-all-withtitle a:hover, .footer .view-all-top.view-all-withtitle a:hover',
	// 					'property'  => 'color',
	// 					'value'     => $accent_font,
	// 					'idtag'     => 'accent_font',
	// 				) );

	if ( !empty( $widgetmargin ) ) :
		hoot_add_css_rule( array(
						'selector'  => '.bottomborder-line:after' . ',' . '.bottomborder-shadow:after',
						'property'  => 'margin-top',
						'value'     => $widgetmargin,
						'idtag'     => 'widgetmargin',
					) );
		hoot_add_css_rule( array(
						'selector'  => '.topborder-line:before' . ',' . '.topborder-shadow:before',
						'property'  => 'margin-bottom',
						'value'     => $widgetmargin,
						'idtag'     => 'widgetmargin',
					) );
	endif;

	hoot_add_css_rule( array(
						'selector'  => '.cta-subtitle',
						'property'  => 'color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	hoot_add_css_rule( array(
						'selector' => '.content-block-icon i',
						'property' => 'color',
						'value'    => $accent_color,
						'idtag'    => 'accent_color',
					) );

	hoot_add_css_rule( array(
						'selector' => '.icon-style-circle' .',' . '.icon-style-square',
						'property' => 'border-color',
						'value'    => $accent_color,
						'idtag'    => 'accent_color',
					) );

	hoot_add_css_rule( array(
						'selector'  => '.content-block-style3 .content-block-icon',
						'property'  => 'background',
						'value'     => $content_bg_color,
					) );

}
endif;

/**
 * HootKit Customization
 *
 * @since 1.0
 * @access public
 */
if ( !function_exists( 'hootdu_hootkit_content_block' ) ) :
function hootdu_hootkit_content_block( $attr, $context ) {
	if ( !empty( $context['style'] ) && $context['style'] == 'style2' && !empty( $context['visualtype'] ) )
		$attr['class'] = 'content-block contrast-typo';

	return $attr;
}
endif;
add_filter( 'hoot_attr_content-block', 'hootdu_hootkit_content_block', 10, 2 );

/**
 * Modify Post Grid settings
 *
 * @since 1.0
 * @param array $settings
 * @return string
 */
function hootdu_post_grid_widget_settings( $settings ) {
	if ( isset( $settings['form_options']['columns']['std'] ) )
		$settings['form_options']['columns']['std'] = 4;
	// Hootkit <= 1.0.13 support // @todo remove in future version
	if ( isset( $settings['form_options']['count']['desc'] ) )
		$settings['form_options']['count']['desc'] = __( 'Default: 5 (posts without a featured image are skipped)', 'hoot-du' );
	return $settings;
}
add_filter( 'hootkit_post_grid_widget_settings', 'hootdu_post_grid_widget_settings', 5 );

/**
 * Modify Post Grid Query Args
 *
 * @since 1.0
 * @param array $query_args
 * @param array $instance
 * @return string
 */
function hootdu_post_grid_query( $query_args, $instance ) {
	$count = ( isset( $instance['count'] ) ) ? $instance['count'] : 5;
	$count = intval( $count );
	$query_args['posts_per_page'] = ( empty( $count ) ) ? 5 : $count;
	return $query_args;
}
// Hootkit <= 1.0.13 support // @todo remove in future version
add_filter( 'hootkit_post_grid_query', 'hootdu_post_grid_query', 5, 2 );