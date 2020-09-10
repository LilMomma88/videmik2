<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @link http://codex.wordpress.org/Custom_Headers
 *
 * @package gossip
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses gossip_header_style()
 * @uses gossip_admin_header_style()
 * @uses gossip_admin_header_image()
 */

register_default_headers( array(
    'default-image' => array(
        'url'           => get_stylesheet_directory_uri() . '/img/banner-image.jpg',
        'thumbnail_url' => get_stylesheet_directory_uri() . '/img/banner-image.jpg',
        'description'   => __( 'Default Header Image', 'gossip' )
    ),
) );

add_theme_support( 'custom-header', array(
    // Header text display default
    'header-text'           => false,
    // Header text color default
    'default-text-color'        => '777778',
    // Header image width (in pixels)
    'width'             => 1300,
    // Header image height (in pixels)
    'height'            => 400,
    // Header image random rotation default
    'random-default'        => false,
    // Template header style callback
    'wp-head-callback'      => 'gossip_header_style',
    // Admin header style callback
    'admin-head-callback'       => 'gossip_admin_header_style',
    // Admin preview style callback
    'admin-preview-callback'    => 'gossip_admin_header_image'
) );

if ( ! function_exists( 'gossip_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see gossip_custom_header_setup().
 */
function gossip_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value.
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.gossip-title,
		.gossip-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that.
		else :
	?>
		.gossip-logo h1,
		.gossip-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // gossip_header_style

if ( ! function_exists( 'gossip_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see gossip_custom_header_setup().
 */
function gossip_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1 {
		}
		#headimg h1 a {
		}
		#desc {
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // gossip_admin_header_style

if ( ! function_exists( 'gossip_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see gossip_custom_header_setup().
 */
function gossip_admin_header_image() {
?>
	<div id="headimg">
		<h1 class="displaying-header-text">
			<a id="name" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</h1>
		<div class="displaying-header-text" id="desc" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>"><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // gossip_admin_header_image