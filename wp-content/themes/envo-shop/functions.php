<?php
/**
 * The current version of the theme.
 */


// my-account-function
include dirname(__FILE__) . '/custom-functions/product_video.php';


define('ENVO_SHOP_VERSION', '1.0.4');

add_action('after_setup_theme', 'envo_shop_setup');

if (!function_exists('envo_shop_setup')) :

    /**
     * Global functions
     */
    function envo_shop_setup() {

        // Theme lang.
        load_theme_textdomain('envo-shop', get_template_directory() . '/languages');

        // Add Title Tag Support.
        add_theme_support('title-tag');

        // Register Menus.
        register_nav_menus(
            array(
                'main_menu' => esc_html__('Main Menu', 'envo-shop'),
                'main_menu_right' => esc_html__('Main Menu Right', 'envo-shop'),
                'main_menu_cats' => esc_html__('Categories Menu', 'envo-shop'),
            )
        );

        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(300, 300, true);
        add_image_size('envo-shop-single', 1140, 641, true);
        add_image_size('envo-shop-med', 720, 405, true);

        // Add Custom Background Support.
        $args = array(
            'default-color' => 'ffffff',
        );
        add_theme_support('custom-background', $args);

        add_theme_support('custom-logo', array(
            'height' => 60,
            'width' => 200,
            'flex-height' => true,
            'flex-width' => true,
            'header-text' => array('site-title', 'site-description'),
        ));

        // Adds RSS feed links to for posts and comments.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         */
        add_theme_support('title-tag');

        // Set the default content width.
        $GLOBALS['content_width'] = 1140;

        add_theme_support('custom-header', apply_filters('envo_shop_custom_header_args', array(
            'width' => 2000,
            'height' => 200,
            'default-text-color' => '',
            'wp-head-callback' => 'envo_shop_header_style',
        )));

        // WooCommerce support.
        add_theme_support('woocommerce');
        add_theme_support('wc-product-gallery-zoom');
        add_theme_support('wc-product-gallery-lightbox');
        add_theme_support('wc-product-gallery-slider');
        add_theme_support('html5', array('search-form'));
        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style(array('css/bootstrap.css', envo_shop_fonts_url(), 'css/editor-style.css'));

        // Recommend plugins.
        add_theme_support('recommend-plugins', array(
            'envothemes-demo-import' => array(
                'name' => 'EnvoThemes Demo Import',
                'active_filename' => 'envothemes-demo-import/envothemes-demo-import.php',
                'description' => esc_html__('Save time by importing our demo data: your website will be set up and ready to be customized in minutes.', 'envo-shop'),
            ),
            'woocommerce' => array(
                'name' => 'WooCommerce',
                'active_filename' => 'woocommerce/woocommerce.php',
                /* translators: %s plugin name string */
                'description' => sprintf(esc_attr__('To enable shop features, please install and activate the %s plugin.', 'envo-shop'), '<strong>WooCommerce</strong>'),
            ),
            'elementor' => array(
                'name' => 'Elementor',
                'active_filename' => 'elementor/elementor.php',
                /* translators: %s plugin name string */
                'description' => sprintf(esc_attr__('The most advanced frontend drag & drop page builder.', 'envo-shop'), '<strong>Elementor</strong>'),
            ),
        ));

    }

endif;

if (!function_exists('envo_shop_header_style')) :

    /**
     * Styles the header image and text displayed on the blog.
     */
    function envo_shop_header_style() {
        $header_image = get_header_image();
        $header_text_color = get_header_textcolor();
        if (get_theme_support('custom-header', 'default-text-color') !== $header_text_color || !empty($header_image)) {
            ?>
            <style type="text/css" id="envo-shop-header-css">
            <?php
            // Has a Custom Header been added?
            if (!empty($header_image)) :
                ?>
                    .site-header {
                        background-image: url(<?php header_image(); ?>);
                        background-repeat: no-repeat;
                        background-position: 50% 50%;
                        -webkit-background-size: cover;
                        -moz-background-size:    cover;
                        -o-background-size:      cover;
                        background-size:         cover;
                    }
            <?php endif; ?>
            <?php
            // Has the text been hidden?
            if ('blank' === $header_text_color) :
                ?>
                    .site-title,
                    .site-description {
                        position: absolute;
                        clip: rect(1px, 1px, 1px, 1px);
                    }
            <?php elseif ('' !== $header_text_color) : ?>
                    .site-title a,
                    .site-title,
                    .site-description {
                        color: #<?php echo esc_attr($header_text_color); ?>;
                    }
            <?php endif; ?>
            </style>
            <?php
        }
    }

endif; // envo_shop_header_style

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function envo_shop_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}

add_action('wp_head', 'envo_shop_pingback_header');

/**
 * Set Content Width
 */
function envo_shop_content_width() {

    $content_width = $GLOBALS['content_width'];

    if (is_active_sidebar('envo-shop-right-sidebar')) {
        $content_width = 750;
    } else {
        $content_width = 1040;
    }

    /**
     * Filter content width of the theme.
     */
    $GLOBALS['content_width'] = apply_filters('envo_shop_content_width', $content_width);
}

add_action('template_redirect', 'envo_shop_content_width', 0);

/**
 * Register custom fonts.
 */
function envo_shop_fonts_url() {
    $fonts_url = '';

    /**
     * Translators: If there are characters in your language that are not
     * supported by Open Sans Condensed, translate this to 'off'. Do not translate
     * into your own language.
     */
    $font = _x('on', 'Open Sans Condensed font: on or off', 'envo-shop');

    if ('off' !== $font) {
        $font_families = array();

        $font_families[] = 'Open Sans Condensed:300,500,700';

        $query_args = array(
            'family' => urlencode(implode('|', $font_families)),
            'subset' => urlencode('cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese'),
        );

        $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    }

    return esc_url_raw($fonts_url);
}

/**
 * Add preconnect for Google Fonts.
 */
function envo_shop_resource_hints($urls, $relation_type) {
    if (wp_style_is('envo-shop-fonts', 'queue') && 'preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }

    return $urls;
}

add_filter('wp_resource_hints', 'envo_shop_resource_hints', 10, 2);

/**
 * Enqueue Styles (normal style.css and bootstrap.css)
 */
function envo_shop_theme_stylesheets() {
    // Add custom fonts, used in the main stylesheet.
    wp_enqueue_style('envo-shop-fonts', envo_shop_fonts_url(), array(), null);
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.7');
    wp_enqueue_style('mmenu-light', get_template_directory_uri() . '/css/mmenu-light.min.css', array(), ENVO_SHOP_VERSION);
    // Theme stylesheet.
    wp_enqueue_style('envo-shop-stylesheet', get_stylesheet_uri(), array('bootstrap'), ENVO_SHOP_VERSION);
    // Load Font Awesome css.
    wp_enqueue_style('line-awesome', get_template_directory_uri() . '/css/line-awesome.min.css', array(), '1.3.0');
}

add_action('wp_enqueue_scripts', 'envo_shop_theme_stylesheets');

/**
 * Register Bootstrap JS with jquery
 */
function envo_shop_theme_js() {
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.3.7', true);
    wp_enqueue_script('envo-shop-theme-js', get_template_directory_uri() . '/js/customscript.js', array('jquery'), ENVO_SHOP_VERSION, true);
    wp_enqueue_script('mmenu', get_template_directory_uri() . '/js/mmenu-light.min.js', array('jquery'), ENVO_SHOP_VERSION, true);
}

add_action('wp_enqueue_scripts', 'envo_shop_theme_js');

if (!function_exists('envo_shop_is_pro_activated')) {

    /**
     * Query Envo Shop activation
     */
    function envo_shop_is_pro_activated() {
        return defined('ENVO_SHOP_PRO_CURRENT_VERSION') ? true : false;
    }

}

if (!function_exists('envo_shop_title_logo')) {

    /**
     * Title, logo code
     */
    function envo_shop_title_logo() {
        ?>
            <div class="site-branding-logo">
                <?php the_custom_logo(); ?>
            </div>
            <div class="site-branding-text">
                <?php if (is_front_page()) : ?>
                    <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                <?php else : ?>
                    <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
                <?php endif; ?>

                <?php
                $description = get_bloginfo('description', 'display');
                if ($description || is_customize_preview()) :
                    ?>
                    <p class="site-description">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>
            </div><!-- .site-branding-text -->
        <?php
    }

}

if (!function_exists('envo_shop_categories_menu')) {

    /**
     * Categories menu. Displayed only if exists. Not loaded on mobile devices
     */
    function envo_shop_categories_menu() {
        if (has_nav_menu('main_menu_cats')) {
            ?>
            <ul class="envo-categories-menu hidden-xs nav navbar-nav navbar-left">
                <li class="menu-item menu-item-has-children dropdown">
                    <a class="envo-categories-menu-first" href="#">
                        <?php esc_html_e('Categories','envo-shop');?>
                    </a>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'main_menu_cats',
                    'depth' => 5,
                    'container_id' => 'menu-right',
                    'container' => 'ul',
                    'container_class' => '',
                    'menu_class' => 'dropdown-menu',
                    'fallback_cb' => 'Envo_Shop_WP_Bootstrap_Navwalker::fallback',
                    'walker' => new Envo_Shop_WP_Bootstrap_Navwalker(),
                ));
                ?>
                 </li>
            </ul>
            <?php
        }
    }

}
/**
 * Register Custom Navigation Walker include custom menu widget to use walkerclass
 */
require_once( trailingslashit(get_template_directory()) . 'lib/wp_bootstrap_navwalker.php' );

/**
 * Register Theme Info Page
 */
require_once( trailingslashit(get_template_directory()) . 'lib/dashboard.php' );

if (class_exists('WooCommerce')) {

    /**
     * WooCommerce options
     */
    require_once( trailingslashit(get_template_directory()) . 'lib/woocommerce.php' );
}

add_action('widgets_init', 'envo_shop_widgets_init');

/**
 * Register the Sidebar(s)
 */
function envo_shop_widgets_init() {
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar', 'envo-shop'),
            'id' => 'envo-shop-right-sidebar',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widget-title"><h3>',
            'after_title' => '</h3></div>',
        )
    );
    register_sidebar(
        array(
            'name' => esc_html__('Top Bar Section', 'envo-shop'),
            'id' => 'envo-shop-top-bar-area',
            'before_widget' => '<div id="%1$s" class="widget %2$s col-sm-4">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widget-title"><h3>',
            'after_title' => '</h3></div>',
        )
    );
    register_sidebar(
        array(
            'name' => esc_html__('Header Section', 'envo-shop'),
            'id' => 'envo-shop-header-area',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widget-title"><h3>',
            'after_title' => '</h3></div>',
        )
    );
    register_sidebar(
        array(
            'name' => esc_html__('Footer Section', 'envo-shop'),
            'id' => 'envo-shop-footer-area',
            'before_widget' => '<div id="%1$s" class="widget %2$s col-md-3">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widget-title"><h3>',
            'after_title' => '</h3></div>',
        )
    );
}

function envo_shop_main_content_width_columns() {

    $columns = '12';

    if (is_active_sidebar('envo-shop-right-sidebar')) {
        $columns = $columns - 3;
    }

    echo absint($columns);
}

if (!function_exists('envo_shop_entry_footer')) :

    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function envo_shop_entry_footer() {

        // Get Categories for posts.
        $categories_list = get_the_category_list(' ');

        // Get Tags for posts.
        $tags_list = get_the_tag_list('', ' ');

        // We don't want to output .entry-footer if it will be empty, so make sure its not.
        if ($categories_list || $tags_list || get_edit_post_link()) {

            echo '<div class="entry-footer">';

            if ('post' === get_post_type()) {
                if ($categories_list || $tags_list) {

                    // Make sure there's more than one category before displaying.
                    if ($categories_list) {
                        echo '<div class="cat-links"><span class="space-right">' . esc_html__('Category', 'envo-shop') . '</span>' . wp_kses_data($categories_list) . '</div>';
                    }

                    if ($tags_list) {
                        echo '<div class="tags-links"><span class="space-right">' . esc_html__('Tags', 'envo-shop') . '</span>' . wp_kses_data($tags_list) . '</div>';
                    }
                }
            }

            edit_post_link();

            echo '</div>';
        }
    }

endif;

if (!function_exists('envo_shop_generate_construct_footer')) :
    /**
     * Build footer
     */
    add_action('envo_shop_generate_footer', 'envo_shop_generate_construct_footer');

    function envo_shop_generate_construct_footer() {
        ?>
        <div class="footer-credits-text text-center">
            <?php
            /* translators: %s: WordPress name with wordpress.org URL */
            //printf(esc_html__('Proudly powered by %s', 'envo-shop'), '<a href="' . esc_url(__('https://wordpress.org/', 'envo-shop')) . '">' . esc_html__('WordPress', 'envo-shop') . '</a>');
            ?>
            Copyright 2020
            <span class="sep"> | </span> Videmik
            <?php
            /* translators: %1$s: Envo Shop theme name (do not translate) with envothemes.com URL */
            //printf(esc_html__('Theme: %1$s', 'envo-shop'), '<a href="' . esc_url('https://envothemes.com/free-envo-shop/') . '">' . esc_html_x('Envo Shop', 'Theme name, do not translate', 'envo-shop') . '</a>');
            ?>
        </div>
        <?php
    }

endif;


if (!function_exists('envo_shop_widget_date')) :

    /**
     * Returns date for widgets.
     */
    function envo_shop_widget_date() {
        ?>
        <span class="posted-date">
            <?php echo esc_html(get_the_date()); ?>
        </span>
        <?php
    }

endif;

if (!function_exists('envo_shop_widget_comments')) :

    /**
     * Returns date for widgets.
     */
    function envo_shop_widget_comments() {
        ?>
        <span class="comments-meta">
            <?php
            if (!comments_open()) {
                esc_html_e('Off', 'envo-shop');
            } else {
                ?>
                <a href="<?php the_permalink(); ?>#comments" rel="nofollow" title="<?php esc_attr_e('Comment on ', 'envo-shop') . the_title_attribute(); ?>">
                    <?php echo absint(get_comments_number()); ?>
                </a>
            <?php } ?>
            <i class="la la-comments-o"></i>
        </span>
        <?php
    }

endif;

if (!function_exists('envo_shop_excerpt_length')) :

    /**
     * Excerpt limit.
     */
    function envo_shop_excerpt_length($length) {
        return 20;
    }

    add_filter('excerpt_length', 'envo_shop_excerpt_length', 999);

endif;

if (!function_exists('envo_shop_excerpt_more')) :

    /**
     * Excerpt more.
     */
    function envo_shop_excerpt_more($more) {
        return '&hellip;';
    }

    add_filter('excerpt_more', 'envo_shop_excerpt_more');

endif;

if (!function_exists('envo_shop_thumb_img')) :

    /**
     * Returns widget thumbnail.
     */
    function envo_shop_thumb_img($img = 'full', $col = '', $link = true, $single = false) {
        if (function_exists('envo_shop_pro_thumb_img')) {
            envo_shop_pro_thumb_img($img, $col, $link, $single);
        } elseif (( has_post_thumbnail() && $link == true)) {
            ?>
            <div class="news-thumb <?php echo esc_attr($col); ?>">
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php the_post_thumbnail($img); ?>
                </a>
            </div><!-- .news-thumb -->
        <?php } elseif (has_post_thumbnail()) { ?>
            <div class="news-thumb <?php echo esc_attr($col); ?>">
                <?php the_post_thumbnail($img); ?>
            </div><!-- .news-thumb -->
            <?php
        }
    }

endif;

/**
 * Single previous next links
 */
if (!function_exists('envo_shop_prev_next_links')) :

    function envo_shop_prev_next_links() {
        the_post_navigation(
                array(
                    'prev_text' => '<span class="screen-reader-text">' . __('Previous Post', 'envo-shop') . '</span><span aria-hidden="true" class="nav-subtitle">' . __('Previous', 'envo-shop') . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper"><i class="la la-angle-double-left" aria-hidden="true"></i></span>%title</span>',
                    'next_text' => '<span class="screen-reader-text">' . __('Next Post', 'envo-shop') . '</span><span aria-hidden="true" class="nav-subtitle">' . __('Next', 'envo-shop') . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper"><i class="la la-angle-double-right" aria-hidden="true"></i></span></span>',
                )
        );
    }

endif;

/**
 * Post author meta funciton
 */
if (!function_exists('envo_shop_author_meta')) :

    function envo_shop_author_meta() {
        ?>
        <span class="author-meta">
            <span class="author-meta-by"><?php esc_html_e('By', 'envo-shop'); ?></span>
            <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename'))); ?>">
                <?php the_author(); ?>
            </a>
        </span>
        <?php
    }

endif;

if (!function_exists('wp_body_open')) :

    /**
     * Fire the wp_body_open action.
     *
     * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
     *
     */
    function wp_body_open() {
        /**
         * Triggered after the opening <body> tag.
         *
         */
        do_action('wp_body_open');
    }

endif;

/**
 * Skip to content link
 */
function envo_shop_skip_link() {
	echo '<a class="skip-link screen-reader-text" href="#site-content">' . esc_html__( 'Skip to the content', 'envo-shop' ) . '</a>';
}

add_action( 'wp_body_open', 'envo_shop_skip_link', 5 );



// hide menus on dashboard for non super admin account
add_action( 'admin_menu', 'rename_woocoomerce', 999 );
function rename_woocoomerce(){
    global $menu, $current_user;

    $user = wp_get_current_user();

    // Pinpoint menu item
    $woo = rename_woocommerce( 'WooCommerce', $menu );
        if( $woo ) $menu[$woo][0] = 'Order Management';
    // Validate
    if (@$user->data->user_nicename != 'super-admin' || $user->roles[0] !=  'administrator') {
        $comm = rename_woocommerce( 'Comments', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'Elementor', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'Jetpack', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'Templates', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'Pages', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'Posts', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'Appearance', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'YITH', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'Users', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'Settings', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'Plugins', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'Media', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'Links', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'menu-plugins', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'menu-tools', $menu );
        if( $comm ) unset($menu[$comm]);
        $comm = rename_woocommerce( 'qwc_settings', $menu );
        if( $comm ) unset($menu[$comm]);
    }
}

function rename_woocommerce( $needle, $haystack )
{
  foreach( $haystack as $key => $value )
  {
    $current_key = $key;
    // dd($value);
    if ($needle == "Comments" && @$haystack[2] == "edit-comments.php") {
        return $current_key;
    }
    if($needle === $value OR (is_array( $value ) && rename_woocommerce( $needle, $value ) !== false )){
        return $current_key;
    }
  }
  return false;
}



// only 1 product per cart
// function bbloomer_only_one_in_cart( $passed, $added_product_id ) {
//    wc_empty_cart();
//    return $passed;
// }
// add_filter( 'woocommerce_add_to_cart_validation', 'bbloomer_only_one_in_cart', 99, 2 );

// disable magnify
function remove_image_zoom_support() {
    remove_theme_support( 'wc-product-gallery-zoom' );
}
add_action( 'after_setup_theme', 'remove_image_zoom_support', 100 );

// dd(get_template_directory_uri());
// p_register_style("custom", get_template_directory_uri() . "/css/custom.css", '', '1.0.1');

/**
 * Adds a section with custom downloadable files to the "View Order Screen"
 *    if the order has a "custom_file" custom field with a download ID
 * Requires Download Monitor
 *
 * @param int $order_id the ID of the order being viewed
 */
function sww_add_custom_file_view_order( $order_id ) {

	$order = wc_get_order( $order_id );

	// only add our section if the order is paid for
	if ( ! $order->is_paid() ) {
		return;
	}

	$order_id = is_callable( array( $order, 'get_id' ) ) ? $order->get_id() : $order->id;

	// add our section to shown download links if the order has the custom_file field set
	if ( $file_id = (int) get_post_meta( $order_id, 'custom_file', true ) ) {

		$content = '<h3>Custom Files</h3>';
		$content .= do_shortcode( '[download id="' . $file_id . '"]' );
		echo $content;
	}
}
add_action( 'woocommerce_view_order', 'sww_add_custom_file_view_order', 9 );

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
     unset($fields['billing']['billing_company']);
	 unset($fields['billing']['billing_address_1']);
	 unset($fields['billing']['billing_address_2']);
	 unset($fields['billing']['billing_country']);
	 unset($fields['billing']['billing_state']);
	 unset($fields['billing']['billing_postcode']);
	 unset($fields['billing']['billing_email']);
	 unset($fields['billing']['billing_city']);
     return $fields;
} 