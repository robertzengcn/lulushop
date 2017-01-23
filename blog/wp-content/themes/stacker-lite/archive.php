<?php
/**
 * The template for displaying Archive pages.
 * @package stacker
 */

get_header(); ?>
<?php if ( have_posts() ) : ?>

	<div class="demo-wrap">
		<div class="wrapper">
			<h2 class="archive-title">
				<?php
				if ( is_category() ) :
					single_cat_title();

				elseif ( is_tag() ) :
					single_tag_title();

				elseif ( is_author() ) :
					printf( __( 'Author: %s', 'stacker' ), '<span class="vcard">' . get_the_author() . '</span>' );

				elseif ( is_day() ) :
					printf( __( 'Day: %s', 'stacker' ), '<span>' . get_the_date() . '</span>' );

				elseif ( is_month() ) :
					printf( __( 'Month: %s', 'stacker' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'stacker' ) ) . '</span>' );

				elseif ( is_year() ) :
					printf( __( 'Year: %s', 'stacker' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'stacker' ) ) . '</span>' );
				else :
					_e( 'Archives', 'stacker' );

				endif;
				?>
			</h2>

			<div class="masonry" id="scroll-wrapper">
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
					?>
				<?php endwhile; ?>
			</div>
			<div class="pagination">
				<?php
				// use Jetpack infinite scroll, fallback to default navigation
				if ( !class_exists( 'The_Neverending_Home_Page' ) ) {
					stacker_pagination();
				} else {
					//echo '<div id="infinite-handle" class="visible"><span>' . __( 'Older posts', 'stacker' ) . '</span></div>';
				}
				?>
			</div>
		</div>
	</div>
<?php else : ?>
	<?php get_template_part( 'content', 'none' ); ?>
<?php endif; ?>
<?php get_footer(); ?>