<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Stacker
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function stacker_jetpack_setup()
{
	add_theme_support( 'infinite-scroll', array(
		'type'           => 'scroll',
		'footer_widgets' => array( 'stacker-footer-1' ),
		'container'      => 'scroll-wrapper',
		'posts_per_page' => 10,
		'footer'         => 'footer'
	) );
}

add_action( 'after_setup_theme', 'stacker_jetpack_setup' );
