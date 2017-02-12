<?php
/**
 * Page Content Template
 *
 * @package WordPress
 * @subpackage AlienScience
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
    	<span class="right"><?php if(has_post_thumbnail()) the_post_thumbnail(); ?></span>
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'alienscience' ), 'after' => '</div>' ) ); ?>
		<?php edit_post_link( __( 'Edit', 'alienscience' ), '<span class="edit-link button-container">', '</span>' ); ?>
	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
