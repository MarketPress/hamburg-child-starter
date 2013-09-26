<?php
/**
 * Render image attachments.
 *
 * @package    Hamburg
 * @subpackage Templates
 */

/**
 * Get site header.
 */
get_header();
?>
	<div class="site-main">
		<div class="row">
			<div id="primary" class="content-area full-width">
				<?php
				/**
				 * Main Content.
				 *
				 * The <main> element is used to enclose the main content
				 * ("main" translating to the central topic of a document).
				 * ARIA landmark role "main" is recommended for the <main>
				 * element until user agents implement role mapping.
				 */
				?>
				<main id="content" class="site-content" role="main">
				<?php

				while ( have_posts() ) :

					/* Put some food on the table. */
					the_post();

					/**
					 * Get all the attached images
					 */
					$attachments = array_values(
						get_children(
							array(
								'post_parent'   => $post->post_parent,
								'post_status'   => 'inherit',
								'post_type'     => 'attachment',
								'post_mime_type'=> 'image',
								'order'         => 'ASC',
								'orderby'       => 'menu_order ID'
							)
						)
					);
					$orientation = hamburg_image_orientation( $post->ID );
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( $orientation ); ?>>
						<div class="entry">
						<?php
						/**
						 * Include entry header.
						 */
						get_template_part( 'parts/navigation', 'images' );
						?>
							<div class="entry-attachment">
								<figure class="attachment">
									<?php
									/**
									 * Grab the IDs of all the image attachments in a gallery,
									 * so we can get the URL of the next adjacent image in a gallery,
									 * or the first image (if we're looking at the last image in a gallery),
									 * or, in a gallery of one, just the link to that image file.
									 */
									foreach ( $attachments as $k => $attachment ) {
										if ( $attachment->ID == $post->ID )
											break;
									}

									$k++;
									// If there is more than 1 attachment in a gallery
									if ( count( $attachments ) > 1 ) {
										if ( isset( $attachments[ $k ] ) )
											// get the URL of the next image attachment
											$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
										else
											// or get the URL of the first image attachment
											$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
									} else {
										// or, if there's only 1 image, get the URL of the image
										$next_attachment_url = wp_get_attachment_url();
									}

									/**
									 * Set content_width to full width temporarily
									 * in order to display a full-width image.
									 *
									 */
									global $content_width;

									// Store original variable content_width
									$hamburg_content_width = $content_width;

									$content_width = 1024;
									$image_width   = hamburg_featured_image_size( $post->ID );
									?>
									<a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php

										echo wp_get_attachment_image( $post->ID, $image_width );

										// Reset content_width to original
										$content_width = $hamburg_content_width;

									?></a>

									<?php if ( ! empty( $post->post_excerpt ) ) : ?>
									<figcaption class="entry-caption">
										<?php the_excerpt(); ?>
									</figcaption>
									<?php endif; ?>
								</figure>
							</div>


							<?php

							if( "" !== get_the_content() ) :
							?>
							<div class="entry-description">
								<?php the_content(); ?>
							</div>
							<?php

							endif;
							?>
						</div>
					</article>

				<?php

				comments_template();

				/* This ends the Loop. */
				endwhile;
				?>
				</main>
			</div>
			<?php

			/**
			 * Include an upwards link for user convenience.
			 *
			 * Edit parts/navigation-up.php as you see fit,
			 * or better yet ... you know the deal.
			 */
			 get_template_part( 'parts/navigation', 'up' );
			?>
		</div>
	</div>

<?php
/**
 * Include site footer.
 *
 * Check footer.php for the custom theme hook to edit theme info and
 * parts/widgets-footer.php to modify widget output in the footer.
 *
 */
get_footer();