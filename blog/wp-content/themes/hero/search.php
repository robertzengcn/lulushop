<?php get_header(); ?>

<div id="subhead_container">

	<div id="subhead_wrapper">
			<div id="subhead">
		
		<h1><?php printf( __( 'Search Results for: %s', 'Hero' ), '' . get_search_query() . '' ); ?></h1>
			
			</div>
			
			
	
	<div class="clear"></div>	
			
		</div>
			<hr />
	</div>

	<!--inside container-->
	<div id="content_container">
		
		<div id="content">
		
			<!-- left-col-->
			<div id="left-col">

			<?php if ( have_posts() ) : ?>
				
				<?php get_template_part( 'loop', 'search' ); ?>
<?php else : ?>

					<div class="post-head-notfound">
					
						<h1><?php _e( 'Nothing Found', 'Hero' ); ?></h1>
					
					</div><!--head end-->
					
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'Hero' ); ?></p>
					
<?php endif; ?>

</div> <!--left-col end-->

<?php get_sidebar(); ?>

	</div> 
</div> <!--content end-->
	
</div>
<!--wrapper end-->

<?php get_footer(); ?>
