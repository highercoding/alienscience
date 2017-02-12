<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the main wrapper and all content after
 *
 * @package WordPress
 * @subpackage AlienScience
 * @since AlienScience 0.1
 */
?>

	</div><!-- #main -->
    
	<?php if ( is_active_sidebar( 'footer-sidebar' ) ) : ?>
	<div class="footer-widgets">
		<?php dynamic_sidebar( 'footer-sidebar' ); ?>
	</div><!-- #tertiary .widget-area -->
	<?php endif; ?>

	<footer id="footer">
        
		<div id="footer-right">
			<?php if( get_theme_mod( 'alienscience_credit_link' ) != 1 ) { ?>
        	<a href="<?php echo esc_url( __( 'http://highercoding.co.uk', 'alienscience' ) ); ?>" title="<?php _e( 'Higher Coding WordPress Web Design', 'alienscience' ); ?>">
            	<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/hc.png" alt="<?php _e( 'Higher Coding WordPress Web Design', 'alienscience' ); ?>" />
            </a>
			<?php } elseif( get_theme_mod( 'alienscience_footer_logo' ) ) { ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="<?php echo esc_url( get_theme_mod( 'alienscience_footer_logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
			<?php } ?>
        </div>
        
		<div id="footer-left">
            <a class="home-link" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			<?php if( get_theme_mod( 'alienscience_credit_link' ) != 1 ) { ?>
            <p><?php _e( 'Powered by', 'alienscience' ); ?> <a href="<?php echo esc_url( __( 'http://alienscience.co.uk', 'alienscience' ) ); ?>"><?php _e( 'AlienScience Theme for WordPress', 'alienscience' ); ?></a></p>
			<?php } else { ?>
			<?php if( get_theme_mod( 'alienscience_copyright_text' ) ) { ?>
            <p><?php echo get_theme_mod( 'alienscience_copyright_text' ); ?></p>
			<?php } elseif( get_bloginfo( 'description' ) ) { ?>
            <p><?php bloginfo( 'description' ); ?></p>
			<?php } else { ?>
            <p><?php _e( 'Published under the creative commons licence', 'alienscience' ); ?></p>
			<?php } ?>
			<?php } ?>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>