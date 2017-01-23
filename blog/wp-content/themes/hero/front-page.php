<?php get_header(); ?>

<div id="home-container">

	<!--slideshow-->
	
	<div id="slider" class="nivoSlider">

<?php for ($i = 1; $i <= 2; $i++) { ?>

			 <img src="<?php if(of_get_option('slider_image'.$i) != NULL){ echo of_get_option('slider_image'.$i);} else echo get_template_directory_uri() . '/images/slide'.$i.'.png' ?>" alt="<?php echo of_get_option('slider_head'.$i); ?>" <?php if(of_get_option('slider_box') != 'off'){ ?> title="<span class='info-title'><?php if(of_get_option('slider_head'.$i) != NULL){ echo of_get_option('slider_head'.$i);} else echo "Professional Business WordPress theme" ?></span><p><?php if(of_get_option('slider_text'.$i) != NULL){ echo of_get_option('slider_text'.$i);} else echo "Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae." ?></p><span class='read-more-slide'> <a href='<?php echo of_get_option('slider_link'.$i); ?>'><?php _e( 'Read More', 'Hero' ); ?></a></span>" <?php } ?> />
			
			<?php } ?>
		
		</div> <!--slideshow end-->

  </div><!--home container end-->

<div class="clear"></div>

<!--welcome-->
	<div class="welcome_container">
<hr />
		<div class="two_third welcome-box">
		
	<h1><?php if(of_get_option('welcome_text') != NULL){ echo of_get_option('welcome_text');} else echo "Write your welcome headline here. Have fun with the Hero theme." ?></h1></div>
	
	<div class="one_third last"><?php if(of_get_option('welcome_button') != NULL){ ?> 
	<a class="button large" href="<?php if(of_get_option('welcome_button_link') != NULL){ echo of_get_option('welcome_button_link');} ?>"><?php echo of_get_option('welcome_button'); ?></a> 
	<?php } else { ?> <a class="button large" href="<?php if(of_get_option('welcome_button_link') != NULL){ echo of_get_option('welcome_button_link');} ?>"> <?php echo "Download Now!" ?></a> <?php } ?></div>
<hr />
</div><!--welcome end--> 
<div class="clear"></div>	
				
		<!--boxes-->
		<div id="box_container">
				
		<?php for ($i = 1; $i <= 3; $i++) { ?>
		
		
				<div class="boxes one_third <?php if ($i == 3) {echo "last";} ?>">
						<div class="box-head">
								
	<a href="<?php echo of_get_option('box_link' . $i); ?>"><img src="<?php if(of_get_option('box_image' . $i) != NULL){ echo of_get_option('box_image' . $i);} else echo get_template_directory_uri() . '/images/box' .$i. '.png' ?>" alt="<?php echo of_get_option('box_head' . $i); ?>" /></a>

					
					</div> <!--box-head close-->
					
				<div class="title-box">						
						
				<div class="title-head"><?php if(of_get_option('box_head' . $i) != NULL){ echo of_get_option('box_head' . $i);} else echo "Box heading" ?></div></div>
					
					<div class="box-content">

				<?php if(of_get_option('box_text' . $i) != NULL){ echo of_get_option('box_text' . $i);} else echo "Nullam posuere felis a lacus tempor eget dignissim arcu adipiscing. Donec est est, rutrum vitae bibendum vel, suscipit non metus." ?>
					
					</div> <!--box-content close-->
					
					
		
		<span class="read-more"><a href="<?php echo of_get_option('box_link' . $i); ?>"><?php _e('Read More' , 'Hero'); ?></a></span>
				
				</div><!--boxes  end-->
				
		<?php } ?>
		
		</div><!--box-container end-->
			
			<div class="clear"></div>
		
		
</div>
<!--wrapper end-->

<?php get_footer(); ?>