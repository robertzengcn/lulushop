<?php
/**
 * @package Stacker
 */
?>

<div <?php post_class( 'item' ); ?>>

	<a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'post-thumb', array( 'class' => '' ) );
		} else {
			?>
			<img src="<?php echo esc_url( get_template_directory_uri() ) ?>/img/default.png"
				 alt="<?php the_title(); ?>"/>
		<?php } ?></a>

	<div class="commentcount">
			<span><?php comments_number( '0', '1', '%' ); ?></span>
	</div>
	<h2 class="itemtitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

	<div class="itemdate"><a href="<?php the_permalink(); ?>"><?php stacker_posted_on() ?></a></div>
	<div class="itemcat">
		<?php
		$categories = get_the_category();
		if ( !empty( $categories ) ) {
			foreach ( $categories as $index => $category ) {
				echo '<a href="' . get_category_link( $category ) . '">' . $category->name . '</a>' . ( $index !== count( $categories ) - 1 ? ' / ' : '' );
			}
		}
		?>
	</div>
</div><!--End Post -->