<?php
/**
 * AlienScience Theme core functions and definitions
 *
 * @package WordPress
 * @subpackage AlienScience
 */

/**
 * Set the content width based on the theme design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* px */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
if ( ! function_exists( 'alienscience_setup' ) ):
function alienscience_setup() {
	
	/**
	 * Add support for post thumbnails
	 */
	add_theme_support( 'post-thumbnails' ); 
	
	/**
	 * Load textdomain
	 */
	load_theme_textdomain( 'alienscience', get_template_directory_uri() . '/languages' );

	$locale = get_locale();
	$locale_file = get_template_directory_uri() . "/languages/$locale.php";
	if( is_readable($locale_file) )
		require_once($locale_file);
		
	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_editor_style();	

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Set up configurable navigation menus
	 */
	register_nav_menus(array(
		'primary' => __( 'Main Menu', 'alienscience' ),
	));

	/**
	 * Add support for the Aside and Gallery Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery' ) );
	
	/**
	 * Add support for Title tags
	 */
	add_theme_support( 'title-tag' );
	
	add_image_size( 'alienscience_logo', 240, 60 );
	add_theme_support( 'custom-logo', array(
   		'size' => 'alienscience_logo'
	) );
	
	add_theme_support( 'custom-background' );
	
	add_image_size( 'alienscience_slide', 300, 200 );
}
endif; // alienscience_setup


/**
 * Enqueue scripts
 */
add_action( 'wp_enqueue_scripts', 'alienscience_scripts' );
if ( ! function_exists( 'alienscience_scripts' ) ):
function alienscience_scripts() {
	
	wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/font-awesome.min.css', false, '1.0' );
	
	// Register scripts and set dependencies
	wp_register_script( 'easing', get_template_directory_uri() . '/js/jquery.easing.js', 'jquery' );
	wp_register_script( 'slider', get_template_directory_uri() . '/js/jquery.slider.min.js', 'jquery', 'easing' );
	wp_register_script( 'animatebackground', get_template_directory_uri() . '/js/jquery.animatebackground.js', 'jquery' );
	wp_register_script( 'alienscience', get_template_directory_uri() . '/as.js', 'jquery', 'slider', 'animatebackground' );
	
	// Queue scripts for dynamic linking
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'easing' );
	wp_enqueue_script( 'slider' );
	wp_enqueue_script( 'animatebackground' );
	wp_enqueue_script( 'alienscience' );
	
	// Add support and z-index fixing for flash embeds
	wp_enqueue_script( 'swfobject' );
	
}
endif;

/**
 * Tell WordPress to run alienscience_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'alienscience_setup' );

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function alienscience_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'alienscience_page_menu_args' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function alienscience_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'alienscience' ),
		'id' => 'main-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer', 'alienscience' ),
		'id' => 'footer-sidebar',
		'description' => __( 'Max. 3 widgets.', 'alienscience' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'alienscience_widgets_init' );


/**
 * Display navigation to next/previous pages when applicable
 */
if ( ! function_exists( 'alienscience_content_nav' ) ):
function alienscience_content_nav( $nav_id ) {
	global $wp_query;

	?>
	<nav id="<?php echo $nav_id; ?>">
		<p class="assistive-text section-heading"><?php _e( 'Post navigation', 'alienscience' ); ?></p>

	<?php
		// Navigation links for single posts
		if ( is_single() ) :
		
			previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&laquo;', 'Previous post', 'alienscience' ) . '</span> %title', true );
		
			next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&raquo;', 'Next post', 'alienscience' ) . '</span>', true );
		
		// Navigation links for home, archive, and search pages
		elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : ?>
        
		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&laquo;</span> Older posts', 'alienscience' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts<span class="meta-nav">&raquo;</span>', 'alienscience' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // alienscience_content_nav


/**
 * Template for comments and pingbacks.
 */
if ( ! function_exists( 'alienscience_comment' ) ) :
function alienscience_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'alienscience' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'alienscience' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
            	<!-- Comment Date & Meta -->
				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time pubdate datetime="<?php comment_time( 'c' ); ?>">
					<?php
						printf( __( '%1$s at %2$s', 'alienscience' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>
					<?php edit_comment_link( __( '(Edit)', 'alienscience' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
                
            	<!-- Comment Author Name/Avatar -->
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<strong><?php printf( __( '%s <span class="says">said:</span>', 'alienscience' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?></strong>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( '[Your comment is awaiting moderation].', 'alienscience' ); ?></em>
					<br />
				<?php endif; ?>
			</footer>

			<div class="comment-content"><blockquote><?php comment_text(); ?></blockquote></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for alienscience_comment()


/**
 * Print HTML with meta information for the current post-date/time and author.
 */
if ( ! function_exists( 'alienscience_posted_on' ) ) :
function alienscience_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="byline"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'alienscience' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'alienscience' ), get_the_author() ) ),
		esc_html( get_the_author() )
	);
}
endif;


/**
 * Add custom classes to the array of body classes.
 */
function alienscience_body_classes( $classes ) {
	// Adds a class of single-author to blogs with only 1 published author
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	return $classes;
}
add_filter( 'body_class', 'alienscience_body_classes' );

/**
 * Return true if a blog has more than 1 category
 */
function alienscience_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so alienscience_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so alienscience_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in alienscience_categorized_blog
 */
function alienscience_category_transient_flusher() {
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'alienscience_category_transient_flusher' );
add_action( 'save_post', 'alienscience_category_transient_flusher' );


/**
 * Custom logo
 */
function alienscience_custom_logo() {
    $output = '';
    if (function_exists('get_custom_logo'))
        $output = get_custom_logo();
		
    if (empty($output))
        $output = '<h1><a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a></h1><div id="site-description">' . get_bloginfo('description') . '</div>';

    echo $output;
}


/**
 * Admin functions
 */
add_action('admin_head', 'alienscience_admin_header_print');
function alienscience_admin_header_print() {
	echo '<link href="http://fonts.googleapis.com/css?family=Electrolize&subset=latin" rel="stylesheet" type="text/css">';
}


/**
 * Admin notices
 */
function alienscience_update_notice() {
    if ( !get_theme_mod( 'alienscience_credit_link' ) ) {
        return;
    }
    ?>
    <div class="notice updated">
        <p><?php _e( 'Thank you for using AlienScience theme. Please support this free theme by', 'alienscience' ); ?> <a href="<?php echo esc_url( __( 'http://alienscience.co.uk/upgrade', 'alienscience' ) ); ?>" target="_blank"><?php _e( 'upgrading.', 'alienscience' ) ?></a></p>
    </div>
    <?php
}
add_action( 'admin_notices', 'alienscience_update_notice' );


/**
 * Custom settings
 */
function alienscience_custom_settings( $wp_customize ) {
	
	// Custom section
	$wp_customize->add_section( 'alienscience_footer' , array(
   		'title'      => __( 'Footer', 'alienscience' ),
   		'priority'   => 117,
	) );
	
	// Credit link
	$wp_customize->add_setting( 'alienscience_credit_link' , array(
    	'default'	=> 0,
		'sanitize_callback'	=> 'esc_attr',
	) );
	$wp_customize->add_control( 
    	new WP_Customize_Control(
        	$wp_customize,
        	'alienscience_credit_link',
        	array(
            	'label'     => __('Hide Credit', 'alienscience'),
            	'section'   => 'alienscience_footer',
            	'settings'  => 'alienscience_credit_link',
           		'type'      => 'checkbox',
			)
		)
	);
	
	// Copyright text
	$wp_customize->add_setting( 'alienscience_copyright_text' , array(
    	'default'     		=> 'Published under the creative commons licence.',
		'sanitize_callback'	=> 'esc_attr',
	) );
	$wp_customize->add_control( 
    	new WP_Customize_Control(
        	$wp_customize,
        	'alienscience_copyright_text',
        	array(
            	'label'     => __('Copyright Text', 'alienscience'),
            	'section'   => 'alienscience_footer',
            	'settings'  => 'alienscience_copyright_text',
           		'type'      => 'text',
			)
		)
	);
	
	// Footer logo
	$wp_customize->add_setting( 'alienscience_footer_logo', array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'alienscience_footer_logo',
			array(
   				'label'    => __( 'Footer Logo', 'alienscience' ),
    			'section'  => 'alienscience_footer',
    			'settings' => 'alienscience_footer_logo',
			)
		)
	);
	
}
add_action( 'customize_register', 'alienscience_custom_settings' );


/**
 * This theme was built with PHP, Semantic HTML5, jQuery, CSS and Alien Science by Higher Coding.
 */