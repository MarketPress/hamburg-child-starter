<?php
/**
 * Special configuration for the plugin WooCommerce German Market.
 *
 * @link http://marketpress.com/product/woocommerce-german-market/
 */

// not active
if ( ! class_exists( 'WGM_Template' ) )
	return;

// Remove German Market frontend styles.
add_action( 'wp_enqueue_scripts', 'hamburg_wgm_enqueue_scripts' );

function hamburg_wgm_enqueue_scripts() {
	wp_dequeue_style( 'woocommerce-de_frontend_styles' );
}

// German Market filters.
remove_filter( 'woocommerce_single_product_summary',	 array( 'WGM_Template', 'woocommerce_de_price_with_tax_hint_single' ), 7 );
remove_filter( 'woocommerce_single_product_summary',	 array( 'WGM_Template', 'add_template_loop_shop' ), 11 );
remove_filter( 'woocommerce_single_product_summary',	 array( 'WGM_Template', 'show_extra_costs_eu' ), 11 );
remove_filter( 'woocommerce_single_product_summary',	 'woocommerce_template_single_price', 	10 );
remove_filter( 'woocommerce_after_shop_loop_item',		 array( 'WGM_Template', 'woocommerce_de_after_shop_loop_item' ) );
remove_filter( 'woocommerce_after_shop_loop_item_title', array( 'WGM_Template', 'woocommerce_de_price_with_tax_hint_loop' ), 5 );

add_filter( 'woocommerce_single_product_summary',		 'hamburg_wc_open_price', 10 );
add_filter( 'woocommerce_single_product_summary',		 array( 'WGM_Template', 'woocommerce_de_price_with_tax_hint_single' ), 20 );
add_filter( 'woocommerce_single_product_summary',		 'hamburg_wc_close_price', 21 );

add_filter( 'woocommerce_single_product_summary',		 array( 'WGM_Template', 'add_template_loop_shop' ), 30 );
add_filter( 'woocommerce_single_product_summary',		 array( 'WGM_Template', 'show_extra_costs_eu' ), 30 );
add_filter( 'woocommerce_after_shop_loop_item_title',	 'hamburg_wgm_price_with_tax_hint_loop', 5  );
add_filter( 'woocommerce_after_shop_loop_item',			 array( 'WGM_Template', 'woocommerce_de_after_shop_loop_item' ), 5 );


/**
 * Wrapper for tax hint.
 *
 * @return void
 */
function hamburg_wc_open_price() {
	echo '<div class="price-de-tax-extra-costs">';
}
/**
 * Wrapper for tax hint.
 *
 * @return void
 */
function hamburg_wc_close_price() {
	echo "</div>";
}

/**
 * print tax hint after prices in loop
 *
 * @uses globals $product, remove_action
 * @gloabl $product
 * @wp-hook woocommerce_after_shop_loop_item_title
 * @author jj
 * @return void
*/
function hamburg_wgm_price_with_tax_hint_loop() {

	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );

	global $product;

	$price_per_unit_data = WGM_Template::get_price_per_unit_data( $product );
	$price_html          = $product->get_price_html();

	if ( ! $price_html )
		return;
	?>
	<div class="price">
	<?php
		echo $price_html;

		WGM_Template::text_including_tax( $product );

		if ( ! empty( $price_per_unit_data ) )
			printf(
				'<p class="price-per-unit">%s %s / %s %s</p>',
				$price_per_unit_data[ 'price_per_unit' ],
				get_woocommerce_currency_symbol(),
				$price_per_unit_data[ 'mult'],
				$price_per_unit_data[ 'unit' ]
			);
	?>
	</div>
	<?php
}

/**
 * Show delivery costs.
 *
 * @global $product
 * @return void
 */
function hamburg_wgm_show_free_shipping_loop() {

	global $product;

	// display is not enabled at all
	if ( 'on' !== get_option( WGM_Helper::get_wgm_option( 'woocommerce_de_show_shipping_fee_overview' ) ) )
		return;

	// display is not enabled for this product
	if ( 'on' === maybe_unserialize( get_post_meta( get_the_ID(), '_suppress_shipping_notice', TRUE ) ) )
		return;

	$wgm_textdomain         = Woocommerce_German_Market::get_textdomain();
	?>
	<span class="woocommerce_de_versandkosten">
		<?php
		if ( get_option( 'woocommerce_de_show_free_shipping' ) === 'on' ):
			_e( 'versandkostenfrei', $wgm_textdomain );
		else:
		?>
			<a class="versandkosten" href="<?php
				echo esc_url( get_permalink( get_option( WGM_Helper::get_wgm_option( 'versandkosten' ) ) ) );
				?>">
				<?php
				_e( 'zzgl.', $wgm_textdomain );
				_e( 'Versand', $wgm_textdomain );
				?>
			</a>
		<?php
		endif;
		?>
	</span>
<?php
}