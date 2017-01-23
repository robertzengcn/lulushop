<?php
/**
 * @package Stacker
 */
?>

<div <?php post_class( 'inside item' ); ?>>
	<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'post-page', array( 'class' => 'featured-image' ) ); ?></a>
	<div class="commentcount">
			<span><?php comments_number( '0', '1', '%' ); ?></span>
	</div>
	<h2 class="itemtitle"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

	<div class="itemdate"><a href="<?php the_permalink(); ?>"><?php stacker_posted_on(); ?></a></div>
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
	<div id="content">
		<?php
			wp_link_pages();
			the_content();
			posts_nav_link( ' &#183; ', 'previous page', 'next page' );
			edit_post_link( __( 'Edit', 'stacker' ), '<span class="edit-link">', '</span>' );
		?>
		<div id="bottommeta">
			<?php the_tags( __( 'Tags: ', 'stacker' ), '  ', '' ); ?>
		</div>
	</div>