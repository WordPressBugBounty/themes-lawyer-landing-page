<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * @package Lawyer_Landing_Page
 */

if ( ! function_exists( 'lawyer_landing_page_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function lawyer_landing_page_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Lawyer Landing Page, use a find and replace
	 * to change 'lawyer-landing-page' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'lawyer-landing-page', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

    /** Enable Page Excerpt */
    add_post_type_support( 'page', 'excerpt' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'lawyer-landing-page' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-list',
		'gallery',
		'caption',
	) );

    add_theme_support( 'post-formats', array( 'aside', 'status' ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'lawyer_landing_page_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Custom Image Size
    add_image_size( 'lawyer-landing-page-banner', 1914, 719, true );
    add_image_size( 'lawyer-landing-page-about', 456, 268, true );
    add_image_size( 'lawyer-landing-page-practice', 115, 115, true );
    add_image_size( 'lawyer-landing-page-service', 45, 45, true );
    add_image_size( 'lawyer-landing-page-testimonial', 103, 103, true );
    add_image_size( 'lawyer-landing-page-team', 261, 264, true );
    add_image_size( 'lawyer-landing-page-blog', 361, 250, true );
    add_image_size( 'lawyer-landing-page-with-sidebar', 830, 464, true );
    add_image_size( 'lawyer-landing-page-without-sidebar', 1170, 464, true );    
    add_image_size( 'lawyer-landing-page-featured', 185, 185, true );
    add_image_size( 'lawyer-landing-page-popular', 260, 145, true );
    add_image_size( 'lawyer-landing-page-recent', 78, 78, true );
    
    /** Custom Logo */
    add_theme_support( 'custom-logo', array(    	
    	'header-text' => array( 'site-title', 'site-description' ),
    ) );

}
endif;
add_action( 'after_setup_theme', 'lawyer_landing_page_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function lawyer_landing_page_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'lawyer_landing_page_content_width', 830 );
}
add_action( 'after_setup_theme', 'lawyer_landing_page_content_width', 0 );

/**
* Adjust content_width value according to template.
*
* @return void
*/
function lawyer_landing_page_template_redirect_content_width() {

	// Full Width in the absence of sidebar.
	if( is_page() ){
	   $sidebar_layout = lawyer_landing_page_sidebar_layout();
       if( ( $sidebar_layout == 'no-sidebar' ) || ! ( is_active_sidebar( 'right-sidebar' ) ) ) $GLOBALS['content_width'] = 1170;
        
	}elseif ( ! ( is_active_sidebar( 'right-sidebar' ) ) ) {
		$GLOBALS['content_width'] = 1170;
	}

}
add_action( 'template_redirect', 'lawyer_landing_page_template_redirect_content_width' );

/**
 * Enqueue scripts and styles.
 */
function lawyer_landing_page_scripts() {
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri(). '/css' . $build . '/owl.carousel' . $suffix . '.css' );
    wp_enqueue_style( 'owl-theme-default', get_template_directory_uri(). '/css' . $build . '/owl.theme.default' . $suffix . '.css' );

    if( get_theme_mod( 'ed_localgoogle_fonts',false ) && ! is_customize_preview() && ! is_admin() ){
        if ( get_theme_mod( 'ed_preload_local_fonts',false ) ) {
			lawyer_landing_page_load_preload_local_fonts( lawyer_landing_page_get_webfont_url( lawyer_landing_page_fonts_url() ) );
        }
        wp_enqueue_style( 'lawyer-landing-page-google-fonts', lawyer_landing_page_get_webfont_url( lawyer_landing_page_fonts_url() ) );
    }else{
    wp_enqueue_style( 'lawyer-landing-page-google-fonts', lawyer_landing_page_fonts_url() );
    }

	wp_enqueue_style( 'lawyer-landing-page-style', get_stylesheet_uri(), array(), LAWYER_LANDING_PAGE_THEME_VERSION );
    
    if( lawyer_landing_page_is_woocommerce_activated() )
    wp_enqueue_style( 'lawyer-landing-page-woocommerce-style', get_template_directory_uri(). '/css' . $build . '/woocommerce' . $suffix . '.css', array(), LAWYER_LANDING_PAGE_THEME_VERSION );
    
    if( is_page_template( 'template-home.php' ) )
    wp_enqueue_script( 'masonry' );
    
    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js' . $build . '/owl.carousel' . $suffix . '.js', array('jquery'), '2.2.1', true );
    wp_enqueue_script( 'owlcarousel2-a11ylayer', get_template_directory_uri() . '/js' . $build . '/owlcarousel2-a11ylayer' . $suffix . '.js', array('owl-carousel'), '0.2.1', true ); 
    wp_enqueue_script( 'jquery-nicescroll', get_template_directory_uri() . '/js' . $build . '/jquery.nicescroll' . $suffix . '.js', array('jquery'), '1.6', true );
    wp_enqueue_script( 'all', get_template_directory_uri() . '/js' . $build . '/all' . $suffix . '.js', array('jquery'), '6.1.1', true );
    wp_enqueue_script( 'lawyer-landing-page-modal-accessibility', get_template_directory_uri() . '/js' . $build . '/modal-accessibility' . $suffix . '.js', array( 'jquery' ), LAWYER_LANDING_PAGE_THEME_VERSION, true );
    wp_enqueue_script( 'v4-shims', get_template_directory_uri() . '/js' . $build . '/v4-shims' . $suffix . '.js', array('jquery'), '6.1.1', true );

    wp_enqueue_script( 'lawyer-landing-page-custom', get_template_directory_uri() . '/js' . $build . '/custom' . $suffix . '.js', array('jquery'), LAWYER_LANDING_PAGE_THEME_VERSION, true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
    
    $array = array(
        'url' => admin_url( 'admin-ajax.php' ),
        'rtl' => is_rtl(),
	);
    
    wp_localize_script( 'lawyer-landing-page-custom', 'llp_data', $array );
}
add_action( 'wp_enqueue_scripts', 'lawyer_landing_page_scripts' );

if( ! function_exists( 'lawyer_landing_page_admin_scripts' ) ) :
/**
 * Enqueue admin scripts and styles.
*/
function lawyer_landing_page_admin_scripts(){
    wp_enqueue_style( 'lawyer-landing-page-admin', get_template_directory_uri() . '/inc/css/admin.css', '', LAWYER_LANDING_PAGE_THEME_VERSION );
}
endif; 
add_action( 'admin_enqueue_scripts', 'lawyer_landing_page_admin_scripts' );

if( ! function_exists( 'lawyer_landing_page_block_editor_styles' ) ) :
    /**
     * Enqueue editor styles for Gutenberg
     */
    function lawyer_landing_page_block_editor_styles() {
    // Use minified libraries if SCRIPT_DEBUG is false
    $build  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '/build' : '';
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
    
    // Block styles.
    wp_enqueue_style( 'lawyer-landing-page-block-editor-style', get_template_directory_uri() . '/css' . $build . '/editor-block' . $suffix . '.css' );

    // Add custom fonts.
    wp_enqueue_style( 'lawyer-landing-page-google-fonts', lawyer_landing_page_fonts_url(), array(), null );

}
endif;
add_action( 'enqueue_block_editor_assets', 'lawyer_landing_page_block_editor_styles' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function lawyer_landing_page_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
    
    // Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
		$classes[] = 'custom-background-color';
	}
    
    if( !( is_active_sidebar( 'right-sidebar' ) ) ) {
        $classes[] = 'full-width'; 
    }
    
    if( lawyer_landing_page_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || 'product' === get_post_type() ) && ! is_active_sidebar( 'shop-sidebar' ) ){
        $classes[] = 'full-width';
    }
    
    if( is_page() ){
        $sidebar_layout = lawyer_landing_page_sidebar_layout();
        if( $sidebar_layout == 'no-sidebar' )
        $classes[] = 'full-width';
    }

    if( is_front_page() && is_page_template( 'template-home.php' ) ){
        $ed_banner = get_theme_mod( 'ed_banner_section' );
        $home_page = get_option( 'page_on_front' );
        if( $ed_banner && has_post_thumbnail( $home_page ) ){
            $classes[] = 'has-banner';    
        }else{
            $classes[] = 'no-banner';
        }
    }else{
        $classes[] = 'no-banner';
    }

	return $classes;
}
add_filter( 'body_class', 'lawyer_landing_page_body_classes' );

/**
 * Flush out the transients used in lawyer_landing_page_categorized_blog.
 */
function lawyer_landing_page_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'lawyer_landing_page_categories' );
}
add_action( 'edit_category', 'lawyer_landing_page_category_transient_flusher' );
add_action( 'save_post',     'lawyer_landing_page_category_transient_flusher' );

if ( ! function_exists( 'lawyer_landing_page_excerpt_more' )  ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... * 
 */
function lawyer_landing_page_excerpt_more( $more ) {
	return is_admin() ? $more : ' &hellip; ';
}
endif;
add_filter( 'excerpt_more', 'lawyer_landing_page_excerpt_more' );

if ( ! function_exists( 'lawyer_landing_page_excerpt_length' ) ) :
/**
 * Changes the default 55 character in excerpt 
*/
function lawyer_landing_page_excerpt_length( $length ) {
	return is_admin() ? $length : 40;    
}
endif;
add_filter( 'excerpt_length', 'lawyer_landing_page_excerpt_length', 999 );

if( ! function_exists( 'lawyer_landing_page_change_comment_form_default_fields' ) ) :
/**
 * Change Comment form default fields i.e. author, email & url.
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function lawyer_landing_page_change_comment_form_default_fields( $fields ){    
    // get the current commenter if available
    $commenter = wp_get_current_commenter();
 
    // core functionality
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $required = ( $req ? " required" : '' );
    $author   = ( $req ? __( 'Name*', 'lawyer-landing-page' ) : __( 'Name', 'lawyer-landing-page' ) );
    $email    = ( $req ? __( 'Email*', 'lawyer-landing-page' ) : __( 'Email', 'lawyer-landing-page' ) );
 
    // Change just the author field
    $fields['author'] = '<p class="comment-form-author"><label class="screen-reader-text" for="author">' . esc_html__( 'Name', 'lawyer-landing-page' ) . '<span class="required">*</span></label><input id="author" name="author" placeholder="' . esc_attr( $author ) . '" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $required . ' /></p>';
    
    $fields['email'] = '<p class="comment-form-email"><label class="screen-reader-text" for="email">' . esc_html__( 'Email', 'lawyer-landing-page' ) . '<span class="required">*</span></label><input id="email" name="email" placeholder="' . esc_attr( $email ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . $required. ' /></p>';
    
    $fields['url'] = '<p class="comment-form-url"><label class="screen-reader-text" for="url">' . esc_html__( 'Website', 'lawyer-landing-page' ) . '</label><input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'lawyer-landing-page' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'; 
    
    return $fields;    
}
endif;
add_filter( 'comment_form_default_fields', 'lawyer_landing_page_change_comment_form_default_fields' );

if( ! function_exists( 'lawyer_landing_page_change_comment_form_defaults' ) ) :
/**
 * Change Comment Form defaults
 * https://blog.josemcastaneda.com/2016/08/08/copy-paste-hurting-theme/
*/
function lawyer_landing_page_change_comment_form_defaults( $defaults ){    
    $defaults['comment_field'] = '<p class="comment-form-comment"><label class="screen-reader-text" for="comment">' . esc_html__( 'Comment', 'lawyer-landing-page' ) . '</label><textarea id="comment" name="comment" placeholder="' . esc_attr__( 'Comment', 'lawyer-landing-page' ) . '" cols="45" rows="8" aria-required="true" required></textarea></p>';
    
    return $defaults;    
}
endif;
add_filter( 'comment_form_defaults', 'lawyer_landing_page_change_comment_form_defaults' );

if( ! function_exists( 'lawyer_landing_page_testimonail') ):
/**
 * Ajax Callback for Testiminial content in home page.
*/
function lawyer_landing_page_testimonail(){
    $testimonial_cat = get_theme_mod( 'testimonials_section_cat' );
    $id = $_REQUEST['post_id']; // It goes through esc_sql() in WP_Query
    $qry = new WP_Query( array(    	
    	'post_type'   => 'post',
    	'post_status' => 'publish',
        'p'           => $id,
        'cat'         => $testimonial_cat
    ));
        
    if ( !empty( $id ) && $qry->have_posts() ) : 
        ob_start(); 
        while ( $qry->have_posts() ) : $qry->the_post(); ?>
        <div class="testimonial-holder">
    		<?php the_content(); ?>
	    </div>
        <?php
        endwhile;
        echo ob_get_clean();
    
    endif;
    
    wp_die(); // this is required to terminate immediately and return a proper response
}
endif;
add_action( 'wp_ajax_lawyer_landing_page_testimonial', 'lawyer_landing_page_testimonail' );
add_action( 'wp_ajax_nopriv_lawyer_landing_page_testimonial', 'lawyer_landing_page_testimonail' );

if( ! function_exists( 'lawyer_landing_page_home_section') ):
/**
 * Check if home page section are enable or not.
*/
function lawyer_landing_page_home_section(){
    $lawyer_landing_page_sections = array( 'banner', 'about', 'practice', 'service', 'testimonial', 'promotional', 'team', 'faq', 'blog' );
    $enable_section = false;
    foreach( $lawyer_landing_page_sections as $section ){ 
        if( get_theme_mod( 'ed_' . $section . '_section' ) == 1 ){
            $enable_section = true;
        }
    }
    return $enable_section;
}
endif;

if( ! function_exists( 'lawyer_landing_page_admin_notice' ) ) :
/**
 * Addmin notice for getting started page
*/
function lawyer_landing_page_admin_notice(){
    global $pagenow;
    $theme_args     = wp_get_theme();
    $meta           = get_option( 'lawyer_landing_page_admin_notice' );
    $name           = $theme_args->__get( 'Name' );
    $current_screen = get_current_screen();
    $dismissnonce   = wp_create_nonce( 'lawyer_landing_page_admin_notice' );

    if( 'themes.php' == $pagenow && !$meta ){
        
        if( $current_screen->id !== 'dashboard' && $current_screen->id !== 'themes' ){
            return;
        }

        if( is_network_admin() ){
            return;
        }

        if( ! current_user_can( 'manage_options' ) ){
            return;
        } ?>

        <div class="welcome-message notice notice-info">
            <div class="notice-wrapper">
                <div class="notice-text">
                    <h3><?php esc_html_e( 'Congratulations!', 'lawyer-landing-page' ); ?></h3>
                    <p><?php printf( __( '%1$s is now installed and ready to use. Click below to see theme documentation, plugins to install and other details to get started.', 'lawyer-landing-page' ), esc_html( $name ) ) ; ?></p>
                    <p><a href="<?php echo esc_url( admin_url( 'themes.php?page=lawyer-landing-page-dashboard' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Go to the Dashboard.', 'lawyer-landing-page' ); ?></a></p>
                    <p class="dismiss-link"><strong><a href="?lawyer_landing_page_admin_notice=1&_wpnonce=<?php echo esc_attr( $dismissnonce ); ?>"><?php esc_html_e( 'Dismiss', 'lawyer-landing-page' ); ?></a></strong></p>
                </div>
            </div>
        </div>
    <?php }
}
endif;
add_action( 'admin_notices', 'lawyer_landing_page_admin_notice' );

if( ! function_exists( 'lawyer_landing_page_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function lawyer_landing_page_update_admin_notice(){

    if (!current_user_can('manage_options')) {
        return;
    }

    if ( isset( $_GET['lawyer_landing_page_admin_notice'] ) && $_GET['lawyer_landing_page_admin_notice'] = '1' && wp_verify_nonce( $_GET['_wpnonce'], 'lawyer_landing_page_admin_notice' ) ) {
        update_option( 'lawyer_landing_page_admin_notice', true );
    }
}
endif;
add_action( 'admin_init', 'lawyer_landing_page_update_admin_notice' );