<?php
/**
 * Add dynamic css to frontend.
 *
 * This file is loaded at 'after_setup_theme' hook with 10 priority.
 *
 * @package    Hoot Du
 * @subpackage Theme
 */

/* Add action at 5 for adding css rules (premium hooks in at 6-9). Child themes can hook in at priority 10. */
add_action( 'hoot_dynamic_cssrules', 'hootdu_dynamic_cssrules', 5 );

/**
 * Create user based style values
 *
 * @since 1.0
 * @access public
 * @param string $key return a specific key value, else the entire styles array
 * @return array|string
 */
if ( !function_exists( 'hootdu_user_style' ) ) :
function hootdu_user_style( $key = false ){
	static $styles;
	// Caution with using static variable for cache: Calling this function at 'after_setup_theme' hook with 10 priority
	// (after this file is loaded obviously) will prevent further applying of filter hook (by child-theme/plugin/premium)
	// which may also be declared at 'after_setup_theme' hook with 10+ priority. It is safe to call this function thereafter.
	if ( empty( $styles ) ) {
		$styles = array();
		$styles['grid_width']           = intval( hoot_get_mod( 'site_width' ) ) . 'px';
		$styles['accent_color']         = hoot_get_mod( 'accent_color' );
		$styles['accent_color_dark']    = hoot_color_darken( $styles['accent_color'], 12.5, 12.5 );
		$styles['accent_font']          = hoot_get_mod( 'accent_font' );
		$styles['contrast_color']       = hoot_get_mod( 'background_color' ); // WordPress Custom Background
		$styles['contrast_font']        = hoot_get_mod( 'contrast_font' );
		$styles['contrast_color_light'] = hoot_color_increase( $styles['contrast_color'], 12.5, 12.5 ); // #fff => #dfdfdf , #000 => #202020, #222 => 3e3e3e
		$styles['darkhighlight_color']  = hoot_color_increase( $styles['contrast_color'], 15.5, 15.5 ); // #fff => #d7d7d7 , #000 => #282828, #222 => 444
		$styles['logo_fontface']        = hoot_get_mod( 'logo_fontface' );
		$styles['logo_fontface_style']  = hoot_get_mod( 'logo_fontface_style' );
		$styles['headings_fontface']    = hoot_get_mod( 'headings_fontface' );
		$styles['headings_fontface_style'] = hoot_get_mod( 'headings_fontface_style' );
		// $styles['site_layout']          = hoot_get_mod( 'site_layout' );
		// $styles['background_color']     = hoot_get_mod( 'background_color' ); // WordPress Custom Background
		$styles['box_background_color'] = hoot_get_mod( 'box_background_color' );
		$styles['content_bg_color']     = $styles['box_background_color'];
		$styles['site_title_icon_size'] = hoot_get_mod( 'site_title_icon_size' );
		$styles['logo_image_width']     = hoot_get_mod( 'logo_image_width' );
		$styles['logo_image_width']     = ( intval( $styles['logo_image_width'] ) ) ?
		                                    intval( $styles['logo_image_width'] ) . 'px' :
		                                    '150px';
		$styles['logo']                 = hoot_get_mod( 'logo' );
		$styles['logo_custom']          = apply_filters( 'hootdu_logo_custom_text', hoot_sortlist( hoot_get_mod( 'logo_custom' ) ) );
		$styles['widgetmargin']         = hoot_get_mod( 'widgetmargin' );
		$styles['widgetmargin']         = ( intval( $styles['widgetmargin'] ) ) ?
		                                    intval( $styles['widgetmargin'] ) . 'px' :
		                                    false;
		$styles['smallwidgetmargin']    = ( intval( $styles['widgetmargin'] ) ) ?
		                                    ( intval( $styles['widgetmargin'] ) - 15 ) . 'px' :
		                                    false;
		$styles = apply_filters( 'hootdu_user_style', $styles );
	}
	if ( $key )
		return ( isset( $styles[ $key ] ) ) ? $styles[ $key ] : false;
	else
		return $styles;
}
endif;

/**
 * Custom CSS built from user theme options
 * For proper sanitization, always use functions from library/sanitization.php
 *
 * @since 1.0
 * @access public
 */
function hootdu_dynamic_cssrules() {

	// Get user based style values
	$styles = hootdu_user_style(); // echo '<!-- '; print_r($styles); echo ' -->';
	extract( $styles );

	/*** Add Dynamic CSS ***/

	/* Hoot Grid */

	hoot_add_css_rule( array(
						'selector'  => '.hgrid',
						'property'  => 'max-width',
						'value'     => $grid_width,
						'idtag'     => 'grid_width',
					) );

	/* Base Typography and HTML */

	hoot_add_css_rule( array(
						'selector'  => 'a',
						'property'  => 'color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) ); // Overridden in premium

	hoot_add_css_rule( array(
						'selector'  => 'a:hover',
						'property'  => 'color',
						'value'     => $accent_color_dark,
					) ); // Overridden in premium

	hoot_add_css_rule( array(
						'selector'  => '.accent-typo',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $accent_color, 'accent_color' ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.invert-typo',
						'property'  => 'color',
						'value'     => $content_bg_color,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.enforce-typo',
						'property'  => 'background',
						'value'     => $content_bg_color,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.contrast-typo',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $contrast_color, 'contrast_color' ),
							'color'      => array( $contrast_font, 'contrast_font' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => 'body.wordpress input[type="submit"], body.wordpress #submit, body.wordpress .button',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $accent_color, 'accent_color' ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => 'body.wordpress input[type="submit"]:hover, body.wordpress #submit:hover, body.wordpress .button:hover, body.wordpress input[type="submit"]:focus, body.wordpress #submit:focus, body.wordpress .button:focus',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $accent_color_dark ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

	$headingproperty = array();
	if ( 'standard' == $headings_fontface )
		$headingproperty['font-family'] = array( '"Fira Sans", sans-serif' );
	elseif ( 'alternate' == $headings_fontface )
		$headingproperty['font-family'] = array( '"Comfortaa", sans-serif' );
	elseif ( 'display' == $headings_fontface )
		$headingproperty['font-family'] = array( '"Oswald", sans-serif' );
	elseif ( 'display2' == $headings_fontface )
		$headingproperty['font-family'] = array( '"Patua One", sans-serif' );
	elseif ( 'heading' == $headings_fontface )
		$headingproperty['font-family'] = array( '"Slabo 27px", serif' );
	if ( 'uppercase' == $headings_fontface_style )
		$headingproperty['text-transform'] = array( 'uppercase' );
	else
		$headingproperty['text-transform'] = array( 'none' );
	if ( !empty( $headingproperty ) ) {
		hoot_add_css_rule( array(
						'selector'  => 'h1, h2, h3, h4, h5, h6, .title, .titlefont',
						'property'  => $headingproperty,
					) ); // Removed in premium
	}

	/* Layout */

	// if ( $site_layout == 'boxed' ) {
	hoot_add_css_rule( array(
						'selector'  => '#main.main', // . ',' . '#header-supplementary' . ',' . '.below-header',
						'property'  => 'background',
						'value'     => $content_bg_color,
					) );
	// }

	/* Header (Topbar, Header, Main Nav Menu) */

	hoot_add_css_rule( array(
						'selector'  => '.header-aside' . ',' . 'div.menu-side-box' . ',' . '.menu-items',
						'property'  => 'border-color',
						'value'     => $darkhighlight_color,
						// 'media'     => 'only screen and (max-width: 969px)',
				) );

	/* Header (Topbar, Header, Main Nav Menu) */
	// Topbar

	// hoot_add_css_rule( array(
	// 					'selector'  => '#topbar',
	// 					'property'  => array(
	// 						// property  => array( value, idtag, important, typography_reset ),
	// 						'background' => array( $accent_color, 'accent_color' ),
	// 						'color'      => array( $accent_font, 'accent_font' ),
	// 						),
	// 				) ); // Overridden in premium

	// hoot_add_css_rule( array(
	// 					'selector'  => '#topbar.js-search .searchform.expand .searchtext',
	// 					'property'  => 'background',
	// 					'value'     => $accent_color,
	// 					'idtag'     => 'accent_color',
	// 				) ); // Overridden in premium

	/* Header (Topbar, Header, Main Nav Menu) */
	// Logo

	hoot_add_css_rule( array(
						'selector'  => '#site-logo.logo-border',
						'property'  => 'border-color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	/* Header (Topbar, Header, Main Nav Menu) */
	// Header Layout - Search

	hoot_add_css_rule( array(
						'selector'  => '.header-aside-search.js-search .searchform i.fa-search',
						'property'  => 'color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	/* Header (Topbar, Header, Main Nav Menu) */
	// Text Logo

	$logoproperty = array();
	if ( 'standard' == $logo_fontface )
		$logoproperty['font-family'] = array( '"Fira Sans", sans-serif' );
	elseif ( 'alternate' == $logo_fontface )
		$logoproperty['font-family'] = array( '"Comfortaa", sans-serif' );
	elseif ( 'display' == $logo_fontface )
		$logoproperty['font-family'] = array( '"Oswald", sans-serif' );
	elseif ( 'display2' == $logo_fontface )
		$logoproperty['font-family'] = array( '"Patua One", sans-serif' );
	elseif ( 'heading' == $logo_fontface )
		$logoproperty['font-family'] = array( '"Slabo 27px", serif' );
	if ( 'uppercase' == $logo_fontface_style )
		$logoproperty['text-transform'] = array( 'uppercase' );
	else
		$logoproperty['text-transform'] = array( 'none' );
	if ( !empty( $logoproperty ) ) {
		hoot_add_css_rule( array(
						'selector'  => '#site-title',
						'property'  => $logoproperty,
					) ); // Removed in premium
	}

	/* Header (Topbar, Header, Main Nav Menu) */
	// Logo (with icon)

	if ( intval( $site_title_icon_size ) ) {
		hoot_add_css_rule( array(
						'selector'  => '.site-logo-with-icon #site-title i',
						'property'  => 'font-size',
						'value'     => $site_title_icon_size,
						'idtag'     => 'site_title_icon_size',
					) );
	}

	/* Header (Topbar, Header, Main Nav Menu) */
	// Mixed/Mixedcustom Logo (with image)

	if ( !empty( $logo_image_width ) ) :
	hoot_add_css_rule( array(
						'selector'  => '.site-logo-mixed-image img',
						'property'  => 'max-width',
						'value'     => $logo_image_width,
						'idtag'     => 'logo_image_width',
					) );
	endif;

	/* Header (Topbar, Header, Main Nav Menu) */
	// Custom Logo

	if ( 'custom' == $logo || 'mixedcustom' == $logo ) {
		if ( is_array( $logo_custom ) && !empty( $logo_custom ) ) {
			$lcount = 1;
			foreach ( $logo_custom as $logo_custom_line ) {
				if ( !$logo_custom_line['sortitem_hide'] && !empty( $logo_custom_line['size'] ) ) {
					hoot_add_css_rule( array(
						'selector'  => '#site-logo-custom .site-title-line' . $lcount . ',#site-logo-mixedcustom .site-title-line' . $lcount,
						'property'  => 'font-size',
						'value'     => $logo_custom_line['size'],
					) );
				}
				if ( !$logo_custom_line['sortitem_hide'] && !empty( $logo_custom_line['font'] ) ) {
					$logo_custom_line_tt = 'none';
					$logo_custom_line_tt = ( $logo_custom_line['font'] == 'heading' && 'uppercase' == $logo_fontface_style ) ? 'uppercase' : $logo_custom_line_tt;
					$logo_custom_line_tt = ( $logo_custom_line['font'] == 'heading2' && 'uppercase' == $headings_fontface_style ) ? 'uppercase' : $logo_custom_line_tt;
					hoot_add_css_rule( array(
						'selector'  => '#site-logo-custom .site-title-line' . $lcount . ',#site-logo-mixedcustom .site-title-line' . $lcount,
						'property'  => 'text-transform',
						'value'     => $logo_custom_line_tt,
					) );
				}
				$lcount++;
			}
		}
	}

	hoot_add_css_rule( array(
						'selector'  => '.site-title-line em',
						'property'  => 'color',
						'value'     => $accent_color,
						'idtag'     => 'accent_color',
					) );

	$sitetitleheadingfont = '';
	if ( 'standard' == $headings_fontface )
		$sitetitleheadingfont = '"Fira Sans", sans-serif';
	elseif ( 'alternate' == $headings_fontface )
		$sitetitleheadingfont = '"Comfortaa", sans-serif';
	elseif ( 'display' == $headings_fontface )
		$sitetitleheadingfont = '"Oswald", sans-serif';
	elseif ( 'display2' == $headings_fontface )
		$sitetitleheadingfont = '"Patua One", sans-serif';
	elseif ( 'heading' == $headings_fontface )
		$sitetitleheadingfont = '"Slabo 27px", serif';
	hoot_add_css_rule( array(
						'selector'  => '.site-title-heading-font',
						'property'  => 'font-family',
						'value'     => $sitetitleheadingfont,
					) );

	/* Header (Topbar, Header, Main Nav Menu) */
	// Nav Menu

	hoot_add_css_rule( array(
						'selector'  => '.menu-items ul',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background'   => array( $contrast_color, 'contrast_color' ),
							'border-color' => array( $darkhighlight_color ),
							),
					) ); // Removed in premium

	hoot_add_css_rule( array(
						'selector'  => '.mobilemenu-fixed .menu-toggle, .mobilemenu-fixed .menu-items',
						'property'  => 'background',
						'value'     => $contrast_color,
						'media'     => 'only screen and (max-width: 969px)',
				) ); // Removed in premium

	hoot_add_css_rule( array(
						'selector'  => '.menu-items > li.current-menu-item, .menu-items > li.current-menu-ancestor, .menu-items > li:hover' . ',' .
									   '.menu-items ul li.current-menu-item, .menu-items ul li.current-menu-ancestor, .menu-items ul li:hover',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $accent_color, 'accent_color' ),
							),
					) );
	hoot_add_css_rule( array(
						// 'selector'  => '.menu-items > li.current-menu-item > a, .menu-items > li.current-menu-ancestor > a, .menu-items > li:hover > a' . ',' .
						// 			   '.menu-items ul li.current-menu-item > a, .menu-items ul li.current-menu-ancestor > a, .menu-items ul li:hover > a',
						// Overqualify to override .page-wrapper .contrast-typo a:not(input):not(.button) , .page-wrapper .contrast-typo a:hover:not(input):not(.button)
						'selector'  => '#header .menu-items > li.current-menu-item > a, #header .menu-items > li.current-menu-ancestor > a, #header .menu-items > li:hover > a' . ',' .
									   '#header .menu-items > li.menu-item > a:hover' . ',' .
									   '#header .menu-items ul li.current-menu-item > a, #header .menu-items ul li.current-menu-ancestor > a, #header .menu-items ul li:hover > a' . ',' .
									   '#header .menu-items ul li.menu-item > a:hover',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

	/* Main #Content */

	hoot_add_css_rule( array(
						'selector'  => '.main > .loop-meta-wrap.pageheader-bg-default, .main > .loop-meta-wrap.pageheader-bg-stretch, .main > .loop-meta-wrap.pageheader-bg-both',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $contrast_color_light ),
							'color'      => array( $contrast_font, 'contrast_font' ),
							),
					) );

	// hoot_add_css_rule( array(
	// 					'selector'  => '.entry-footer .entry-byline',
	// 					'property'  => 'color',
	// 					'value'     => $accent_color,
	// 					'idtag'     => 'accent_color',
	// 				) ); // Removed in premium // Overridden in premium

	/* Main #Content for Index (Archive / Blog List) */

	hoot_add_css_rule( array(
						'selector'  => '.more-link',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'color'      => array( $accent_color, 'accent_color' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.more-link a',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							// 'background' => array( $content_bg_color ),
							'color'      => array( $accent_color, 'accent_color' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.more-link a:hover',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							// 'background' => array( $content_bg_color ),
							'color'      => array( $accent_color_dark, 'accent_color_dark' ),
							),
					) );

	/* Frontpage */

	$sections = hoot_sortlist( hoot_get_mod( 'frontpage_sections' ) );
	if ( is_array( $sections ) && !empty( $sections ) ) { foreach ( $sections as $key => $section ) {
		$id = ( $key == 'content' ) ? 'frontpage-page-content' : sanitize_html_class( 'frontpage-' . $key );
		$type = hoot_get_mod( "frontpage_sectionbg_{$key}-font" );
		switch ($type) {
			case 'color': $selector = '.'.$id.' *, .'.$id.' .more-link, .'.$id.' .more-link a'; break;
			case 'force': $selector = '#'.$id.' *, #'.$id.' .more-link, #'.$id.' .more-link a'; break;
			default: $selector = ''; break;
		}
		if ( $selector ) {
			hoot_add_css_rule( array(
						'selector'  => $selector,
						'property'  => 'color',
						'value'     => hoot_get_mod( "frontpage_sectionbg_{$key}-fontcolor" ),
					) );
		}
	} }

	/* Sidebars and Widgets */

	if ( !empty( $widgetmargin ) ) :
		hoot_add_css_rule( array(
						'selector'  => '.main-content-grid' . ',' . '.widget' . ',' . '.frontpage-area',
						'property'  => 'margin-top',
						'value'     => $widgetmargin,
						'idtag'     => 'widgetmargin',
					) );
		hoot_add_css_rule( array(
						'selector'  => '.widget' . ',' . '.frontpage-area',
						'property'  => 'margin-bottom',
						'value'     => $widgetmargin,
						'idtag'     => 'widgetmargin',
					) );
		hoot_add_css_rule( array(
						'selector'  => '.frontpage-area.module-bg-highlight, .frontpage-area.module-bg-color, .frontpage-area.module-bg-image',
						'property'  => 'padding',
						'value'     => $widgetmargin . ' 0',
					) );
		hoot_add_css_rule( array(
						'selector'  => '.sidebar',
						'property'  => 'margin-top',
						'value'     => $widgetmargin,
						'media'     => 'only screen and (max-width: 969px)',
					) );
		hoot_add_css_rule( array(
						'selector'  => '.frontpage-widgetarea > div.hgrid > [class*="hgrid-span-"]',
						'property'  => 'margin-bottom',
						'value'     => $widgetmargin,
						'media'     => 'only screen and (max-width: 969px)',
					) );
	endif;
	if ( !empty( $smallwidgetmargin ) ) :
		hoot_add_css_rule( array(
						'selector'  => '.footer .widget',
						'property'  => 'margin',
						'value'     => $smallwidgetmargin . ' 0',
					) );
	endif;

	hoot_add_css_rule( array(
						'selector'  => '.js-search .searchform.expand .searchtext',
						'property'  => 'background',
						'value'     => $content_bg_color,
					) );

	hoot_add_css_rule( array(
						'selector'  => '.contrast-typo.js-search .searchform.expand .searchtext, .contrast-typo .js-search .searchform.expand .searchtext',
						'property'  => 'background',
						'value'     => $contrast_color,
						'idtag'     => 'contrast_color',
					) );

	/* Plugins */

	hoot_add_css_rule( array(
						'selector'  => '#infinite-handle span' . ',' .
										'.lrm-form a.button, .lrm-form button, .lrm-form button[type=submit], .lrm-form #buddypress input[type=submit], .lrm-form input[type=submit]' . ',' .
										'.widget_newsletterwidget input.tnp-submit[type=submit], .widget_newsletterwidgetminimal input.tnp-submit[type=submit]' . ',' .
										'.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $accent_color, 'accent_color' ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $accent_color_dark ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

	hoot_add_css_rule( array(
						'selector'  => '.widget_newsletterwidget input.tnp-submit[type=submit]:hover, .widget_newsletterwidgetminimal input.tnp-submit[type=submit]:hover',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background' => array( $accent_color_dark ),
							'color'      => array( $accent_font, 'accent_font' ),
							),
					) );

	/* Footer */

	hoot_add_css_rule( array(
						'selector'  => '.sub-footer',
						'property'  => array(
							// property  => array( value, idtag, important, typography_reset ),
							'background'   => array( $contrast_color_light ),
							'border-color' => array( $darkhighlight_color ),
							),
					) ); // Overridden in premium

}