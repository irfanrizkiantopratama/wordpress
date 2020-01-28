<?php
$speed = intval( $speed );
$speed = ( empty( $speed ) ) ? 5*0.01 : $speed*0.01;
$thumbheight = ( empty( $thumbheight ) ) ? 0 : intval( $thumbheight );
$width = intval( $width );
$inlinestyle = $widgetstyle = $styleclass = '';
if ( $background || $fontcolor ) {
	$styleclass = 'ticker-userstyle';
	$widgetstyle = ' style="';
	$widgetstyle .= ( $background ) ? 'background:' . sanitize_hex_color( $background ) . ';' : '';
	$widgetstyle .= ( $fontcolor ) ? 'color:' . sanitize_hex_color( $fontcolor ) . ';' : '';
	$widgetstyle .= '" ';
}
if ( $width ) {
	$styleclass = 'ticker-userstyle';
	$inlinestyle = ' style="width:' . $width . 'px;"';
}
$styleclass .= ( $background ) ? ' ticker-withbg' : '';

// Create a custom WP Query
$count = ( empty( $count ) ) ? 0 : intval( $count );
$query_args = array();
$query_args['posts_per_page'] = ( empty( $count ) ) ? 10 : $count;
if ( isset( $category ) && is_string( $category ) ) $category = array( $category ); // Pre 1.0.10 compatibility with 'select' type
$exccategory = ( !empty( $exccategory ) && is_array( $exccategory ) ) ? array_map( 'hootkit_append_negative', $exccategory ) : array(); // undefined if none selected in multiselect
$category = ( !empty( $category ) && is_array( $category ) ) ? array_merge( $category, $exccategory) : $exccategory; // undefined if none selected in multiselect
if ( !empty( $category ) )
	$query_args['category'] = implode( ',', $category );
$query_args = apply_filters( 'hootkit_ticker_posts_query', $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
$ticker_posts_query = get_posts( $query_args );

// Template modification Hook
do_action( 'hootkit_ticker_posts_wrap', $ticker_posts_query, $query_args, ( ( !isset( $instance ) ) ? array() : $instance ) );
?>

<div class="ticker-widget <?php echo $styleclass; ?>" <?php echo $widgetstyle;?>><?php

	/* Display Title */
	if ( !empty( $title ) )
		echo wp_kses_post( apply_filters( 'hootkit_widget_ticker_title', '<div class="ticker-title">' . $title . '</div>', $title, 'ticker-posts' ) );

	/* Start Ticker Message Box */
	?>
	<div class="ticker-msg-box" <?php echo $inlinestyle;?> data-speed='<?php echo $speed; ?>'>
		<div class="ticker-msgs">
			<?php
			global $post;
			foreach ( $ticker_posts_query as $post ) :

				// Init
				setup_postdata( $post );
				$visual = ( has_post_thumbnail() ) ? 1 : 0;
				$imgclass = ( $visual ) ? 'visual-img' : 'visual-none';
				$img_size = apply_filters( 'hootkit_ticker_posts_imgsize', 'thumbnail' );
				?>

				<div class="ticker-msg <?php echo $imgclass; ?>">
					<?php
					if ( $visual ) :
						$thumbnail_url = get_the_post_thumbnail_url( null, $img_size );
						$msgimg_attr['style'] = "background-image:url(" . esc_url($thumbnail_url) . ");";
						if ( !empty( $thumbheight ) )
							$msgimg_attr['style'] .= 'height:' . intval( $thumbheight ) . 'px;width:' . intval( $thumbheight ) * 1.5 . 'px;'
						?>
						<div <?php echo hoot_get_attr( 'ticker-post-image', '', $msgimg_attr ) ?>>
							<?php hootkit_post_thumbnail( 'ticker-post-img', $img_size, false, esc_url( get_permalink( $post->ID ) ), NULL, 'thumbnail' ); ?>
						</div>
						<?php
					endif;
					echo '<div class="ticker-post-title"><a href="' . esc_url( get_permalink() ) . '" ' . hoot_get_attr( 'posts-listunit-link', 'permalink' ) . '>';
						the_title();
					echo '</a></div>'; ?>
				</div>

				<?php
			endforeach;
			wp_reset_postdata();
			?>
		</div>
	</div>

</div>