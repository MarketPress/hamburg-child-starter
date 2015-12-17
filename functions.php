<?php
/**
 * Functions and definitions for Hamburg Child.
 *
 * Edit hamburg_child_min_suffix() and hamburg_child_setup() to unlock features.
 *
 * @package    WordPress
 * @subpackage Hamburg_Child
 * @version    12/17/2015
 * @author     marketpress.com
 */


/**
 * Sets up theme defaults, enqeues stylesheet and scripts.
 *
 * @since   09/19/2013
 * @return  void
 */
function hamburg_child_setup() {

	/* The .min suffix for stylesheets and scripts.
	 *
	 * In order to provide a quick start, this child theme by default will load
	 * regular CSS and javascript files (whereas its parent theme loads
	 * minified versions of its stylesheets and scripts by default).
	 *
	 * If you want your child theme to default on minified stylesheets and scripts,
	 * set the following filter:
	 *
	 * if( function_exists( 'hamburg_min_suffix' ) ) {
	 *     add_filter( 'hamburg_child_min_suffix', 'hamburg_min_suffix' );
	 * }
	 *
	 * Don’t forget to actually add applicable .min files to your child theme first!
	 *
	 * You can then temporarily switch back to unminified versions of the same
	 * files by setting the constant SCRIPT_DEBUG to TRUE in your wp-config.php:
	 * define( 'SCRIPT_DEBUG', TRUE );
	 */

	// Loads the child theme's translated strings
	load_child_theme_textdomain( 'theme_hamburg_child_textdomain', get_stylesheet_directory() . '/languages' );

	// Enqueue child theme's styles.css for front-end.
	add_action( 'wp_enqueue_scripts', 'hamburg_child_add_stylesheet' );

	// Uncomment to enqueue child theme's javascript for front-end.
	// add_action( 'wp_enqueue_scripts', 'hamburg_child_add_javascript' );

	// Uncomment to remove yellow color-scheme and add pink.
	// add_filter( get_stylesheet() . '_color_schemes', 'hamburg_child_add_color_scheme' );
}
add_action( 'after_setup_theme', 'hamburg_child_setup' );


/**
 * Enqueues main stylesheet in the front-end.
 *
 * Will load after main parent stylesheet has loaded. To remove that dependency,
 * pass an empty array() instead of array( 'style' ).
 *
 * @since   09/19/2013
 * @hooked  wp_enqueue_scripts
 * @return  void
 */
function hamburg_child_add_stylesheet() {

	// Get file suffix.
	$suffix  = apply_filters( 'hamburg_child_min_suffix', '' );

	// Get theme-data.
	$theme_data = wp_get_theme();

	/** Register CSS style file.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_register_script/
	 */
	wp_register_style(
		'hamburg-child-style',
		get_stylesheet_directory_uri() . '/style' . $suffix . '.css',
		array( 'style' ), // loads after main stylesheet from parent theme Hamburg
		$theme_data->Version,
		'screen'
	);

	// Enqueue child theme CSS.
	wp_enqueue_style( 'hamburg-child-style' );
}


/**
 * Enqueues a sample javascript file in the front-end.
 *
 * Will load after hamburg.js from parent theme Hamburg has loaded.
 * To remove that dependency, pass an empty array() instead of array( 'hamburg-js' ).
 *
 * @since   02/09/2015
 * @hooked  wp_enqueue_scripts
 * @return  void
 */
function hamburg_child_add_javascript() {

	// Get file suffix.
	$suffix  = apply_filters( 'hamburg_child_min_suffix', '' );

	// Get theme-data.
	$theme_data = wp_get_theme();

	/** Register javascript file.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_register_script/
	 */
	wp_register_script(
		'hamburg-child-js',
		get_stylesheet_directory_uri() . '/assets/js/hamburg-child' . $suffix . '.js',
		array( 'hamburg-js' ), // loads after hamburg.js from parent theme Hamburg
		$theme_data->Version,
		TRUE
	);

	// Enqueue child theme javascript.
	wp_enqueue_script( 'hamburg-child-js' );
}


/**
 * Add color scheme to the default color schemes from theme Hamburg.
 * Remove the default color 'yellow' from settings.
 *
 * @since   09/19/2013
 * @hooked  hamburg_color_schemes
 * @param   Array with each color and his data
 * @return  Array with data to each color on Customizer
 */
function hamburg_child_add_color_scheme( $schemes ) {

	// remove the yellow scheme
	unset ( $schemes[ 'yellow' ] );

	// add a new scheme. you can add more the same way
	$schemes[ 'pink' ] = array (
		'background' => 'cc5490',    // background hex color code
		'foreground' => 'fff',       // foreground hex color code
		'label'      => _x( 'Pink', 'Color scheme picker', 'theme_hamburg_child_textdomain' ) // Name im Customizer
	);

	return $schemes;
}
