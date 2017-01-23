<?php
/**
 * @package Stacker
 */
?>

<div class="masonryinside">
	<div class="wrapper">
		<h2 class="search-title">
			<?php _e( 'That page can&rsquo;t be found.', 'stacker' ); ?>
		</h2>

		<div class="item inside searchresult">
			<p>
				<?php _e( 'It looks like nothing was found at this location. Please try searching for the content', 'stacker' ); ?>
			</p>
			<?php get_search_form(); ?>
			
		</div>
	</div>
</div>