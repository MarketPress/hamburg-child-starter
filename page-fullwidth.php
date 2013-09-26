<?php
/**
 * Template Name: Full Width
 *
 * @package    Hamburg
 * @subpackage Templates
 */

/**
 * Add translation for template name.
 */
$template_name = __( 'Full Width', 'theme_hamburg_textdomain' );

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
				/**
				 * Houston, we have a post!
				 *
				 * This starts the Loop, by the way.
				 *
				 */
				while ( have_posts() ) :

					/* Put some food on the table. */
					the_post();

						/**
						 * Include a template part specific to pages.
						 * Uses parts/content-page.php.
						 *
						 * If you want to override this in a child theme,
						 * create a file named content-page.php and drop
						 * it into the parts/ folder of your Child Theme.
						 *
						 */
						get_template_part( 'parts/content', 'page' );

						/**
						 * Include comments.
						 *
						 * When comments are open or we have at least one comment,
						 * let's load the comment template.
						 *
						 */
						if ( comments_open() || 0 !== (int) get_comments_number() )
							comments_template( '', TRUE );

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
 */
get_footer();