<?php
/**
 * The Header - for all posts, pages, archives, post lists, search results, tags, categories...
 *
 * @package WordPress
 * @subpackage AlienScience
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link href="http://fonts.googleapis.com/css?family=Electrolize&subset=latin" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Orbitron&subset=latin" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<?php if( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); // Loads jQuery, swfobject, page meta and all plugin wp_head hooks ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed">

	<header id="branding">
		<div id="header">
        	<?php alienscience_custom_logo(); ?>
            <?php if( !is_user_logged_in() ) { ?>
            <nav id="login" class="nav-menu">
            	<a href="/wp-login.php" class="simplemodal-login" title="You can also press CTRL + ALT + L"><?php _e( 'Login', 'alienscience' ); ?></a>
                <?php if( get_option('users_can_register') ) { ?>
				<a href="/wp-login.php?action=register" class="simplemodal-register"><?php _e( 'Sign-up', 'alienscience' ); ?></a>
           		<?php } ?>
            </nav>
            <?php } ?>
		</div>

		<nav id="access">
        
            	<?php
				/* Header icons */
				$header_icons = new WP_Query( 'post_status=publish&posts_per_page=4&post_type=icons&orderby=menu_order' );
				if( $header_icons->have_posts() ) {
				?>
            <div class="header-icons">
				<?php
					while( $header_icons->have_posts() ) {
						$header_icons->the_post();
						$icon_link = get_post_meta( $post->ID, 'icon_link', true );
						$icon_class = get_post_meta( $post->ID, 'icon_class', true );
						if( has_post_thumbnail() || !empty( $icon_class ) ) {
							if( has_post_thumbnail() ) $icon_url = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), array( 64, 64 ) );
				?>
            	<a class="header-button" href="<?php echo $icon_link; ?>">
					<span class="button-text"><?php the_title(); ?></span>
                    <?php if( !empty( $icon_class ) ) { // empty( $icon_url[0] ) && ?>
                    <i class="button-fa fa <?php echo $icon_class; ?>"></i>
                    <?php } elseif( !empty( $icon_url[0] ) ) { ?>
               		<img class="button-icon" src="<?php echo esc_url( $icon_url[0] ); ?>" alt="<?php the_title(); ?>" />
                    <?php } ?>
            	</a>
                <?php
						}
					}
				?>
            </div>
			<?php
				}
				// Reset the WP loop
				wp_reset_query();
			?>
            
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
            
		</nav><!-- #access -->
	</header><!-- #branding -->

	<div id="main">
    
    	<?php
		if( is_front_page() ) {
			/* Get slider slides */
			$slides_count = 0;
			$slider_slides = new WP_Query( 'post_status=publish&posts_per_page=8&post_type=slides&orderby=menu_order' );
			if( $slider_slides->have_posts() ) {
			?>
        <div id="slider">
			<?php 
				while( $slider_slides->have_posts() ) {
					$slider_slides->the_post();
					$slide_link = get_post_meta( $post->ID, 'slide_link', true );
					$slide_class = get_post_meta( $post->ID, 'slide_class', true );
					$slide_action = get_post_meta( $post->ID, 'slide_action', true );
					$slides_count++; ?>
			<div class="slide">
				<?php if( !has_post_thumbnail() && !empty( $slide_class ) ) { ?>
                <?php if( !empty( $slide_link ) ) { ?>
                <div class="slide-image"><a href="<?php echo $slide_link; ?>"><i class="button-fa fa <?php echo $slide_class; ?>"></i></a></div>
                <?php } else { ?>
               <div class="slide-image"><i class="button-fa fa <?php echo $slide_class; ?>"></i></div>
                <?php } ?>
                <?php } elseif( has_post_thumbnail() ) { ?>
                <?php if( !empty( $slide_link ) ) { ?>
				<div class="slide-image"><a href="<?php echo $slide_link; ?>"><?php the_post_thumbnail( 'alienscience_slide' ); ?></a></div>
                <?php } else { ?>
				<div class="slide-image"><?php the_post_thumbnail( 'alienscience_slide' ); ?></div>
                <?php } ?>
                <?php } ?>
                <?php if( $slides_count == 1 ) { ?>
				<h1 class="slide-title"><?php the_title(); ?></h1>
                <?php } else { ?>
				<h2 class="slide-title"><?php the_title(); ?></h2>
                <?php } ?>
				<div class="slide-text"><?php the_content(); ?></div>
                <?php if( !empty( $slide_action ) && !empty( $slide_link ) ) { ?>
				<?php edit_post_link( __( 'Edit', 'alienscience' ) , '<span class="edit-link button-container">', '</span>' ); ?>
				<div class="slide-button"><a class="button" href="<?php echo $slide_link; ?>"><?php echo $slide_action; ?></a></div>
           		<?php } ?>
            </div>
            <?php } ?>
		</div>	
		<?php } } ?>