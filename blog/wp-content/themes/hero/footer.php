	<!--footer-->
	<div class="clear"></div>
		
		<div id="footer">
		<hr />
	<!--footer container--><div id="footer-container">
		
		<div id="footer-widget">
			
			<?php
			/* A sidebar in the footer? Yep. You can can customize
			 * your footer with four columns of widgets.
			 */
			get_sidebar( 'footer' );
			?>
			
			</div><!--footer widget end-->
			
			<div id="footer-info">		
			
			<div id="copyright"><?php _e( 'Copyright', 'Hero' ); ?> <?php echo date( 'Y' ); ?> <?php echo of_get_option('footer_cr'); ?> |<a href="http://www.timelypower.com/organ/283.html">电力设计院</a> </div>
			
			<div id="follow-box"><p><?php _e( 'Follow us:', 'Hero' ); ?></p>
	
		<?php if (of_get_option('footer_youtube') != '' ) { ?><a href="<?php echo of_get_option('footer_youtube'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/youtube.png" alt="Youtube" /></a> <?php }?>
		<?php if (of_get_option('footer_twitter') != '' ) { ?><a href="<?php echo of_get_option('footer_twitter'); ?> "><img src="<?php echo get_template_directory_uri(); ?>/images/Twitter.png" alt="Twitter" /></a><?php }?>
		<?php if (of_get_option('footer_facebook') != '' ) { ?><a href="<?php echo of_get_option('footer_facebook'); ?> "><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" alt="facebook" /></a><?php }?>
	
	</div>
					
			</div><!--footer info end-->
			
		</div><!-- footer container-->
		
	<div class="clear"></div>		
			
	</div>
	
	<?php wp_footer(); ?>

</body>

</html>