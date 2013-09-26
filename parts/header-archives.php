<?php
/**
 * Header for archives.
 *
 * @package    Hamburg
 * @subpackage Templateparts
 */

if ( '' == single_term_title('', false) )
	return;
?>
	<div class="term-description">
		<header class="row">
			<?php
			if(
				! function_exists( 'is_woocommerce' ) ||
				( function_exists( 'is_woocommerce' ) && ! is_woocommerce() )
				) :
			?>
			<h2 class="page-title">
			<?php
			/* Category or tag title */
			single_term_title();
			?>
			</h2>
			<?php
			endif;

			/* Category or tag description */
			if ( '' !== term_description() ) :
			?>
			<div class="page-description"><?php
				echo wpautop( term_description() );
			?></div>
			<?php
			endif;
			?>
		</header>
	</div>