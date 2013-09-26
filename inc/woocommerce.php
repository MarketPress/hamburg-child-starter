<?php
/**
 * Configuration for WooCommerce
 */
if ( ! class_exists( 'Woocommerce' ) )
	return;

/**
 * Add WooCommerce theme support.
 *
 * @link http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 */
add_theme_support( 'woocommerce' );

/**
 * Unset WooCommerce default stylesheet.
 *
 * @link http://docs.woothemes.com/document/css-structure/
 */
define( 'WOOCOMMERCE_USE_CSS', FALSE );

// Remove WooCommerce karma.
remove_action( 'woocommerce_before_shop_loop', 				'woocommerce_result_count', 			20 );
remove_action( 'woocommerce_before_shop_loop', 				'woocommerce_catalog_ordering',			30 );
remove_action( 'woocommerce_before_main_content', 			'woocommerce_breadcrumb',				20 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash',	10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images',		20 );
remove_action( 'woocommerce_single_product_summary',		'woocommerce_template_single_title',	5  );
remove_action( 'woocommerce_single_product_summary',		'woocommerce_template_single_excerpt',	20 );
remove_action( 'woocommerce_single_product_summary',		'woocommerce_template_single_meta',		40 );
remove_action( 'woocommerce_single_product_summary',		'woocommerce_template_single_sharing',	50 );
remove_action( 'woocommerce_after_shop_loop_item_title',	'woocommerce_template_loop_rating', 	5  );
remove_action( 'wp_footer',									'woocommerce_demo_store'				   );

// Add beauty.
add_action( 'wp_print_styles',								'hamburg_wc_styles' 						);
add_filter( 'loop_shop_per_page', 							'hamburg_wc_loop_shop_per_page' 			);
add_filter( 'woocommerce_breadcrumb_defaults',				'hamburg_wc_breadcrumb_defaults'			);
add_filter( 'woocommerce_checkout_fields',					'hamburg_wc_sanitize_form_fields'			);
add_filter( 'woocommerce_shipping_fields',					'hamburg_wc_sanitize_form_fields'			);
add_filter( 'get_product_search_form',						'hamburg_wc_search_form'					);
add_action( 'woocommerce_share',							'hamburg_social_sharing_bar' 				);
add_filter( 'add_to_cart_fragments', 						'hamburg_add_mini_cart_to_woocommerce_fragment'	);
add_action( 'woocommerce_after_shop_loop_item_title',		'woocommerce_template_loop_rating', 	11  );

/**
 * Adjust posts per page value
 *
 * @wp-hook loop_shop_per_page
 * @return  int
 */
function hamburg_wc_loop_shop_per_page() {

	return is_product_category() ? 9 : 8;
}

/**
 * Replace Woo search form.
 *
 * @wp-hook get_product_search_form
 * @return  string
 */
function hamburg_wc_search_form() {

	ob_start();
		woocommerce_get_template_part( 'hamburg', 'product-searchform' );
		$form = ob_get_contents();
	ob_end_clean();

	return $form;
}

/**
 * Improve checkout fields.
 *
 * @wp-hook woocommerce_checkout_fields
 * @wp-hook woocommerce_shipping_fields
 * @param   array $fields
 * @return  array
 */
function hamburg_wc_sanitize_form_fields( $fields ) {

	$keys = array ( 'billing', 'shipping', 'order', 'account' );

	foreach ( $keys as $key ) {

		if ( ! isset ( $fields[ $key ] ) )
			continue;

		foreach ( $fields[ $key ] as $key => &$field ) {

			$field['class'] = empty ( $field['class'] ) ? array() : $field['class'];

 			// Add class for select field container
			if (
				in_array( 'update_totals_on_change', $field['class'] )
				&& 'yes' == get_option( 'woocommerce_enable_chosen' )
				) {
				array_push( $field['class'], 'has-chzn' );
			} elseif (
				in_array( 'update_totals_on_change', $field['class'] )
			) {
				array_push( $field['class'], 'no-chzn' );
			}
		}
	}

	return $fields;
}


// Replace product thumbnails in loop.
if ( ! function_exists( 'woocommerce_template_loop_product_thumbnail' ) ) :

	/**
	 * Get the product thumbnail for the loop.
	 *
	 * @return void
	 */
	function woocommerce_template_loop_product_thumbnail() {
		echo '<figure class="entry-image">' . woocommerce_get_product_thumbnail() . '</figure>';
	}
endif;


// Replace term thumbnails
if ( ! function_exists( 'woocommerce_subcategory_thumbnail' ) ) {
	/**
	 * Show subcategory thumbnails.
	 *
	 * @global $woocommerce
	 * @param mixed $category
	 * @return void
	 */
	function woocommerce_subcategory_thumbnail( $category ) {

		global $woocommerce;

		$small_thumbnail_size = apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' );
		$dimensions           = $woocommerce->get_image_size( $small_thumbnail_size );
		$thumbnail_id         = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', TRUE );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size );
			$image = $image[0];
		} else {
			$image = woocommerce_placeholder_img_src();
		}

		if ( ! $image )
			return FALSE;

		$output  = '<figure class="entry-image"><img src="' . $image . '" ';
		$output .= 'alt="' . $category->name . '" ';
		$output .= 'width="' . $dimensions['width'] . '" ';
		$output .= 'height="' . $dimensions['height'] . '" /></figure>';

		echo $output;
	}
}

/**
 * Adjust breadcrumbs.
 *
 * @return array
 */
function hamburg_wc_breadcrumb_defaults() {
	$seperator = _x(
		'<span class="sep"><span>/</span></span>',
		'WooCommerce breadcrumbs seperator',
		'theme_hamburg_textdomain'
	);

	$args = array (
		'delimiter'   => $seperator,
		'wrap_before' => '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb">',
		'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
		'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' )
	);

	return $args;
}


/**
 * Remove obsolete WooCommerce styles.
 *
 * @return void
 */
function hamburg_wc_styles() {
	wp_deregister_style( 'woocommerce_prettyPhoto_css' );
}

/**
 * WooCommerce cart shortcode handler.
 *
 * @global $woocommerce
 * @return string
 */
function hamburg_wc_mini_cart( $atts ) {

	global $woocommerce;

	// Get cart contents
	$items = $woocommerce->cart->get_cart();

	// Sum quantity of each item
	$count = 0;
	foreach ( $items as $item ) {
		$count += $item['quantity'];
	}

	if ( 1 > $count )
		return;

	extract(
		shortcode_atts(
			array(
				'before'    => '',
				'after'     => '',
				'separator' => ''
			),
			$atts
		)
	);

	$output = $woocommerce->cart->get_cart_total() . $separator . $count;

	return $before . $output . $after;
}

/**
 * Adds mini cart markup to the woocommerce ajax fragments
 *
 * @global $woocommerce
 * @param  array $fragments
 * @return array $fragments
 */
function hamburg_add_mini_cart_to_woocommerce_fragment( $fragments ) {

	global $woocommerce;

	$fragments['hamburg_mini_cart'] = hamburg_wc_mini_cart(
		array(
			'before'    => '<div class="mini-cart">
							<a href="' . $woocommerce->cart->get_cart_url() . '">',
			'after'     => '</a></div>',
			'separator' => '<i class="icon-shopping-cart"></i>'
		)
	);

	return $fragments;
}

/**
 * List best selling products on sale.
 *
 * @global $woocommerce_loop
 * @param  array $atts
 * @return string
 */
function hamburg_best_selling_products( $atts ){
	global $woocommerce_loop;

	extract(
		shortcode_atts(
				array(
					'post_per_page'		 	=> '12',
					'ignore_sticky_posts'	=> 1,
					'before'				=> '',
					'after'					=> '',
				),
				$atts
		)
	);

	$args = array(
		'post_type' 			=> 'product',
		'post_status' 			=> 'publish',
		'ignore_sticky_posts'	=> $ignore_sticky_posts,
		'posts_per_page' 		=> $post_per_page,
		'orderby' 		 		=> 'meta_value_num',
		'meta_query' 			=> array(
			array(
				'key' => '_visibility',
				'value' => array( 'catalog', 'visible' )
			)
		)
	);

	$products = new WP_Query( $args );

	$start = woocommerce_product_loop_start( FALSE );

	if ( $products->have_posts() ) :

		ob_start();

		while ( $products->have_posts() ) :
			$products->the_post();

			woocommerce_get_template_part( 'content', 'product-related' );

		endwhile; // end of the loop.

		$content = ob_get_clean();

		wp_reset_query();

	endif;

	$end = woocommerce_product_loop_end( FALSE );

	return $before . $start . $content . $end . $after;
}


add_filter( 'hamburg_content_area_class', 'hamburg_wc_content_area_class' );

function hamburg_wc_content_area_class() {

	return is_account_page() ? ' full-width' : '';
}

/**
 * Turn product rating into width value.
 *
 * @return int
 */
function hamburg_wc_average_rating_to_width( $value ) {

	return round( ( $value * 2 ), 0, PHP_ROUND_HALF_EVEN ) * 10;
}


/**
 * Returns the product rating in html format.
 *
 * @access public
 * @param  string $rating (default: '')
 * @uses   hamburg_wc_average_rating_to_width()
 * @return string
 */
function hamburg_wc_get_rating_html( $product, $rating = null ) {

	if ( ! is_numeric( $rating ) )
		$rating = $product->get_average_rating();

	if ( $rating <= 0 )
		return;

	$rating_html  = '<div class="star-rating" title="' . sprintf( __( 'Rated %s out of 5', 'woocommerce' ), $rating ) . '">';
	$rating_html .= '<span style="width:' . hamburg_wc_average_rating_to_width( $rating ) . '%">';
	$rating_html .= '<strong class="rating">' . $rating . '</strong> ' . __( 'out of 5', 'woocommerce' );
	$rating_html .= '</span></div>';

	return $rating_html;
}



/**
 * …
 *
 * @access public
 * @return void
 */
function hamburg_wc_category_image_uri() {
    if ( ! is_product_category() )
    	return;

	global $wp_query;
	$cat = $wp_query->get_queried_object();
	$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
	$image = wp_get_attachment_image_src( $thumbnail_id, 'shop_thumbnail' );
	if ( $image ) {
	    echo '<img src="' . $image[0] . '" alt="" />';
	}
}