<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till content wrapper
 *
 * @package Stacker
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php
	wp_head();
	echo stacker_load_homepage_column_count();
	?>
</head>

<body <?php body_class(); ?>>
<div id="cssmenu" class="align-center">
	<?php
	wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false,
			'items_wrap'     => '<ul>%3$s</ul>',
			'depth'          => 0,
			'fallback_cb'    => 'stacker_fallback_menu',
		)
	);
	?>
</div>
<div id="header">
<div id="sitebranding">
<?php if ( function_exists( 'has_site_logo' ) && has_site_logo() ) : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<img src="<?php echo esc_url( get_site_logo( 'url' ) ); ?>" class="site-logo" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
		</a>
	<?php endif; // End site logo check. ?>
	<h1 class="sitetitle">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
			   title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
			   rel="home"><?php bloginfo( 'name' ); ?></a>
	</h1>

	<div class="tagline"><?php bloginfo( 'description' ); ?></div>
	<div id="menu-social" class="menu">
		<?php get_template_part( 'menu', 'social' ); ?>
	</div>
    </div><!--End Site Branding -->
</div>
<!--End Header -->