<?php
// Get total columns and set column counter
$columns = ( intval( $columns ) >= 1 && intval( $columns ) <= 5 ) ? intval( $columns ) : 4;

// Get total rows and set row counter
$rows = ( empty( $rows ) ) ? 0 : intval( $rows );
$rows = ( empty( $rows ) ) ? 2 : $rows;

// Edge case
if ( $rows == 1 || $columns == 1 )
	$firstpost['standard'] = 1;

// Create category array from main options 
if ( isset( $category ) && is_string( $category ) ) $category = array( $category ); // Pre 1.0.10 compatibility with 'select' type
$exccategory = ( !empty( $exccategory ) && is_array( $exccategory ) ) ? array_map( 'hootkit_append_negative', $exccategory ) : array(); // undefined if none selected in multiselect
$category = ( !empty( $category ) && is_array( $category ) ) ? array_merge( $category, $exccategory) : $exccategory; // undefined if none selected in multiselect


/*** Create a custom WP Query for first post grid ***/

$fpquery_args = array();

// Count
$fpquery_args['posts_per_page'] = ( !empty( $firstpost['count'] ) ) ? intval( $firstpost['count'] ) : 1;

// Categories : Follow widget cat option if firstpost categories is empty
if ( !empty( $firstpost['category'] ) ) // undefined if none selected in multiselect
	$fpquery_args['category'] = implode( ',', $firstpost['category'] );
elseif ( !empty( $category ) )
	$fpquery_args['category'] = implode( ',', $category );

// Skip posts without image
$fpquery_args['meta_query'] = array(
	array(
		'key' => '_thumbnail_id',
		'compare' => 'EXISTS'
	),
);

// Create Query
$fpquery_args = apply_filters( 'hootkit_post_grid_firstquery', $fpquery_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
$post_firstgrid_query = get_posts( $fpquery_args );


/*** Create a custom WP Query for remaining post grids ***/

$query_args = array();

// Count
$count = $rows * $columns;
$count--; // Remove count for first post
if ( empty( $firstpost['standard'] ) ) {
	$count = $count - 3;
	if ( $count < 0 ) $count = 0; // redundant after introduction of edge case logic above
}
$query_args['posts_per_page'] = $count;

// Categories : Exclude firstpost categories if not empty ; else skip number of posts from first post grid
if ( !empty( $firstpost['category'] ) ) // undefined if none selected in multiselect
	$category = array_merge( $category, array_map( 'hootkit_append_negative', $firstpost['category'] ) );
else
	$query_args['offset'] = $fpquery_args['posts_per_page'];
if ( !empty( $category ) )
	$query_args['category'] = implode( ',', $category );

// Skip posts without image
$query_args['meta_query'] = array(
	array(
		'key' => '_thumbnail_id',
		'compare' => 'EXISTS'
	),
);

// Create Query
$query_args = apply_filters( 'hootkit_post_grid_stdquery', $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
$post_grid_query = get_posts( $query_args );


/*** Template Functions ***/
// @todo : Improve template file with proper location for template functions within plugin in respect to theme template management

// Add Pagination
if ( !function_exists( 'hootkit_post_grid_pagination' ) ) :
	function hootkit_post_grid_pagination( $post_grid_query, $query_args ) {
		global $hoot_data;
		if ( !empty( $hoot_data->currentwidget['instance'] ) )
			extract( $hoot_data->currentwidget['instance'], EXTR_SKIP );
		if ( !empty( $viewall ) ) {
			if ( !empty( $category ) && is_array( $category ) && count( $category ) == 1 ) { // If more than 1 cat selected, show blog url
				$base_url = esc_url( get_category_link( $category[0] ) );
			} elseif ( !empty( $category ) && !is_array( $category ) ) { // Pre 1.0.10 compatibility with 'select' type
				$base_url = esc_url( get_category_link( $category ) );
			} else {
				$base_url = ( get_option( 'page_for_posts' ) ) ?
							esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) :
							esc_url( home_url('/') );
			}
			$class = sanitize_html_class( 'view-all-' . $viewall );
			if ( $viewall == 'top' )
				$class .= ( !empty( $title ) ) ? ' view-all-withtitle' : '';
			echo '<div class="view-all ' . $class . '"><a href="' . $base_url . '">' . __( 'View All', 'hootkit' ) . '</a></div>';
		}
	}
endif;
if ( !empty( $viewall ) ) :
	if ( !empty( $viewall ) && $viewall == 'top' ) {
		add_action( 'hootkit_post_grid_start', 'hootkit_post_grid_pagination', 10, 2 );
		remove_action( 'hootkit_post_grid_end', 'hootkit_post_grid_pagination', 10, 2 );
	} elseif ( !empty( $viewall ) && $viewall == 'bottom' ) {
		add_action( 'hootkit_post_grid_end', 'hootkit_post_grid_pagination', 10, 2 );
		remove_action( 'hootkit_post_grid_start', 'hootkit_post_grid_pagination', 10, 2 );
	} else {
		remove_action( 'hootkit_post_grid_start', 'hootkit_post_grid_pagination', 10, 2 );
		remove_action( 'hootkit_post_grid_end', 'hootkit_post_grid_pagination', 10, 2 );
	}
endif;

// Display Grid Function
if ( !function_exists( 'hootkit_post_grid_displayunit' ) ):
function hootkit_post_grid_displayunit( $columns, $postcount, $show_title = true, $gridunit_height = 0, $metadisplay = array(), $factor = 1 ){
				// $img_size = hootkit_thumbnail_size( "column-{$factor}-{$columns}" );
				$img_size = 'hoot-preview-large';
				$img_size = apply_filters( 'hootkit_post_grid_imgsize', $img_size, $columns, $postcount, $factor );
				$default_img_size = apply_filters( 'hoot_notheme_post_grid_imgsize', ( ( $factor == 2 ) ? 'full' : 'thumbnail' ), $columns, $postcount, $factor );
				$gridimg_attr = array( 'style' => '' );
				$thumbnail_size = hootkit_thumbnail_size( $img_size, NULL, $default_img_size );
				$thumbnail_url = get_the_post_thumbnail_url( null, $thumbnail_size );
				if ( $thumbnail_url ) $gridimg_attr['style'] .= "background-image:url(" . esc_url($thumbnail_url) . ");";
				if ( $gridunit_height ) $gridimg_attr['style'] .= 'height:' . esc_attr( $gridunit_height * $factor ) . 'px;';
				?>

				<div <?php echo hoot_get_attr( 'post-gridunit-image', '', $gridimg_attr ) ?>>
					<?php hootkit_post_thumbnail( 'post-gridunit-img', $img_size, false, '', NULL, $default_img_size ); // Redundant, but we use it for SEO (related images) ?>
				</div>

				<div class="post-gridunit-bg"><?php echo '<a href="' . esc_url( get_permalink() ) . '" ' . hoot_get_attr( 'post-gridunit-imglink', 'permalink' ) . '></a>'; ?></div>

				<div class="post-gridunit-content">
					<?php if ( !empty( $show_title ) ) : ?>
						<h4 class="post-gridunit-title"><?php echo '<a href="' . esc_url( get_permalink() ) . '" ' . hoot_get_attr( 'post-gridunit-link', 'permalink' ) . '>';
							the_title();
							echo '</a>'; ?></h4>
					<?php endif; ?>
					<?php
					hootkit_display_meta_info( array(
						'display' => $metadisplay,
						'context' => 'post-gridunit-' . $postcount,
						'editlink' => false,
						'wrapper' => 'div',
						'wrapper_class' => 'post-gridunit-subtitle small',
						'empty' => '',
					) );
					?>
				</div>
				<?php
}
endif;



/*** START TEMPLATE ***/

// Template modification Hook
do_action( 'hootkit_post_grid_wrap', $post_grid_query, $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
?>

<div class="post-grid-widget">

	<?php
	/* Display Title */
	if ( !empty( $title ) )
		echo wp_kses_post( apply_filters( 'hootkit_widget_title', $before_title . $title . $after_title, 'post-grid', $title, $before_title, $after_title ) );

	// Template modification Hook
	do_action( 'hootkit_post_grid_start', $post_grid_query, $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
	?>

	<div class="post-grid-columns">
		<?php
		global $post;
		$postcount = 1;

		/* First Post Grid */

		$factor = ( $columns == 1 || !empty( $firstpost['standard'] ) ) ? '1' : '2';
		$gridunit_attr = array();
		$gridunit_attr['class'] = "post-gridunit hcolumn-{$factor}-{$columns} post-gridunit-size{$factor}";
		$gridunit_attr['data-unitsize'] = $factor;
		$gridunit_attr['data-columns'] = $columns;
		$gridunit_height = ( empty( $unitheight ) ) ? 0 : ( intval( $unitheight ) );
		$gridunit_style = ( $gridunit_height && $factor == 2 ) ? 'style="height:' . esc_attr( $gridunit_height ) . 'px;"' : '';
		$gridslider = ( !empty( $fpquery_args['posts_per_page'] ) && intval( $fpquery_args['posts_per_page'] ) > 1 );
		?>

		<div <?php echo hoot_get_attr( 'post-gridunit', '', $gridunit_attr ) ?> <?php echo $gridunit_style; ?>>

			<?php
			if ( $gridslider ) echo '<div ' . hoot_get_attr( 'post-gridslider', '', 'lightSlider' ) . '>';
			foreach ( $post_firstgrid_query as $post ) :

				setup_postdata( $post );

				$metadisplay = array();
				if ( !empty( $firstpost['author'] ) ) $metadisplay[] = 'author';
				if ( !empty( $firstpost['date'] ) ) $metadisplay[] = 'date';
				if ( !empty( $firstpost['comments'] ) ) $metadisplay[] = 'comments';
				if ( !empty( $firstpost['cats'] ) ) $metadisplay[] = 'cats';
				if ( !empty( $firstpost['tags'] ) ) $metadisplay[] = 'tags';

				if ( $gridslider ) echo '<div class="post-grid-slide">';;
				hootkit_post_grid_displayunit( $columns, $postcount, $show_title, $gridunit_height, $metadisplay, $factor );
				if ( $gridslider ) echo '</div>';

			endforeach;
			if ( $gridslider ) echo '</div>';
			?>

		</div>

		<?php
		$postcount++;
		wp_reset_postdata();

		/* Remaining Post Grids */

		if ( !empty( $query_args['posts_per_page'] ) ): // Custom query was still created if posts_per_page = 0
		foreach ( $post_grid_query as $post ) :

		$factor = '1';
		$gridunit_attr = array();
		$gridunit_attr['class'] = "post-gridunit hcolumn-{$factor}-{$columns} post-gridunit-size{$factor}";
		$gridunit_attr['data-unitsize'] = $factor;
		$gridunit_attr['data-columns'] = $columns;
		$gridunit_height = ( empty( $unitheight ) ) ? 0 : ( intval( $unitheight ) );
		$gridunit_style = ( $gridunit_height && $factor == 2 ) ? 'style="height:' . esc_attr( $gridunit_height ) . 'px;"' : '';
		?>

		<div <?php echo hoot_get_attr( 'post-gridunit', '', $gridunit_attr ) ?> <?php echo $gridunit_style; ?>>

				<?php
				setup_postdata( $post );

				$metadisplay = array();
				if ( !empty( $show_author ) ) $metadisplay[] = 'author';
				if ( !empty( $show_date ) ) $metadisplay[] = 'date';
				if ( !empty( $show_comments ) ) $metadisplay[] = 'comments';
				if ( !empty( $show_cats ) ) $metadisplay[] = 'cats';
				if ( !empty( $show_tags ) ) $metadisplay[] = 'tags';

				hootkit_post_grid_displayunit( $columns, $postcount, $show_title, $gridunit_height, $metadisplay, $factor );

		?>
		</div>

		<?php
		$postcount++;
		endforeach;
		wp_reset_postdata();
		endif;

		echo '<div class="clearfix"></div>';
		?>
	</div>

	<?php
	// Template modification Hook
	do_action( 'hootkit_post_grid_end', $post_grid_query, $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
	?>

</div>