<?php
/**
 * Shortcode Post
 * @todo 	Improve shortcode functionality
 */
function project_shortcode() {
	$args = array(
		'post_type'			=> 'projects',
		'posts_per_page'	=> 3
	);
	$query = new WP_Query( $args );

	if( $query->have_posts() ) :
		ob_start();
	?>

	<div class="main-wrapper">
		<div id="posts_list">

			<?php while( $query->have_posts() ) : $query->the_post(); ?>
				<article class="single-article"><?php the_title(); ?></article>
			<?php endwhile; ?>

		</div>

		<a class="load_more" data-nonce="<?php echo wp_create_nonce('load_posts') ?>" href="javascript:;">Load more</a>
	</div>
<?php
	return ob_get_clean();
	endif;
}
add_shortcode('projects', 'project_shortcode');


