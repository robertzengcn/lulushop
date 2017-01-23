<?php
/**
 * Stacker Theme Customizer
 *
 * @package Stacker
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function stacker_customize_register( $wp_customize )
{
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// custom handler - textarea
	class stacker_Textarea_Control extends WP_Customize_Control
	{
		public $type = 'textarea';

		public function render_content()
		{
			?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea rows="5"
						  style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
		<?php
		}
	}

}

add_action( 'customize_register', 'stacker_customize_register' );

function stacker_sanitize_menu_position( $value )
{
	if ( !in_array( $value, array( 'left', 'top' ) ) ) {
		$value = 'left';
	}

	return $value;
}

function stacker_sanitize_color_hex( $value )
{
	if ( !preg_match( '/\#[a-fA-F0-9]{6}/', $value ) ) {
		$value = '#f5f5f5';
	}

	return $value;
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function stacker_customize_preview_js()
{
	wp_enqueue_script( 'stacker_customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), '20130524', true );
}

add_action( 'customize_preview_init', 'stacker_customize_preview_js' );

// Custom Backgrounds
function stacker_register_custom_background()
{
	$args = array(
		'default-color' => '#f5f5f5',
		'default-image' => '',
	);

	$args = apply_filters( 'stacker_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		if ( !empty( $args['default-image'] ) )
			define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_theme_support( 'custom-background' );
	}
}

add_action( 'after_setup_theme', 'stacker_register_custom_background' );


function stacker_customizer( $wp_customize )
{


	$wp_customize->add_section( 'stackerfooter', array(
		'title'       => 'Footer Text', // The title of section
		'priority'    => 50,
		'description' => 'Footer Text', // The description of section
	) );

	$wp_customize->add_setting( 'stackerfooter_footer_text', array(
		'default'           => 'Hello world',
		'sanitize_callback' => 'sanitize_text_field',
		// Let everything else default
	) );
	$wp_customize->add_control( 'stackerfooter_footer_text', array(
		// wptuts_welcome_text is a id of setting that this control handles
		'label'   => 'Footer Text',
		// 'type' =>, // Default is "text", define the content type of setting rendering.
		'section' => 'stackerfooter', // id of section to which the setting belongs
		// Let everything else default
	) );


	$wp_customize->add_section( 'homepage_columns', array(
		'title'    => __( 'Home page columns', 'stacker' ),
		'priority' => 50,
	) );

	$wp_customize->add_setting( 'stacker_homepage_columns', array(
		'default'           => '3',
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'stacker_homepage_columns', array(
		'label'    => __( 'Column count for home page', 'stacker' ),
		'section'  => 'homepage_columns',
		'settings' => 'stacker_homepage_columns',
		'type'     => 'select',
		'choices'  => array( 1 => 1, 2 => 2, 3 => 3, 4 => 4 ),
	) );

}

add_action( 'customize_register', 'stacker_customizer', 11 );