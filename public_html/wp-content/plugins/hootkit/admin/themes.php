<?php
/**
 * Functions for themes.php
 *
 * @package           Hootkit
 * @subpackage        Hootkit/admin
 * 
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Reorder parent theme to after active child theme in themes.php
 * Located in fn wp_prepare_themes_for_js() in wp-admin/includes/theme.php
 *
 * @since 1.0.11
 * @param array $prepared_themes Array of themes.
 * @return array
 */
add_filter( 'wp_prepare_themes_for_js', 'hootkit_prepare_themes_for_display' );
if ( !function_exists( 'hootkit_prepare_themes_for_display' ) ):
function hootkit_prepare_themes_for_display( $prepared_themes ) {
	if ( is_child_theme() ) {
		$template_name = get_template();
		$child_name = get_stylesheet();
		if ( isset( $prepared_themes[ $template_name ] ) && isset( $prepared_themes[ $child_name ] ) ) {
			$cachechild = array( $child_name => $prepared_themes[ $child_name ] );
			$cachetemplate = array( $template_name => $prepared_themes[ $template_name ] );
			unset( $prepared_themes[ $child_name ] );
			unset( $prepared_themes[ $template_name ] );
			return $cachechild + $cachetemplate + $prepared_themes;
		}
	}
	return $prepared_themes;
};
endif;

/**
 * Change background color and font weight for Parent Theme Title
 *
 * @since 1.0.11
 * @param string $hook
 * @return void
 */
add_action( 'admin_enqueue_scripts', 'hootkit_parent_theme_title_style' );
function hootkit_parent_theme_title_style( $hook ) {
	if ( 'themes.php' == $hook && is_child_theme() ) {
		echo '<style>.theme.active + .theme .theme-name { background: #515d69; color: #fff; font-weight: 300; } .theme.active + .theme .theme-name:before { content: "Parent: "; font-weight: bold; }</style>';
	}
}