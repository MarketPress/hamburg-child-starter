<?php
/**
 * Template Name: Sidebar Left
 *
 * @package    Hamburg
 * @subpackage Templates
 */

/**
 * Add translation for template name.
 */
$template_name = __( 'Sidebar Left', 'theme_hamburg_textdomain' );

/**
 * Get site header.
 */
get_header();

?>
	<div class="site-main sidebar-left">
		<div class="row">
			<div id="primary" class="content-area<?php echo hamburg_content_area_class(); ?>">
				<?php
				/**
				 * Main Content.
				 *
				 * The <main> element is used to enclose the main content
				 * ("main" translating to the central topic of a document).
				 * ARIA landmark role "main" is recommended for the <main>
				 * element until user agents implement role mapping.
				 *
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
						 */
						get_template_part( 'parts/content', 'page' );

						/**
						 * Include comments.
						 *
						 * When comments are open or we have at least one comment,
						 * let's load the comment template.
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
			 * Include sidebars.
			 *
			 * We skip sidebar.php and load our sidebar templates directly.
			 * If you need to edit this, go straight to parts/widgets-secondary.php.
			 *
			 */
			 get_template_part( 'parts/widgets', 'secondary' );

			/**
			 * Include an upwards link for user convenience.
			 *
			 * Edit parts/navigation-up.php as you see fit,
			 * or better yet ... you know the deal.
			 *
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