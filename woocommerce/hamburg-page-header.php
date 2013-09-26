<?php
/**
 * Template for the page header of shop archive pages.
 *
 * This will contain the page title (set by option),
 * an optionals archive description and a dropdown filter
 * including result count.
 *
 * @package    Hamburg
 * @subpackage Templateparts
 */
?>
	<header class="archive-header">
		<div class="archive-title">
			<h1 class="page-title">
			<?php
			if ( apply_filters( 'woocommerce_show_page_title', true ) )
				woocommerce_page_title();
			?>
			</h1>
		<?php
			woocommerce_result_count();
			woocommerce_catalog_ordering();
		?>
		</div>
	</header>