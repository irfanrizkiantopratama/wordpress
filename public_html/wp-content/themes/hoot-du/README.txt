=== Hoot Du ===
Contributors: wphoot
Tags: one-column, two-columns, three-columns, left-sidebar, right-sidebar, custom-background, custom-colors, custom-header, custom-menu, custom-logo, featured-images, footer-widgets, full-width-template, microformats, sticky-post, theme-options, threaded-comments, translation-ready, e-commerce, entertainment, food-and-drink
Requires at least: 4.0
Tested up to: 5.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

Hoot Du is a responsive WordPress theme with a bold modern design.

== Description ==

Hoot Du is a responsive WordPress theme with a bold modern design. For more information about Hoot Du please go to https://wphoot.com/themes/hoot-du/ Theme support is available at https://wphoot.com/support/ You can also check out the theme instructions at https://wphoot.com/support/hoot-du/ and demo at https://demo.wphoot.com/hoot-du/ for a closer look.

== Frequently Asked Questions ==

= How to install Hoot Du =

1. In your admin panel, go to Appearance -> Themes and click the 'Add New' button.
2. Type in 'Hoot Du' in the search form and press the 'Enter' key on your keyboard.
3. Click on the 'Activate' button to use your new theme right away.

= How to get theme support =

You can look at the theme instructions at https://wphoot.com/support/hoot-du/ To get support beyond the scope of documentation provided, please open a support ticket via https://wphoot.com/support/

== Changelog ==

= 2.8.6 =
* Polylang menu flag image alignment
* Fix bbPress Forums view (archive view was being displayed instead of forums list)
* Fix title/descriptions for bbPress User view, Single Forum view, Forums view
* Fix Header Aside Search display on mobile
* Fix wp-SmushIt lazyload compatibility issue caused due to class="no-js" in <html> (remnant from modernizr.js)
* Support 'announce-headline' for HootKit Announce widget

= 2.8.5 =
* Add gravatar to loop meta for authors

= 2.8.4 =
* Internal Version. Not Released

= 2.8.3 =
* Update ul.wp-block-gallery css for WP 5.3 compatibility
* Added HTML5 Supports Argument for Script and Style Tags for WP 5.3
* Added semibold option for typography settings
* Fix custom logo bug (fix warning when default value does not have all options defined for sortitem line)
* Apply filter to frontpage id index for background options
* Fix content block row bottom margin
* Add support and accompanying css for Ticker Posts widget
* Add support and accompanying css for Post Grid widget - first post slider
* CSS fix for sortitem checkbox input in customizer
* CSS fix for woocommerce message button on small screen (ticket#4621)
* Upgrade logo-with-icon from Table to Flexbox

= 2.8.2 =
* Logo and Site Description css fixes
* Added Logo Border option

= 2.8.1 =
* Accessibility Improvements: Skip to Content link fixed
* Accessibility Improvements: Keyboard Navigation improved (link and form field outlines, improved button focus visual)
* Removed min-width for grid (mobile view)
* Fix iframe and embed margins in wp embed blocks
* Fix label max-width for contact forms to display properly on mobile
* Fix for woocommerce pagination when inifinite scroll is active
* Fix required fonticon for Contact Form 7 plugin
* Bug Fix: Add space for loop-meta-wrap class (for mods)

= 2.8.0 =
* Remove shim for the_custom_logo
* Fix: Inline menu display css fix with mega menu plugin
* Apply filter on arguments array for the_posts_pagination
* Add help link to One Click Demo documentation
* Replace support for HootKit with OCDI plugin

= 2.7.8 =
* Removed One Click Demo for compatibility with TRT guidelines
* HootKit CSS Fixes
* CSS fix: last menu item dropdown
* Added missing argument for 'the_title' filter to prevent error with certain plugins
* Added Featured image for Categories and Tags
* Added CSS to style woocommerce buttons based on theme colors
* Updated location functions to optionally return templates array - updated hoot_comments_callback accordingly

= 2.7.7 =
* Internal Version. Not Released

= 2.7.6 =
* Added option for frontpage module font color
* Improved template logic for displaying Previous/Next post (using a wrapping function)

= 2.7.5 =
* Added support for 'inherit' value in css sanitization for dynamic css build
* Bug fix for 'box-shadow' property in css sanitization for dynamic css build
* Bug fix by unsetting selective refresh from passing into $settings array in customizer interface builder

= 2.7.4 =
* Added the new 'wp_body_open' function
* Improved dynamic css for ajax login form

= 2.7.3 =
* Added Tribe 'The Events Calendar' plugin support - template fixes
* Improved logic for hoot_get_mod function

= 2.7.2 =
* Add css support for Gutenberg gallery block
* Fix parallax image misalignment on load when lightslider is present
* Sanitize debug data for logged in admin users
* Added 'background-size' option to dynamic css style-builder
* Minor CSS adjustments (static and dynamic) for text logo color

= 2.7.1 =
* Internal Version. Not Released

= 2.7.0 =
* Fix <!--default--> content for postfooter in new theme installations
* Removed older IE css support
* Fixed Color class name
* Removed minified script/style from admin
* Add support for selective refresh in customizer settings
* One click demo import support added (via HootKit plugin)
* Updated welcome page to help users with OCDI
* Support for 'About/Profile' widget added
* Standardized function prefixes for theme / Hoot framework library

= 1.9.9 =
* Initial release.

== Upgrade Notice ==

= 2.7.0 =
* This is the officially supported stable release version. Please update to this version before opening a support ticket.

== Resources ==

= This Theme has code derived/modified from the following resources all of which, like WordPress, are distributed under the terms of the GNU GPL =

* Underscores WordPress Theme, Copyright 2012 Automattic http://underscores.me/
* Hybrid Core Framework v3.0.0, Copyright 2008 - 2015, Justin Tadlock  http://themehybrid.com/
* Hybrid Base WordPress Theme v1.0.0, Copyright 2013 - 2015, Justin Tadlock  http://themehybrid.com/
* Customizer Library v1.3.0, Copyright 2010 WP Theming http://wptheming.com
* HootKit WordPress Plugin, Copyright 2018 wpHoot https://wordpress.org/plugins/hootkit/

= This theme bundles the following third-party resources =

* FitVids http://fitvidsjs.com/ Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com : WTFPL license http://sam.zoy.org/wtfpl/
* lightSlider http://sachinchoolur.github.io/lightslider/ Copyright sachi77n@gmail.com : MIT License
* Superfish https://github.com/joeldbirch/superfish/ Copyright Joel Birch : MIT License
* Font Awesome http://fontawesome.io/ Copyright (c) 2015, Dave Gandy : SIL OFL 1.1 (Font) MIT License (Code)
* TRT Customizer Pro https://github.com/justintadlock/trt-customizer-pro Copyright 2016 Justin Tadlock : GNU GPL Version 2
* TGM-Plugin-Activation https://github.com/TGMPA/TGM-Plugin-Activation Copyright (c) 2016 TGM : GNU GPL Version 2
* Parallax http://pixelcog.com/parallax.js/ Copyright 2016 PixelCog Inc. : MIT License
* Theia Sticky Sidebar https://github.com/WeCodePixels/theia-sticky-sidebar/ Copyright 2013-2016 WeCodePixels : MIT License
* Resize Sensor from CSS Element Queries https://github.com/marcj/css-element-queries/ Copyright (c) 2013 Marc J. Schmidt : MIT License

= This theme screenshot contains the following images =

* Image: Beans Coffee Cup https://www.pexels.com/photo/2059/ : CC0
* Image: Apple Imac on Desk https://www.pexels.com/photo/1712/ : CC0
* Image: Ingredients Cooking Preparation https://pixabay.com/en/ingredients-cooking-preparation-498199/ : CC0
* Image: Fashion Man Wristwatch https://www.pexels.com/photo/1597/ : CC0
* Image: Painting Typography Gift Paint https://www.pexels.com/photo/5860/ : CC0
* Image: After Business Hours Bar https://www.pexels.com/photo/34650/ : CC0
* Image: Light Coffee Pen Working https://www.pexels.com/photo/6337/ : CC0

= Bundled Images: The theme bundles these images =
* Image: /images/header.jpg https://www.pexels.com/photo/34650/ : CC0
* Image: /images/modulebg.jpg https://www.pexels.com/photo/7057/ : CC0

= Bundled Images: The theme bundles patterns in /images/patterns =

* Background Patterns, Copyright 2015, wpHoot : CC0

= Bundled Images: The theme bundles composite images in /include/admin/images using the following resources =

* Misc UI Grpahics, Copyright 2015, wpHoot : CC0
* Image: Pencil https://pixabay.com/photo-2782840/ : CC0
* Image: Color Wheel https://pixabay.com/photo-455365/ : CC0
* Image: Milk Splash https://pixabay.com/photo-2064088/ : CC0
* Image: Raspberry https://pixabay.com/photo-2023404/ : CC0
* Image: Beverage https://pixabay.com/photo-3157395/ : CC0
* Image: Season https://pixabay.com/photo-1985856/ : CC0
* Image: Avatar https://pixabay.com/photo-2155431/ : CC0
* Image: Avatar https://pixabay.com/photo-2191931/ : CC0
* Image: People https://pixabay.com/photo-3245739/ : CC0