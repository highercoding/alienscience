<?php
/**
 * Content for post lists (default)
 *
 * @package WordPress
 * @subpackage AlienScience
 */
?>

<div class="post-list-item">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( '%s', 'alienscience' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	</header><!-- .entry-header -->
    
   	<?php if(has_post_thumbnail()) { ?>
    <div class="featured-image">
   		<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail('thumbnail'); ?>
        </a>
    </div>
	<?php } elseif(function_exists('tern_wp_youtube_image')) { ?>
    <div class="featured-image">
   		<a href="<?php the_permalink(); ?>">
				<?php tern_wp_youtube_image(); ?>
        </a>
    </div>
	<?php } ?>

	<div class="entry-summary"><?php the_excerpt(); ?></div><!-- .entry-summary -->

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'alienscience' ) );
				if ( $categories_list && alienscience_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( '&raquo; %1$s', 'alienscience' ), $categories_list ); ?>
			</span>
			<span class="sep"> | </span>
			<?php endif; // End if categories ?>

		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Comments?', 'alienscience' ), __( '1 Comment', 'alienscience' ), __( '% Comments', 'alienscience' ) ); ?></span>
		
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'alienscience' ), '<span class="edit-link button-container">', '</span>' ); ?>
	</footer><!-- #entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
</div><!-- .post-list-item -->