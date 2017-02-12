<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage AlienScience
 * @since AlienScience 0.1
 */

get_header(); ?>

	<div id="primary">
		<div id="content" role="main">

			<article id="404-page" class="post error404 not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Error 404', 'alienscience' ); ?></h1>
				</header>

				<div class="entry-content">
                
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'alienscience' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>