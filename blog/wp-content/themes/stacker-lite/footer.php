<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Stacker
 */
?>
<div id="footer">
	<div class="wrapper">
		<div id="footerwidgets">
			<?php /* Widgetised Area */
			if (!function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 'Footer' )) ?>

		</div>
		<!-- End Footer Widgets-->
		<?php do_action( 'stacker_credits' ); ?>
		<div id="footercredits">
			<h3 class="footer-title"><a href="#">Stacker</a></h3>

			<div class="footertext">
				<p><?php echo esc_html( get_theme_mod( 'stackerfooter_footer_text' ) ); ?></p>

				<p>
				</p>
			</div>
		</div>
		<?php wp_footer(); ?>
	</div>
	<!-- End Wrapper -->
</div><!-- End Footer -->

</body>
</html>