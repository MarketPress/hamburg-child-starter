<?php
/**
 * Functions and definitions for Hamburg Child.
 *
 * @package    WordPress
 * @subpackage Hamburg_Child
 * @version    09/19/2013
 * @author     marketpress.com
 */


/**
 * Sets up theme defaults and registers support for various WordPress features
 * of Hamburg Child Theme.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support for post thumbnails.
 *
 * @since   09/19/2013
 * @return  void
 */
function hamburg_child_setup() {

	// Loads the child theme's translated strings
	load_child_theme_textdomain( 'theme_hamburg_child_textdomain', get_stylesheet_directory() . '/languages' );

	// Enqueue child theme's styles.css for front-end.
	add_action( 'wp_enqueue_scripts', 'hamburg_child_add_stylesheets' );

	// Uncomment to remove yellow color-scheme and add pink.
	// add_filter( get_stylesheet() . '_color_schemes', 'hamburg_child_add_color_scheme' );

	// Adds a custom footer line.
	add_filter( 'hamburg_site_footer_info', 'hamburg_child_custom_footer_text' );
}
add_action( 'after_setup_theme', 'hamburg_child_setup' );


/**
 * Enqueue my styles for front-end.
 * Also usable for scripts
 *
 * @since   09/19/2013
 * @return  void
 */
function hamburg_child_add_stylesheets() {

	// Uncomment to only load stylesheet when color-scheme pink is active.
	// if ( 'pink' !== get_theme_mod( 'color_scheme' ) )
	// 	return NULL;

	/**
	 * Suffix for minified script/stylesheet versions.
	 *
	 * Adds a conditional ".min" suffix to the file name
	 * when SCRIPT_DEBUG is NOT set to TRUE.
	 */
	$suffix  = class_exists( 'WooCommerce' ) ? '.plus.woo' : '';

	/**
	 * The .min suffix for stylesheets and scripts.
	 *
	 * In order to provide a quick start, this child theme by default will load
	 * regular style.css (whereas its parent theme Hamburg loads minified
	 * versions of its stylesheets and scripts by default).
	 *
	 * If you want your child theme to default on minified stylesheets as well,
	 * just uncomment line 72.
	 * You can then temporarily switch back to unminified versions of the same
	 * files by setting the constant SCRIPT_DEBUG to TRUE in your wp-config.php:
	 * define( 'SCRIPT_DEBUG', TRUE );
	 */

	// Uncomment to load minified stylesheet by default
	// $suffix .= defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	/**
	 * Register CSS style file.
	 *
	 * @param string $handle Name of the stylesheet.
	 * @param string|bool $src Path to the stylesheet from the root directory of WordPress. Example: '/assets/style.css'.
	 * @param array $deps Array of handles of any stylesheet that this stylesheet depends on.
	 *  (Stylesheets that must be loaded before this stylesheet.) Pass an empty array if there are no dependencies.
	 * @param string|bool $ver String specifying the stylesheet version number. Set to null to disable.
	 *  Used to ensure that the correct version is sent to the client regardless of caching.
	 * @param string $media The media for which this stylesheet has been defined.
	 */
	wp_register_style(
		'hamburg_child_style',
		get_stylesheet_directory_uri() . '/style' . $suffix . '.css',
		array(),
		'20130919',
		'screen'
	);

	// Enqueue a CSS style file
	wp_enqueue_style( 'hamburg_child_style' );
}


/**
 * Add color scheme to the default color schemes from theme Hamburg.
 * Remove the default color 'yellow' from settings.
 *
 * @since   09/19/2013
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


/**
 * Replace Hamburg theme footer text with custom text.
 *
 * @since 10/01/2013
 * @return string
 */
function hamburg_child_custom_footer_text() {
    return sprintf(
    		'<p class="site-info">Custom footer here, including a <a href="%s" rel="nofollow">link</a>. (Edit this line in functions.php.)</p>',
    		home_url( '/' )
    		);
}
